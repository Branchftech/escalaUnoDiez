<?php

namespace App\Livewire\Unidades;

use App\Livewire\ServicesComponent;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;

class CrearUnidad extends ServicesComponent
{
    public $nombre;
    public $model;
    public $showModal = false;
    #select unidades
    public $unidades;
    public $editarUnidadSelected;

    public function mount(Unidad $model)
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        $this->model = $model;
        $this->nombre = $model->nombre;
    }

    public function render()
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        return view('livewire.unidades.crear-unidad');
    }

    public function crearEditarUnidad()
    {
        $user = Auth::user();

        $this->validate([
            'nombre' => 'required|string'
        ]);
        $unidad = Unidad::where('nombre', $this->nombre)->first();
        if ($unidad && $unidad->id != $this->model->id) {
            $this->addError('nombre', 'El nombre de la unidad ya está en uso.');
            return;
        }
        Unidad::crearEditarUnidad($this->editarUnidadSelected, $this->nombre, $user->id);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'Unidad creado con éxito');
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
