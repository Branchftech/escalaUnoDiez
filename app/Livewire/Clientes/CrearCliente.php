<?php

namespace App\Livewire\Clientes;

use App\Livewire\ServicesComponent;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class CrearCliente extends ServicesComponent
{
    public $nombre, $apellido,$telefono,$cedula,$email;
    public $showModal = false;

    public function render()
    {
        return view('livewire.clientes.crear-cliente');
    }

    public function crearCliente()
    {
        $user = Auth::user();

        $this->validate([
            'cedula' => 'required|string|unique:cliente,cedula,NULL,id,deleted_at,NULL',
            'nombre' => 'string',
            'apellido' => 'string',
            'telefono' => 'numeric',
            'email' => 'email',
        ]);
        Cliente::crearCliente($this->nombre, $this->apellido, $this->telefono, $this->cedula, $this->email, $user->id);
        $this->dispatch('refreshClientesTable')->to(ClientesTable::class);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'Cliente creado con éxito');
    }

    public function limpiar()
    {
        $this->reset('nombre');
        $this->reset('apellido');
        $this->reset('telefono');
        $this->reset('cedula');
        $this->reset('email');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
