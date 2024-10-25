<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use App\Livewire\ServicesComponent;

class CrearUsuario extends ServicesComponent
{
    #Inputs
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    #modal
    public $showModal = false;

    public function mount()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.usuarios.crear-usuario');
    }

    public function crearUsuario()
    {

        if (!$this->permissionService->checkPermissions($this, ['crear-usuario'], 'crear usuarios')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó crear un usuario sin tener el permiso requerido');
            return;
        }

        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8', // Mínimo 8 caracteres
                'regex:/[a-z]/', // Al menos una letra minúscula
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[0-9]/', // Al menos un dígito
                //'regex:/[@$!%*#?&]/', // Al menos un carácter especial
            ],
            'password_confirmation' => 'required|same:password',
        ], [
            'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una letra mayúscula y un dígito.',
        ]);


        try {
            $usuario = User::crearUsuario($this->name, $this->email, $this->password );

            $this->showModal = false;
            $this->limpiar();
            $this->dispatch('refreshUsuariosTable')->to(UsuariosTable::class);
            $this->render();


            $this->alertService->success($this, 'Usuario creado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo crear el usuario');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }



    public function limpiar()
    {
        $this->reset('name', 'email', 'password', 'password_confirmation');
    }



}
