<?php

namespace App\Livewire\Client;

use Endroid\QrCode\Builder\Builder;
use App\Models\Client;
use App\Models\DetailVoucher;
use App\Models\Entrega;
use App\Models\Factura;
use App\Models\Payment;
use App\Models\Voucher;
use App\Models\YapePage;
use App\Models\YapePayment;
// use DragonCode\Contracts\Cashier\Auth\Auth;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Encoding\Encoding;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class PaymenYape extends Component
{
    use WithFileUploads;
    use WireToast;

    public $image;
    public $yapepayment;
    public $estadoCarga;

    protected $listeners = ['render'];

    protected $rules = [
        'yapepayment.name' => 'required',
        'yapepayment.fecha' => 'required|date',
        'yapepayment.operacion' => 'required|digits:7',
        'yapepayment.image' => 'required|image|max:1024',
    ];

    public function mount()
    {
        $this->estadoCarga = false;
        $nombres = Auth::user()->name;
        $this->yapepayment = [
            'name' => $nombres,
            'image' => null,
            'operacion' => 0,
        ];
    }

    public function render()
    {
        $total = session('precioPlan');
        $yapepage = YapePage::latest()->take(1)->get();

        $yapepayment = Payment::all();

        return view('livewire.client.payment-yape', compact('total', 'yapepage', 'yapepayment'));
    }

    public function store(Request $request)
    {
        $this->validate();
        $this->estadoCarga = true;

        $userDni = Auth::user()->dni;
        $userEmail = Auth::user()->email;

        $token = 'apis-token-11587.OZhpnnRAE0c06mr4RMIfswNvqBPAwAN0';

        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar dni
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $userDni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $persona = json_decode($response, true);

        if (isset($persona['message']) && in_array($persona['message'], ['dni no valido', 'not found'])) {
            toast()->danger('El DNI no es válido, ingrese nuevamente', 'Mensaje de error')->push();
        
            return redirect()->back();
        }        

        toast()->success('DNI encontrado y validado correctamente', 'Mensaje de éxito')->push();
        // dd($persona, $response);

        session(['client_data' => $persona]);

        if (session()->has(['client_data'])) {
            // Guardar en la Base de datos -> START
            $clientData = session('client_data');
            $cliente = Client::create([
                'email' => $userEmail,
                'phone' => $clientData['phone'] ?? 'Sin Número',
                'name' => $clientData['nombres'],
                'paterno' => $clientData['apellidoPaterno'],
                'materno' => $clientData['apellidoMaterno'],
                'address' => $clientData['address'] ??'Sin Dirección',
                'document' => $clientData['numeroDocumento'],
                'postal' => $clientData['postal'] ?? 'Sin N° Postal',
                'tdatos' => $clientData['tdatos'] ?? '1',
            ]);

            // Almacenar el cliente en la sesión
            session(['client' => $cliente]);

            // Obtener la información del cliente desde la sesión
            $client = session('client');

            $total = session('precioPlan');

            $ultimoCnumero = Voucher::max('numero');

            if (!$ultimoCnumero) {
                $numero = 'SPD009000'; // Agregamos 'IFP' al principio si no hay número anterior
            } else {
                $numero_parte_numerica = intval(substr($ultimoCnumero, 3));
                $numero_parte_numerica++;
                $numero_parte_numerica = str_pad($numero_parte_numerica, 8, '0', STR_PAD_LEFT);
                $numero = 'SPD' . $numero_parte_numerica;
            }

            $proforma = new Voucher();
            $proforma->client_id = $client->id;
            $proforma->tipo = 'BOLETA DE COMPRA';
            $proforma->numero = $numero;
            $proforma->fecha = date('Y-m-d');
            $proforma->total = $total;
            $proforma->status = 'PE';
            $proforma->leido = '1';
            $proforma->metodo_pago = 'Yape';

            $proforma->save();

            session(['voucher' => $proforma]);

            // Obtener la información del cliente desde la sesión
            $voucherId = session('voucher');

            $this->generarCodigoQR($voucherId->id);
        }

        // Obtener el último código registrado
        $ultimoCodigo = Payment::max('codigo');

        // Si no hay registros, comenzar desde "00000009000"
        if (!$ultimoCodigo) {
            $codigo = '00000009000';
        } else {
            // Convertir el número a entero y agregar 1
            $codigo = intval($ultimoCodigo) + 1;

            // Formatear el número como cadena con ceros a la izquierda
            $codigo = str_pad($codigo, 11, '0', STR_PAD_LEFT);
        }

        $voucherId = session('voucher');

        $yapeData = $request->except('_token');
        $yapeData['operacion'] = $this->yapepayment['operacion'];
        $yapeData['name'] = $this->yapepayment['name'];
        $yapeData['fecha'] = $this->yapepayment['fecha'];
        $yapeData['codigo'] = $codigo;

        // dd($voucherId);
        $yapeData['voucher_id'] = $voucherId->id; // Obtener el ID del voucher

        // Crear una nueva instancia del modelo YapePayment y guardarla en la base de datos
        $yape = Payment::create($yapeData);

        if ($this->yapepayment['image']) {
            $image = Storage::disk('public')->put('yape', $this->yapepayment['image']);
            $yape->imageyape()->create([
                'url' => $image,
            ]);
        }

        if ($yape) {

            $statusMessage = '¡Gracias! El pago a través de Yape se ha realizado correctamente.';
            $statusType = 'success';

            // Redirigir a '/results' con un mensaje de éxito y la información de la proforma
            return redirect('/results')->with(compact('statusMessage', 'statusType'));
        }

        // Si el estado del pago no es 'approved', significa que el pago no se realizó con éxito
        $statusMessage = '¡Lo sentimos! El pago a través de Yape no se pudo realizar.';
        $statusType = 'error'; // Puedes usar 'success' y 'error' para distinguir los casos

        return redirect('/')->with(compact('statusMessage', 'statusType'));
    }

    public function generarCodigoQR($id)
    {
        // Contenido del código QR, puedes ajustar según tus necesidades
        $contenido = route('voucher.visualizar', ['id' => $id]);

        // Configuración del código QR
        $qrCode = Builder::create()
            ->data($contenido)
            ->encoding(new Encoding('UTF-8'))
            ->size(400) // Tamaño del código QR
            ->margin(0) // Margen del código QR
            ->build();

        // Obtener la cadena base64 del código QR
        $base64 = $qrCode->getDataUri();

        // Decodificar la cadena base64
        $imagen = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));

        // Especificar la ruta donde se guardará el archivo
        $rutaImagen = public_path('images/qrcode_' . $id . '.png');

        // Guardar la imagen decodificada en un archivo PNG
        file_put_contents($rutaImagen, $imagen);

        // Puedes retornar la ruta de la imagen o cualquier otra respuesta que necesites
        return response()->json(['ruta_imagen' => $rutaImagen]);
    }
}
