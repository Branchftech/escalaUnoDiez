<?php

namespace App\Livewire\DetallesObras;

use App\Livewire\ServicesComponent;
use App\Models\DetalleObra;
use Illuminate\Support\Facades\Auth;

class CrearDetalleObra extends ServicesComponent
{
    public $nombreObra, $total,$moneda,$fechaInicio,
    $fechaFin,$croquis,$calle,$manzana,$lote,$metrosCuadrados,
    $fraccionamiento,$dictamenUsoSuelo,$incrementoDensidad,
    $informeDensidad;
    public $showModal = false;

    public function render()
    {
        return view('livewire.detalles-obras.crear-detalle-obra');
    }

    public function crearDetalleObra()
    {
        $user = Auth::user();

        $this->validate([
            'nombreObra'=> 'required|string|unique:detalleobra,nombreObra,NULL,id,deleted_at,NULL',
            'total' => 'numeric',
            'moneda'=> 'required|in:mnx,dls',
            'fechaInicio'=> 'date',
            'fechaFin'=> 'date',
            'croquis'=> 'string',
            'calle'=> 'numeric',
            'manzana'=> 'string',
            'lote'=> 'string',
            'metrosCuadrados'=> 'numeric',
            'fraccionamiento'=> 'string',
            'dictamenUsoSuelo'=> 'string',
            'incrementoDensidad'=> 'string',
            'informeDensidad'=> 'string',
        ]);
        DetalleObra::crearDetalleObra($this->nombreObra, $this->total,$this->moneda,$this->fechaInicio,
        $this->fechaFin,$this->croquis,$this->calle,$this->manzana,$this->lote,$this->metrosCuadrados,
        $this->fraccionamiento,$this->dictamenUsoSuelo,$this->incrementoDensidad,
        $this->informeDensidad, $user->id);
        //$this->dispatch('refreshClientesTable')->to(ClientesTable::class);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'Detalle Obra creado con éxito');
    }

    public function limpiar()
    {
        $this->reset('nombreObra');
        $this->reset('total');
        $this->reset('moneda');
        $this->reset('fechaInicio');
        $this->reset('fechaFin');
        $this->reset('croquis');
        $this->reset('calle');
        $this->reset('manzana');
        $this->reset('lote');
        $this->reset('metrosCuadrados');
        $this->reset('fraccionamiento');
        $this->reset('dictamenUsoSuelo');
        $this->reset('incrementoDensidad');
        $this->reset('informeDensidad');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
