<?php

namespace App\Livewire\BitacorasObras;

use App\Livewire\ServicesComponent;
use App\Models\BitacoraObra;
use App\Models\Obra;
use Illuminate\Support\Facades\Auth;

class CrearBitacoraObra extends ServicesComponent
{
    public $descripcion;
    #select obras
    public $obras;
    public $obraSeleccionada;
    public $showModal = false;

    public function mount()
    {
        $this->obras = Obra::all();
    }

    public function render()
    {
        $this->obras = Obra::all();
        return view('livewire.bitacoras-obras.crear-bitacora-obra');
    }

    public function crearBitacoraObra()
    {
        $user = Auth::user();

        $this->validate([
            'descripcion' => 'required|string|unique:bitacoraobra,descripcion,NULL,id,deleted_at,NULL',
            'obraSeleccionada' => 'required|exists:obra,id',
        ]);
        BitacoraObra::crearBitacoraObra($this->descripcion, $this->obraSeleccionada,$user->id);
        $this->dispatch('refreshBitacorasObrasTable')->to(BitacorasObrasTable::class);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'Bitacora creada con éxito');
    }

    public function limpiar()
    {
        $this->reset('descripcion');
        $this->reset('obraSeleccionada');
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
