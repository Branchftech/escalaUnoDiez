<?php

namespace App\Livewire\FormasPago;

use App\Livewire\ServicesComponent;
use App\Models\FormaPago;
use Illuminate\Support\Facades\Auth;

class CrearFormasPago extends ServicesComponent
{
    public $nombre;
    public $showModal = false;

    public function render()
    {
        return view('livewire.formas-pago.crear-formas-pago');
    }

    public function crearFormasPago()
    {
        $user = Auth::user();

        $this->validate([
            'nombre' => 'required|string|unique:FormaPago,nombre,NULL,id,deleted_at,NULL'
        ]);
        FormaPago::crearFormaPago($this->nombre, $user->id);
        $this->dispatch('refreshFormasPagoTable')->to(FormasPagoTable::class);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'FormaPago creado con éxito');
    }

    public function limpiar()
    {
        $this->reset('nombre');
        $this->closeModal();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
