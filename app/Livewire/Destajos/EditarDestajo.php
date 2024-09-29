<?php

namespace App\Livewire\Destajos;

use App\Livewire\ServicesComponent;
use App\Models\Destajo;
use App\Models\Obra;
use App\Models\Cliente;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class EditarDestajo extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $presupuesto, $fecha;

    // Select obras
    public $obras;
    public $obraSeleccionada;

    // Select clientes
    public $clientes;
    public $clienteSeleccionado;

    // Select servicios
    public $servicios;
    public $servicioSeleccionado;

    public $listeners = ['cargarModalEditarDestajo'];

    public function mount(Destajo $model)
    {
        $this->model = $model;
        $this->presupuesto = $model->presupuesto;
        $this->obraSeleccionada = $model->idObra;
        $this->clienteSeleccionado = $model->idCliente;
        $this->servicioSeleccionado = $model->idServicio;

        $this->obras = Obra::all();
        $this->clientes = Cliente::all();
        $this->servicios = Servicio::all();
    }

    public function render()
    {
        $this->obras = Obra::all();
        $this->clientes = Cliente::all();
        $this->servicios = Servicio::all();

        return view('livewire.destajos.editar-destajo');
    }

    public function editarDestajo()
    {
        $this->validate([
            'presupuesto' => 'required|numeric',
            'obraSeleccionada' => 'required|exists:obra,id',
            'clienteSeleccionado' => 'required|exists:cliente,id',
            'servicioSeleccionado' => 'required|exists:servicio,id',
        ]);

        try {
            $user = Auth::user();
            Destajo::editarDestajo(
                $this->model['id'],
                $this->presupuesto,
                $this->obraSeleccionada,
                $this->clienteSeleccionado,
                $this->servicioSeleccionado,
                $user->id
            );

            $this->dispatch('refreshDestajosTable')->to(DestajosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Destajo actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Destajo');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarDestajo($model)
    {
        $this->model = Destajo::find($model['id']);
        $this->presupuesto = $this->model['presupuesto'];
        $this->obraSeleccionada = $this->model['idObra'];
        $this->clienteSeleccionado = $this->model['idCliente'];
        $this->servicioSeleccionado = $this->model['idServicio'];

        $this->obras = Obra::all();
        $this->clientes = Cliente::all();
        $this->servicios = Servicio::all();

        $this->showModal = true;
    }

    public function limpiar()
    {
        $this->reset('presupuesto');
        $this->reset('obraSeleccionada');
        $this->reset('clienteSeleccionado');
        $this->reset('servicioSeleccionado');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
