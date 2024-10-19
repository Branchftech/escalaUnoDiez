<?php

namespace App\Livewire\Proveedores;

use App\Livewire\ServicesComponent;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;

class CrearProveedor extends ServicesComponent
{
    public $nombre, $direccion, $email, $telefono;
    public $showModal = false;

    public function mount()
    {
        //$this->servicios = Servicio::all(); // Carga inicial de servicios
    }

    public function render()
    {
        return view('livewire.proveedores.crear-proveedor');
    }

    public function crearProveedor()
    {

        $this->validate([
            'nombre' => 'required|string|unique:proveedores,nombre,NULL,id,deleted_at,NULL',
            'direccion' => 'required|string',
            'telefono' => 'required|numeric',
            'email' => 'required|email',
        ]);
        try{
            $user = Auth::user();
            Proveedor::crearProveedor(
                $this->nombre,
                $this->direccion,
                $this->email,
                $this->telefono,
                $user->id
            );

            $this->dispatch('refreshProveedoresTable')->to(ProveedoresTable::class);
            $this->limpiar();
            $this->alertService->success($this, 'Proveedor creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el proveedor');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset(['nombre', 'direccion', 'telefono', 'email']);
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
