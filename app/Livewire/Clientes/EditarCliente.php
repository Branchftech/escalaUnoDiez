<?php

namespace App\Livewire\Clientes;

use App\Livewire\ServicesComponent;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class EditarCliente extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre, $apellido, $telefono, $cedula, $email;

    public $listeners = ['cargarModalEditar'];

    public function mount(Cliente $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;
        $this->telefono = $model->telefono;
        $this->cedula = $model->cedula;
        $this->email = $model->email;
        $this->apellido = $model->apellido;
    }

    public function render()
    {
        return view('livewire.clientes.editar-cliente');
    }

    public function editarCliente()
    {

        $this->validate([
            //'cedula' => 'required|string',
            'nombre' => 'required|string',
            'apellido' => 'nullable|string',
            'telefono' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        try {
            $user = Auth::user();

            Cliente::editarCliente($this->model->id, $this->nombre, $this->apellido, $this->telefono, $this->cedula, $this->email, $user->id);

            $this->reset('showModal');
            $this->dispatch('refreshClientesTable')->to(ClientesTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Cliente actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Cliente');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditar($model)
    {
        $this->model = Cliente::find($model['id']);
        $this->nombre = $this->model['nombre'];
        $this->telefono = $this->model['telefono'];
        $this->cedula = $this->model['cedula'];
        $this->email = $this->model['email'];
        $this->apellido = $this->model['apellido'];
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
