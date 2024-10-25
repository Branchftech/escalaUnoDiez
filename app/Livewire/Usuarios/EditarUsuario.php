<?php

namespace App\Livewire\Usuarios;

use App\Models\Cliente;
use App\Models\Permisos;
use App\Models\Roles;
use App\Models\User;
use App\Livewire\ServicesComponent;
use Illuminate\Support\Facades\DB;


class EditarUsuario extends ServicesComponent
{
    #modal
    public $showModal = false;

    #Select roles
    public $roles;
    public $rolSeleccionado;
    public $selectedRoles;
    #Select permisos
    public $permisos;
    public $permisoSeleccionado;
    public $selectedPermisos ;


    #modelo
    public $model;
    #input
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public $listeners = ['cargarModalEditar'];

    public function mount(User $model)
    {
        $this->model = $model;
        $this->name = $model->name;
        $this->permisos = Permisos::orderBy('name', 'asc')->get();
        $this->roles = Roles::where('name', '!=', 'Administrador')->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.usuarios.editar-usuario');
    }

    public function editarUsuario()
    {
        if (!$this->permissionService->checkPermissions($this, ['editar-usuario'], 'editar usuarios')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó editar un usuario sin tener el permiso requerido');
            return;
        }
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => [
                'nullable',
                'string',
                'min:8', // Mínimo 8 caracteres
                'regex:/[a-z]/', // Al menos una letra minúscula
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[0-9]/', // Al menos un dígito
                //'regex:/[@$!%*#?&]/', // Al menos un carácter especial
            ],
            'password_confirmation' => 'same:password',
        ], [
            'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una letra mayúscula y un dígito.'
        ]);

        if ($this->password != $this->password_confirmation) {
            $this->addError('password', 'Las contraseñas no coinciden');
            return;
        }

            $admin = User::where('email', 'admin@gmail.com')->first();
            if ($admin->id != auth()->user()->id && $this->model->id == $admin->id) {
                $this->alertService->error($this, 'No puedes editar al administrador');
                return;
            }

            try {

            $usuario = User::where('email', $this->email)->first();

            if ($usuario && $usuario->email !== $this->model->email) {
                $this->addError('email',  'El email ya está en uso');
                return;
            }

            $usuario = User::editarUsuario($this->model->id, $this->name, $this->email, $this->password, $this->selectedRoles, $this->selectedPermisos );

            $this->showModal = false;
            $this->reset('name', 'selectedPermisos', 'selectedRoles', 'email', 'password', 'password_confirmation');
            $this->dispatch('refreshUsuariosTable')->to(UsuariosTable::class);
            $this->render();

            if ($usuario) {
                $sessions = DB::table('sessions')->where('user_id', $usuario->id)->get();
                foreach ($sessions as $session) {
                    DB::table('sessions')->where('id', $session->id)->delete();
                }
            }

            $this->alertService->success($this, 'Usuario actualizado con éxito');


        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el usuario');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }



    public function cargarModalEditar($model)
    {
        $this->model = User::findOrfail($model['id']);
        $this->name = $this->model->name;
        $this->email = $this->model->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRoles = collect($this->model->roles->all());
        $this->selectedPermisos =  collect($this->model->permissions->all());


        $this->showModal = true;
    }


    public function updatedRolSeleccionado($rol)
    {
        $this->validate([
            'rolSeleccionado' => 'required|exists:roles,id',
        ]);

        $rol = Roles::find($rol);

        if ($rol && !$this->selectedRoles->contains('id', $rol->id)) {
            $this->selectedRoles->push($rol);
        }
    }
    public function updatedPermisoSeleccionado($permiso)
    {
        $this->validate([
            'permisoSeleccionado' => 'required|exists:permissions,id',
        ]);

        $permiso = Permisos::find($permiso);


        if ($permiso && !$this->selectedPermisos->contains('id', $permiso->id)) {
            $this->selectedPermisos->push($permiso);
        }
    }
    public function eliminarPermiso($index)
    {
        $this->selectedPermisos = $this->selectedPermisos->reject(function ($permiso) use ($index) {
            return $permiso->id == $index;
        })->values();
    }

    public function eliminarRol($index)
    {
        $this->selectedRoles = $this->selectedRoles->reject(function ($rol) use ($index) {
            return $rol->id == $index;
        })->values();
    }
}

