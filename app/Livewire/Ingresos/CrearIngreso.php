<?php

namespace App\Livewire\Ingresos;

use App\Livewire\ServicesComponent;
use App\Models\Ingreso;
use App\Models\Obra;
use App\Models\Cliente;
use App\Models\FormaPago;
use App\Models\Banco;
use Illuminate\Support\Facades\Auth;

class CrearIngreso extends ServicesComponent
{
    public $cantidad, $concepto, $fecha, $factura;
    public $showModal = false;

    # select obras
    public $obras;
    public $obraSelected;

    # select clientes
    public $clientes;
    public $clienteSelected;

    # select forma de pago
    public $formasPago;
    public $formaPagoSelected;

    # select bancos
    public $bancos;
    public $bancoSelected;

    protected $listeners = ['refreshCrearIngreso' => '$refresh'];

    public function mount()
    {
        $this->obras = Obra::all();
        $this->clientes = Cliente::all();
        $this->formasPago = FormaPago::all();
        $this->bancos = Banco::all();
    }

    public function render()
    {
        $this->obras = Obra::all();
        $this->clientes = Cliente::all();
        $this->formasPago = FormaPago::all();
        $this->bancos = Banco::all();

        return view('livewire.ingresos.crear-ingreso');
    }

    public function crearIngreso()
    {
        $this->validate([
            'factura' => 'nullable|string|max:255',
            'cantidad' => ['required', 'numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'concepto' => 'required|string|max:100',
            'fecha' => 'required|date',
            'obraSelected' => 'required|exists:obra,id',
            'clienteSelected' => 'required|exists:cliente,id',
            'formaPagoSelected' => 'required|exists:formapago,id',
            'bancoSelected' => 'required|exists:banco,id',
        ]);

        try {
            $user = Auth::user();
            Ingreso::crearIngreso(
                $this->factura,
                $this->cantidad,
                $this->clienteSelected,
                $this->formaPagoSelected,
                $this->bancoSelected,
                $this->concepto,
                $this->fecha,
                $this->obraSelected,
                $user->id
            );
            //Enviar evento para refrescar la tabla
            $this->dispatch('refreshIngresosTable')->to(IngresosTable::class);
            //Limpiar los campos
            $this->limpiar();

            //Mostrar mensaje de éxito
            $this->alertService->success($this, 'Ingreso creado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el ingreso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('factura');
        $this->reset('cantidad');
        $this->reset('concepto');
        $this->reset('fecha');
        $this->reset('obraSelected');
        $this->reset('clienteSelected');
        $this->reset('formaPagoSelected');
        $this->reset('bancoSelected');
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
