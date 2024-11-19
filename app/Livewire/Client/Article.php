<?php

namespace App\Livewire\Client;

use App\Models\Article as ModelsArticle;
use App\Models\Category;
use App\Models\Scraping;
use App\Models\TableSetting;
use Livewire\Component;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
use Usernotnull\Toast\Concerns\WireToast;

class Article extends Component
{
    use WithPagination;
    use WireToast;

    public $search;
    public $category;
    public $diarios, $diariosCategoria;
    public $diarioSelected, $categoriaSelected;

    public $showModal = false;
    public $showModalPlan = false;

    protected $listeners = ['render', 'delete', 'openModal', 'abrirModal', 'cerrarModal', 'closeModal'];

    public function refreshArticle()
    {
        $this->render();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function abrirModal()
    {
        $this->showModalPlan = true;
    }

    public function render()
    {
        $articulos = TableSetting::where('nombre', 'like', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(16);
        $userId = null;

        if ($this->search != null) {
            // Verifica si el usuario está autenticado
            if (!Auth::check()) {
                $this->search = '';
                $this->openModal();
            }
        }

        if (Auth::check()) {
            $userId = Auth::user()->id;
            if (filter_var($this->search, FILTER_VALIDATE_URL)) {
                // Si $this->search es una URL válida
                $articulos = TableSetting::where('urls', 'like', '%' . $this->search . '%')
                    ->orderBy('created_at', 'desc')
                    ->paginate(16);
                toast()->success('Se Scrapeó correctamente!', 'Mensaje de Éxito')->push();
            } else {
               // Si $this->search no es una URL válida, obtén todos los artículos paginados
                $articulos = TableSetting::where('nombre', 'like', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(16);
            }
        }

        return view('livewire.client.article', compact('articulos', 'userId'));
    }

    public function iniciarPago($nombrePlan, $precioPlan)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $authenticatedUser = Auth::user();

            // Verificación: ¿El usuario tiene su correo electrónico verificado?
            if ($authenticatedUser->email_verified_at != null) {

                // Establecer las variables en la sesión
                session([
                    'nombrePlan' => $nombrePlan,
                    'precioPlan' => $precioPlan,
                ]);

                return redirect('yape/' . $precioPlan);
            } else {
                toast()->warning('¡Para continuar, necesitas verificar su dirección de correo electrónico!', 'Mensaje de Advertencia')->push();
            }
        } else {
            toast()->warning('¡Para continuar, necesitas Iniciar Sesión!', 'Mensaje de Advertencia')->push();
        }
    }
}
