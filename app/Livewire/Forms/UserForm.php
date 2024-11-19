<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class UserForm extends Form
{
    public $id;
    public $name;
    public $dni;
    public $email;
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'dni' => 'required|string|min:8|max:8|unique:users,dni' . ($this->id ? ',' . $this->id : ''),
            'email' => 'required|email|max:255|unique:users,email' . ($this->id ? ',' . $this->id : ''),
            'password' => ($this->id ? 'nullable' : 'required|min:8') ,
            'password_confirmation' => ($this->id ? 'nullable' : 'required|min:8|same:password'),
        ];
    }
}
