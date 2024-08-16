<?php

namespace App\Livewire\Proveedores;

use App\Livewire\ServicesComponent;
use App\Models\Proveedor;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class EditarProveedor extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre, $direccion,$email,$telefono;


    #Select servicios
    public $servicios;
    public $servicioSeleccionado;
    public $selectedServicios = [];
    public $listeners = ['cargarModalEditarProveedor'];


    public function mount(Proveedor $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;
        $this->direccion = $model->direccion;
        $this->telefono = $model->telefono;
        $this->email = $model->email;
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->nombre = $this->model->nombre;
        $this->direccion = $this->model->direccion;
        $this->telefono = $this->model->telefono;
        $this->email = $this->model->email;
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();
        return view('livewire.proveedores.editar-proveedor');
    }

    public function editarProveedor()
    {

        $this->validate([
            'nombre' => 'string',
            'direccion' => 'string',
            'telefono' => 'numeric',
            'email' => 'email',
        ]);

        try {
            $user = Auth::user();

            Proveedor::editarProveedor($this->model['id'], $this->nombre, $this->direccion,$this->email, $this->telefono,  $user->id, $this->selectedServicios);

            $this->reset('showModal');
            $this->dispatch('refreshProveedoresTable')->to(ProveedoresTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Proveedor actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Proveedor');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarProveedor($model)
    {
        $this->model = Proveedor::find($model['id']);
        $this->nombre = $this->model['nombre'];
        $this->direccion = $this->model['direccion'];
        $this->telefono = $this->model['telefono'];
        $this->email = $this->model['email'];
        $this->selectedServicios = $this->model->servicios->all();
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updatedServicioSeleccionado($servicio)
    {
        $this->validate([
            'servicioSeleccionado' => 'required|exists:servicio,id',
        ]);

        $servicio = Servicio::find($servicio);

        if ($servicio && !in_array($servicio, $this->selectedServicios)) {
            $this->selectedServicios[] = $servicio;
        }
    }

    public function eliminarServicio($index)
    {
        $this->selectedServicios = array_filter($this->selectedServicios, function($servicio) use ($index) {
            return $servicio->id !== $index;
        });
    }
}
