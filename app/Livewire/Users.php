<?php

namespace App\Livewire;

use App\Events\UserCreated;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Usernotnull\Toast\Concerns\WireToast;

class Users extends Component
{
    use WithPagination;
    use WireToast;

    public $search;
    public $isOpen = false, $isOpenAssign = false, $showUser = false, $isOpenDelete = false;
    public $itemId, $userState, $userRol;
    public UserForm $form;
    public ?User $user;
    public $roles, $listRoles = [];

    public function refreshUsers()
    {
        $this->render();
    }

    public function render()
    {
        $this->roles = Role::all();
        $users = User::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.users', compact('users'));
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function edit(User $user)
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->itemId = $user->id;
        $this->user = $user;
        $this->form->fill($user);
    }

    public function store()
    {
        $this->validate();
        $userData = $this->form->toArray();
        if (!isset($this->user->id)) {
            $userData['password'] = bcrypt($this->form->password);
            $userData['membership_id'] = 1;
            User::create($userData)->assignRole('Usuario');
            toast()->success('Usuario creado correctamente', 'Mensaje de éxito')->push();
        } else {
            if (!empty($this->form->password)) {
                $userData['password'] = bcrypt($this->form->password);
            } else {
                unset($userData['password']);
            }
            $this->user->update($userData);
            toast()->success('Usuario actualizado correctamente', 'Mensaje de éxito')->push();
        }
        $this->closeModals();
    }

    public function deleteItem($id)
    {
        $this->itemId = $id;
        $this->isOpenDelete = true;
    }

    public function delete()
    {
        $user = User::find($this->itemId)->delete();
        toast()->success('Usuario eliminado correctamente', 'Mensaje de éxito')->push();
        $this->reset('isOpenDelete', 'itemId');
    }

    public function showRoles(User $user)
    {
        $this->isOpenAssign = true;
        $this->user = $user;
        $this->listRoles = $user->roles->pluck('id')->toArray();
    }

    public function updateRoleUser(User $user)
    {
        $isNewAssignment = $user->roles()->count() === 0;
        if ($isNewAssignment && empty($this->listRoles)) {
            toast()->danger('No se puede asignar roles vacíos', 'Mensaje de error')->push();
        } else {
            $user->roles()->sync($this->listRoles);
            if ($isNewAssignment && $this->listRoles) {
                toast()->success('Se asignaron correctamente los roles', 'Mensaje de éxito')->push();
            } else if (!$isNewAssignment) {
                toast()->success('Se actualizaron correctamente los roles', 'Mensaje de éxito')->push();
            }
        }
        $this->reset(['isOpenAssign']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function closeModals()
    {
        $this->isOpen = false;
        $this->isOpenAssign = false;
        $this->showUser = false;
        $this->isOpenDelete = false;
    }

    private function resetForm()
    {
        $this->form->reset();
        $this->reset(['user', 'itemId']);
        $this->resetValidation();
    }
}
