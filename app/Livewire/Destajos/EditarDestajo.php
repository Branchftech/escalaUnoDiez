<?php

namespace App\Livewire\Destajos;

use App\Livewire\ServicesComponent;
use App\Models\Destajo;
use App\Models\Obra;
use App\Models\Proveedor;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class EditarDestajo extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $editpresupuesto, $editfecha;

    // Select obras
    public $editobras;
    public $editobraSeleccionada;

    // Select proveedores
    public $editproveedores;
    public $editproveedorSeleccionado;

    #Select servicios
    public $editservicios;
    public $editservicioSeleccionado;
    public $editselectedServicios = [];

    public $listeners = ['cargarModalEditarDestajo'];

    public function mount(Destajo $model)
    {
        $this->model = $model;
        $this->editpresupuesto = $model->presupuesto;
        $this->editobraSeleccionada = $model->idObra;
        $this->editproveedorSeleccionado = $model->idProveedor;

        $this->editobras = Obra::all();
        $this->editproveedores = Proveedor::all();
        $this->editservicios = Servicio::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->editobras = Obra::all();
        $this->editproveedores = Proveedor::all();
        $this->editservicios = Servicio::orderBy('nombre', 'asc')->get();

        return view('livewire.destajos.editar-destajo');
    }

    public function editarDestajo()
    {
        $this->validate([
            'editpresupuesto' => 'required|numeric',
            'editobraSeleccionada' => 'required|exists:obra,id',
            'editproveedorSeleccionado' => 'required|exists:proveedores,id',
        ]);

        try {
            $user = Auth::user();
            Destajo::editarDestajo(
                $this->model['id'],
                $this->editpresupuesto,
                $this->editobraSeleccionada,
                $this->editproveedorSeleccionado,
                $this->editselectedServicios,
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
        $this->editpresupuesto = $this->model['presupuesto'];
        $this->editobraSeleccionada = $this->model['idObra'];
        $this->editproveedorSeleccionado = $this->model['idProveedor'];
        $this->editselectedServicios = $this->model->servicios->all();

        $this->editobras = Obra::all();
        $this->editproveedores = Proveedor::all();
        $this->editservicios = Servicio::orderBy('nombre', 'asc')->get();

        $this->showModal = true;
    }

    public function limpiar()
    {
        $this->reset('editpresupuesto');
        $this->reset('editobraSeleccionada');
        $this->reset('editproveedorSeleccionado');
        $this->reset('editservicioSeleccionado');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function updatedEditServicioSeleccionado($servicio)
    {
        $this->validate([
            'editservicioSeleccionado' => 'required|exists:servicio,id',
        ]);

        $servicio = Servicio::find($servicio);

        if ($servicio && !in_array($servicio, $this->editselectedServicios)) {
            $this->editselectedServicios[] = $servicio;
        }
    }

    public function editeliminarServicio($index)
    {
        $this->editselectedServicios = array_filter($this->editselectedServicios, function($servicio) use ($index) {
            return $servicio->id !== $index;
        });
    }
}
