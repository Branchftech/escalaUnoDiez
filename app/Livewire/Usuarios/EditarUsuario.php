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
    public $rolesUsuario;
    public $rolSeleccionadoUsuario;
    public $selectedRolesUsuario; // No inicializar como array
    public $model;
    public $name;
    public $email;

    public $listeners = ['cargarModalEditarUsuario'];

    public function mount(User $model)
    {
        $this->model = $model;
        $this->name = $model->name;
        $this->email = $model->email;
        $this->rolesUsuario = Roles::orderBy('nombre', 'asc')->get();
        $this->selectedRolesUsuario = collect($model->roles); // Colección de roles actuales
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
            $usuario->roles()->sync($this->selectedRolesUsuario->pluck('id'));

            $this->showModal = false;
            $this->reset('name', 'selectedRolesUsuario', 'email');
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
        $this->rolesUsuario = Roles::orderBy('nombre', 'asc')->get();
        $this->selectedRolesUsuario = collect($this->model->roles); // Cargar roles actuales
        $this->showModal = true;
    }

    public function updatedRolSeleccionadoUsuario($rolId)
    {
        $this->validate(['rolSeleccionadoUsuario' => 'required|exists:roles,id']);

        $rol = Roles::find($rolId);
        if ($rol && !$this->selectedRolesUsuario->contains('id', $rol->id)) {
            $this->selectedRolesUsuario->push($rol);
        }
    }

    public function eliminarRol($rolId)
    {
        $this->selectedRolesUsuario = $this->selectedRolesUsuario->reject(function ($rol) use ($rolId) {
            return $rol->id == $rolId;
        })->values();
    }
}
