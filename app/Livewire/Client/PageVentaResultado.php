<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Mail\ContactMail;
use App\Mail\VentaRealizada;
use App\Models\Voucher;
use Illuminate\Support\Facades\Mail;

class PageVentaResultado extends Component
{
    public function mount()
    {
        $proforma = Session::get('voucher');

        if (!$proforma) {
            return redirect('/');
        }
        $voucher = Voucher::find($proforma->id);

        // dd($proforma, $voucher['id']);

        if ($voucher->status == 'PA' && $voucher->status == 'RE') {
            return redirect('/');
        } else {
            $metodoPago = $proforma->metodo_pago;

            if ($metodoPago == 'Yape') {
                $proforma->status = 'RE';
            } elseif ($metodoPago == 'Paypal') {
                $proforma->status = 'PA';
            }

            $proforma->save();

            $client = session('client');

            $this->sendConfirmationEmail($client, $proforma);

            session()->forget('voucher');
            session()->forget('nombrePlan');
            session()->forget('precioPlan');
            session()->forget('client_data');
            session()->forget('client');
        }
    }

    public function render()
    {
        // Devolver la vista 'page-venta-resultado'
        return view('livewire.admin.page-venta-resultado');
    }

    protected function sendConfirmationEmail($client, $proforma)
    {
        // Verificar si existe información del cliente y la proforma
        if ($client && $proforma) {
            // dd($proforma, $client->email);
            // Envía el correo electrónico de confirmación de proforma al cliente
            Mail::to($client->email)->send(new ContactMail($proforma));

            // Envía la notificación de venta al administrador
            Mail::to('darwincondori49@gmail.com')->send(new VentaRealizada($proforma));

            // Limpiar sesiones
            session()->forget('voucher');
            session()->forget('entrega_data');
            session()->forget('client_data');
            session()->forget('client');
        } else {
            // Manejar el caso donde no hay información del cliente o la proforma
            // Puedes registrar un log, enviar una notificación, etc.
        }
    }
}
