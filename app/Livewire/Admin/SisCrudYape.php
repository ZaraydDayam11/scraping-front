<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Session;
use App\Models\Voucher;
use App\Models\YapePayment;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Mail\ContactMail_yape;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Usernotnull\Toast\Concerns\WireToast;

class SisCrudYape extends Component
{
    use WithPagination;
    use WireToast;

    public $isOpen = false;
    public $ruteCreate = false;
    public $search, $yape;
    protected $listeners = ['render', 'delete' => 'delete'];

    protected $rules = [
        'yape.status' => 'required',
    ];

    public function render()
    {
        $user = Auth::user();

        $userEmail = $user->email;
        $userRoleName = $user->roles->first()->name;

        if ($userRoleName === 'Administrador') {
            $yapes = Payment::where(function ($query) {
                $query->where('codigo', 'like', '%' . $this->search . '%')
                ->orWhereHas('voucher', function ($subquery) {
                    $subquery->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('tipo', 'like', '%' . $this->search . '%');

                });
            })->latest('id')->paginate(5);
            return view('livewire.admin.yape', compact('yapes'));
        } else {
            $yapes = Payment::whereHas('voucher.cliente', function ($query) use ($userEmail) {
                $query->where('email', $userEmail);
            })->where('codigo', 'like', '%' . $this->search . '%')
            ->orWhereHas('voucher', function ($subquery) {
                $subquery->where('numero', 'like', '%' . $this->search . '%')
                ->orWhere('tipo', 'like', '%' . $this->search . '%');

            })
            ->latest('id')->paginate(5);

            return view('livewire.admin.yape', compact('yapes'));
        }
    }
    
    public function store()
    {
        $this->validate();

        $yape = Voucher::find($this->yape['voucher_id']);

        // Verifica si $voucher es nulo o no antes de actualizar
        if ($yape) {
            $estado = $this->yape['status'];

            $yape->status = $estado;
            $yape->save();

            toast()->success('Registro actualizado satisfactoriamente', 'Mensaje de Éxito')->push();
            $this->reset(['isOpen', 'yape']);
            $this->dispatch('SisCrudyape', 'render');

            if ($estado == 'PA') {
                $client = $yape->cliente;
                
                $user = User::where('id', $yape->client_id)->first();
                $plan = Membership::where('precio', $yape->total)->first();

                if ($plan) {
                    $user->membership_id = $plan->id; // Asignar el valor a la propiedad del modelo User
                    $user->save(); // Guardar los cambios
                }

                if (!$client) {
                    return redirect()->back()->with('error', 'Error al enviar el correo. Cliente no encontrado.');
                }

                // Guardar el cliente y el voucher en sesiones
                Session::put('client_yape', $client);
                Session::put('voucher_yape', $yape);
                // Envío del correo de confirmación
                $this->sendConfirmationEmail($client, $yape);
            }
        } else {
            return redirect()->back()->with('error', 'El voucher no fue encontrado.');
        }
    }

    public function edit($id)
    {
        $this->yape = array_slice($id, 0, 10);
        $this->isOpen = true;
        $this->ruteCreate = false;
    }

    public function delete($id)
    {
        Payment::find($id)->delete();
    }

    protected function sendConfirmationEmail($client, $voucher)
    {
        // Verificar si existe información del cliente y del voucher
        if ($client && $voucher) {
            Mail::to($client->email)->send(new ContactMail_yape($voucher));
        } else {
            return redirect()->back()->with('error', 'Error al enviar el correo de confirmación. Información faltante.');
        }
    }

    public function createPDF()
    {
        $total = Payment::count();
        // $yape = auth()->yape()->name;
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $yapePayments = Payment::all();
        $pdf = FacadePdf::loadView('reports/pdf_paymenyape', compact('yapePayments', 'total', 'date', 'hour'));
        $pdf->setPaper('a4', 'landscape');
        //return $pdf->download('pdf_file.pdf');    //desacarga automaticamente
        return $pdf->stream('reports/pdf_paymenyape'); //abre en una pestaña como pdf
    }

    public function createCSV()
    {
        // Obtener los datos de los yapeos desde la base de datos
        $data = DB::table('yape_payments')->select('id', 'codigo', 'name', 'fecha', 'voucher_id', 'created_at', 'updated_at')->get();

        // Crear un archivo CSV
        $filename = 'pagos_por_yape.csv';
        $filePath = storage_path('app/' . $filename);

        $file = fopen($filePath, 'w');

        // Escribir los encabezados de las columnas
        fputcsv($file, ['ID', 'Codigo', 'Nombre del yapero', 'Fecha', 'ID Voucher', 'Creacion', 'Actualizado']);

        // Escribir los datos de los yapeos
        foreach ($data as $item) {
            fputcsv($file, [$item->id, $item->codigo, $item->name, $item->fecha, $item->voucher_id, $item->created_at, $item->updated_at]);
        }

        fclose($file);

        // Devolver el archivo como respuesta
        return response()->download($filePath, $filename)->deleteFileAfterSend();
    }
}
