<?php

namespace App\Livewire\Usuarios;

use App\Models\Roles;
use App\Models\User;
use App\Livewire\ServicesComponent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditarUsuario extends ServicesComponent
{
    public $showModal = false;
    public $roles;
    public $rolSeleccionado;
    public $selectedRoles = [];
    public $model;
    public $name;
    public $email;

    public $listeners = ['cargarModalEditarUsuario'];

    public function mount(User $model)
    {
        $this->model = $model;
        $this->name = $model->name;
        $this->email = $model->email;
        $this->roles = Roles::orderBy('nombre', 'asc')->get();
        $this->selectedRoles = $model->roles; // Cargar los roles actuales del usuario
    }

    public function render()
    {
        return view('livewire.usuarios.editar-usuario');
    }

    public function editarUsuario()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        try {
            $admin = User::where('email', 'admin@gmail.com')->first();
            if ($admin->id != auth()->user()->id && $this->model->id == $admin->id) {
                $this->alertService->error($this, 'No puedes editar al administrador');
                return;
            }

            $user = Auth::user();
            $usuario = User::where('id', $this->model->id)->first();
            $usuario->update(['name' => $this->name, 'email' => $this->email]);
            $usuario->roles()->sync($this->selectedRoles->pluck('id'));

            $this->showModal = false;
            $this->reset('name', 'selectedRoles', 'email');
            $this->dispatch('refreshUsuariosTable')->to(UsuariosTable::class);
            $this->render();

            $this->alertService->success($this, 'Usuario actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el usuario');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarUsuario($model)
    {
        $this->model = User::findOrFail($model['id']);
        $this->name = $this->model->name;
        $this->email = $this->model->email;
        $this->roles = Roles::orderBy('nombre', 'asc')->get();
        $this->selectedRoles = $this->model->roles; // Cargar roles actuales
        $this->showModal = true;
    }

    public function updatedRolSeleccionado($rol)
    {
        $this->validate(['rolSeleccionado' => 'required|exists:roles,id']);

        $rol = Roles::find($rol);
        if ($rol && !$this->selectedRoles->contains('id', $rol->id)) {
            $this->selectedRoles->push($rol);
        }
    }

    public function eliminarRol($index)
    {
        $this->selectedRoles = $this->selectedRoles->reject(function ($rol) use ($index) {
            return $rol->id == $index;
        })->values();
    }
}
