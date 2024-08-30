<?php

namespace App\Livewire\Servicios;

use App\Livewire\ServicesComponent;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class CrearServicio extends ServicesComponent
{
    public $nombre;
    public $showModal = false;

    public function render()
    {
        return view('livewire.servicios.crear-servicio');
    }

    public function crearServicio()
    {

        $this->validate([
            'nombre' => 'required|string|unique:Servicio,nombre,NULL,id,deleted_at,NULL',

        ]);
        try{
            $user = Auth::user();
            Servicio::crearServicio($this->nombre, $user->id);
            $this->dispatch('refreshServiciosTable')->to(ServiciosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Servicio creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el servicio');
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
