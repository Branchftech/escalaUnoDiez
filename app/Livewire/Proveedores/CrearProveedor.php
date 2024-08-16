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
        $user = Auth::user();
        $validatedData = $this->validate([
            'nombre' => 'required|string|unique:proveedores,nombre',
            'direccion' => 'required|string',
            'telefono' => 'required|numeric',
            'email' => 'required|email',
        ]);



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
