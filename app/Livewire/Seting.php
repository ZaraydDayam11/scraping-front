<?php

namespace App\Livewire;

use App\Exports\ArticlesExport;
use App\Livewire\Forms\TableSettingForm;
use App\Models\Category;
use App\Models\TableSetting;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Seting extends Component
{

    use WithPagination;

    public $category;
    public $diarios, $diariosCategoria;
    public $diarioSelected, $categoriaSelected;

    public $isOpen = false;
    public $showTableSetting = false;
    public $isOpenDelete = false;
    public $search, $tableSetting;
    public $itemId, $tableSettingId;
    public $tableSettingState;
    public TableSettingForm $form;
    protected $listeners = ['render', 'delete'];

    public function render()
    {
        // Cambia 10 por el número de registros que deseas mostrar por página
        $tableSettings = TableSetting::paginate(10);
        // Definimos los diarios
        $this->diarios = [
            'https://diariosinfronteras.com.pe/' => 'Diario Sin Fronteras',
            'https://losandes.com.pe/' => 'Los Andes',
            'https://www.expreso.com.pe/' => 'El Expreso',
        ];

        $this->diariosCategoria = Category::all();
        
        return view('livewire.seting', compact('tableSettings'));
    }

    public function create()
    {
        $this->closeModals();
        $this->resetForm();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        $tableSettingData = $this->form->toArray();

        if ($this->tableSettingId) {
            $tableSetting = TableSetting::find($this->tableSettingId);
            $tableSetting->update($tableSettingData);
            // toastr()->success('Configuración actualizada correctamente', 'Mensaje de éxito')->push();
        } else {
            TableSetting::create($tableSettingData);
            // toastr()->success('Configuración creada correctamente', 'Mensaje de éxito')->push();
        }

        $this->form->resetFields();
        $this->reset('isOpen', 'tableSettingId');
    }

    public function edit(TableSetting $tableSetting)
    {
        $this->closeModals(); // Cierra cualquier modal abierto previamente
        $this->form->fill($tableSetting->toArray()); // Llena el formulario con los datos del registro existente
        $this->tableSettingId = $tableSetting->id; // Establece el ID del registro que se está editando
        $this->isOpen = true; // Abre el modal de edición
    }



    public function deleteItem($id)
    {
        $this->itemId = $id;
        $this->isOpenDelete = true;
    }

    public function delete()
    {
        if ($this->itemId) {
            TableSetting::find($this->itemId)?->delete();
            // toast()->success('Eliminado correctamente', 'Mensaje de éxito')->push();
        }
        $this->reset('isOpenDelete', 'itemId');
    }

    private function resetForm()
    {
        $this->form->resetFields();
        $this->reset('tableSettingId');
        $this->resetValidation();
    }

    public function closeModals()
    {
        $this->isOpen = false;
        $this->showTableSetting = false;
        $this->isOpenDelete = false;
    }

    public function createPDF()
    {
        $total = TableSetting::count();
        $user = Auth::user()->name;
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $articles = TableSetting::get();
        $pdf = FacadePdf::loadView('reports/pdf_articles', compact('articles', 'total', 'user', 'date', 'hour'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('reporte-de-articulos.pdf'); //desacarga automaticamente
        // return $pdf->stream('reports/pdf_articles'); //abre en una pestaña como pdf
    }

    public function createExcel()
    {
        return Excel::download(new ArticlesExport(), 'reporte-de-articulos.xlsx');
    }

    public function createCSV()
    {
        $articulos = TableSetting::all();

        // Crear el archivo CSV
        $response = new StreamedResponse(function () use ($articulos) {
            $handle = fopen('php://output', 'w');

            // Enviar encabezado UTF-8 BOM
            fwrite($handle, "\xEF\xBB\xBF");

            // Encabezados del CSV
            fputcsv($handle, ['Título', 'Extracto', 'Categoría', 'Imagen', 'Autor', 'Fecha']);

            foreach ($articulos as $articulo) {
                // Convertir caracteres a UTF-8
                $titulo = mb_convert_encoding($articulo->nombre, 'UTF-8', 'auto');
                $extracto = mb_convert_encoding($articulo->body, 'UTF-8', 'auto');
                $categoria = mb_convert_encoding($articulo->categoria, 'UTF-8', 'auto');
                $imagen = mb_convert_encoding($articulo->image, 'UTF-8', 'auto');
                $autor = mb_convert_encoding($articulo->autor, 'UTF-8', 'auto');
                $fecha = mb_convert_encoding($articulo->fecha, 'UTF-8', 'auto');

                fputcsv($handle, [$titulo, $extracto, $categoria, $imagen, $autor, $fecha]);
            }

            fclose($handle);
        });

        // Configurar el encabezado HTTP para descargar el archivo
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="reporte-de-articulos.csv"');

        return $response;
    }
}
