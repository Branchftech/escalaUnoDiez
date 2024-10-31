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
        $this->validate([
            'nombre' => 'required|string|unique:formapago,nombre,NULL,id,deleted_at,NULL'
        ]);
        try{
            $user = Auth::user();
            FormaPago::crearFormaPago($this->nombre, $user->id);
            $this->dispatch('refreshFormasPagoTable')->to(FormasPagoTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'FormaPago creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear la forma de pago');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
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
