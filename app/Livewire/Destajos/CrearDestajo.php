<?php

namespace App\Livewire\Destajos;

use App\Livewire\ServicesComponent;
use App\Models\Destajo;
use App\Models\Obra;
use App\Models\Cliente;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class CrearDestajo extends ServicesComponent
{
    public $presupuesto, $fecha;
    public $showModal = false;

    # select obras
    public $obras;
    public $obraSelected;

    # select clientes
    public $clientes;
    public $clienteSelected;

    # select servicios
    public $servicios;
    public $servicioSelected;

    protected $listeners = ['refreshCrearDestajo' => '$refresh'];

    public function mount()
    {
        $this->obras = Obra::all();
        $this->clientes = Cliente::all();
        $this->servicios = Servicio::all();
    }

    public function render()
    {
        $this->obras = Obra::all();
        $this->clientes = Cliente::all();
        $this->servicios = Servicio::all();

        return view('livewire.destajos.crear-destajo');
    }

    public function crearDestajo()
    {
        $this->validate([
            'presupuesto' => 'required|numeric|min:1',
            'obraSelected' => 'required|exists:obra,id',
            'clienteSelected' => 'required|exists:cliente,id',
            'servicioSelected' => 'required|exists:servicio,id',
        ]);

        try {
            $user = Auth::user();
            Destajo::crearDestajo(
                $this->presupuesto,
                $this->obraSelected,
                $this->clienteSelected,
                $this->servicioSelected,
                $user->id
            );
            // Enviar evento para refrescar la tabla
            $this->dispatch('refreshDestajosTable')->to(DestajosTable::class);
            // Limpiar los campos
            $this->limpiar();

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
        $this->reset('clienteSelected');
        $this->reset('servicioSelected');
        $this->dispatch('clearSelect2');
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
