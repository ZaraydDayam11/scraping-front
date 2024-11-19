<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\YapePage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class AccountSettingYape extends Component
{
    use WithFileUploads;
    use WithPagination;
    use WireToast;

    public $isOpen = false;
    public $ruteCreate = false;
    public $search, $yapepage, $image;
    protected $listeners = ['render', 'delete' => 'delete'];

    protected $rules = [
        'yapepage.name' => 'required',
        'yapepage.telefono' => 'required',
    ];

    public function render()
    {
        $yapepages = YapePage::where('name', 'like', '%' . $this->search . '%')->latest('id')->paginate(5);
        return view('livewire.admin.account-setting-yape', compact('yapepages'));
    }

    public function create()
    {
        $this->isOpen = true;
        $this->ruteCreate = true;
        $this->reset('yapepage', 'image');
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();
        if (!isset($this->yapepage['id'])) {
            $yapepage = YapePage::create($this->yapepage);
            if ($this->image) {
                $image = Storage::disk('public')->put('galery', $this->image);
                $yapepage->image()->create([
                    'url' => $image
                ]);
            }
            toast()->success('Registro creado satisfactoriamente', 'Mensaje de Éxito')->push();
        } else {
            $yapepage = YapePage::find($this->yapepage['id']);
            $yapepage->update(Arr::except($this->yapepage, 'image'));
            if ($this->image) {
                $image = Storage::disk('public')->put('galery', $this->image);
                if ($yapepage->image) {
                    Storage::disk('public')->delete('galery', $yapepage->image->url);
                    $yapepage->image()->update([
                        'url' => $image
                    ]);
                } else {
                    $yapepage->image()->create([
                        'url' => $image
                    ]);
                };
            };
            toast()->success('Registro actualizado satisfactoriamente', 'Mensaje de Éxito')->push();
        }
        $this->reset(['isOpen', 'yapepage', 'image']);
        $this->dispatch('SisCrudYapePage', 'render');
    }

    public function edit($yapepage)
    {
        $this->reset('image');
        $this->yapepage = array_slice($yapepage, 0, 8);
        $this->isOpen = true;
        $this->ruteCreate = false;
    }

    public function delete($id)
    {
        YapePage::find($id)->delete();
    }
}
