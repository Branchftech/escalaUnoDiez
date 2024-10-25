<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use App\Livewire\ServicesComponent;
use Illuminate\Support\Facades\Log;

class EliminarUsuario extends ServicesComponent
{
    #modelo
    public $model;

    #modal
    public $showModal = false;


    public $listeners = ['cargarModalEliminarUsuario'];

    public function mount(User $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.usuarios.eliminar-usuario');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }


    public function eliminarUsuario()
    {
        try {
            User::eliminarUsuario($this->model->id);
            $this->reset( 'showModal');

            $this->dispatch('refreshUsuariosTable')->to(UsuariosTable::class);
            $this->render();
            $this->alertService->success($this, 'Usuario eliminado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al eliminar el usuario');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }


    public function cargarModalEliminarUsuario($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }
}
