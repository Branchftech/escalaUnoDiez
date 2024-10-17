<?php

namespace App\Livewire\Destajos;

use App\Livewire\ServicesComponent;
use App\Models\Destajo;
use App\Models\Obra;
use App\Models\Proveedor;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class CrearDestajo extends ServicesComponent
{
    public $presupuesto, $fecha;
    public $showModal = false;

    # select obras
    public $obras;
    public $obraSelected;

    # select proveedores
    public $proveedores;
    public $proveedorSelected;

    #Select servicios
    public $servicios;
    public $servicioSeleccionado;
    public $selectedServicios = [];

    protected $listeners = ['refreshCrearDestajo' => '$refresh'];

    public function mount()
    {
        $this->obras = Obra::all();
        $this->proveedores = Proveedor::all();
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->obras = Obra::all();
        $this->proveedores = Proveedor::all();
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();

        return view('livewire.destajos.crear-destajo');
    }

    public function crearDestajo()
    {
        $this->validate([
            'presupuesto' => 'required|numeric|min:1',
            'obraSelected' => 'required|exists:obra,id',
            'proveedorSelected' => 'required|exists:proveedores,id',
        ]);

        try {
            $user = Auth::user();
            Destajo::crearDestajo(
                $this->presupuesto,
                $this->obraSelected,
                $this->proveedorSelected,
                $this->selectedServicios,
                $user->id
            );
            // Enviar evento para refrescar la tabla
            $this->dispatch('refreshDestajosTable')->to(DestajosTable::class);
            // Limpiar los campos
            $this->limpiar();
            $this->closeModal();
            // Mostrar mensaje de éxito
            $this->alertService->success($this, 'Destajo creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el destajo');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('presupuesto');
        $this->reset('obraSelected');
        $this->reset('proveedorSelected');
        $this->reset('selectedServicios');
        $this->dispatch('resetSelect2');

    }

    public function openModal()
    {
        $this->showModal = true;
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
