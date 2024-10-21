<?php

namespace App\Livewire\Ingresos;

use App\Livewire\ServicesComponent;
use App\Models\Ingreso;
use App\Models\Obra;
use App\Models\Cliente;
use App\Models\FormaPago;
use App\Models\Banco;
use Illuminate\Support\Facades\Auth;

class EditarIngreso extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $cantidad, $fecha, $concepto, $factura;

    // Select obrasEditarIngreso
    public $obrasEditarIngreso;
    public $obraSeleccionada;

    // Select clientesEditarIngreso
    public $clientesEditarIngreso;
    public $clienteSeleccionado;

    // Select formas de pago
    public $formasPagoEditarIngreso;
    public $formaPagoSeleccionada;

    // Select bancosEditarIngreso
    public $bancosEditarIngreso;
    public $bancoSeleccionado;

    public $listeners = ['cargarModalEditarIngreso', 'actualizarIngreso' => 'actualizarIngreso'];

    public function mount(Ingreso $model)
    {
        $this->model = $model;
        $this->factura = $model->factura;
        $this->cantidad = $model->cantidad;
        $this->fecha = $model->fecha;
        $this->concepto = $model->concepto;
        $this->obraSeleccionada = $model->idObra;
        $this->clienteSeleccionado = $model->idCliente;
        $this->formaPagoSeleccionada = $model->idFormaPago;
        $this->bancoSeleccionado = $model->idBanco;

        $this->obrasEditarIngreso = Obra::all();
        $this->clientesEditarIngreso = Cliente::all();
        $this->formasPagoEditarIngreso = FormaPago::all();
        $this->bancosEditarIngreso = Banco::all();
    }

    public function render()
    {
        $this->obrasEditarIngreso = Obra::all();
        $this->clientesEditarIngreso = Cliente::all();
        $this->formasPagoEditarIngreso = FormaPago::all();
        $this->bancosEditarIngreso = Banco::all();

        return view('livewire.ingresos.editar-ingreso');
    }

    public function editarIngreso()
    {
        $this->validate([
            'factura' => 'required|string|max:255',
            'cantidad' => ['required', 'numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'fecha' => 'required|date',
            'concepto' => 'required|string|max:100',
            'obraSeleccionada' => 'required|exists:obra,id',
            'clienteSeleccionado' => 'required|exists:cliente,id',
            'formaPagoSeleccionada' => 'required|exists:formapago,id',
            'bancoSeleccionado' => 'required|exists:banco,id',
        ]);

        try {
            $user = Auth::user();
            Ingreso::editarIngreso(
                $this->model['id'],
                $this->factura,
                $this->cantidad,
                $this->obraSeleccionada,
                $this->clienteSeleccionado,
                $this->formaPagoSeleccionada,
                $this->bancoSeleccionado,
                $this->concepto,
                $this->fecha,
                $user->id
            );

            $this->dispatch('refreshIngresosTable')->to(IngresosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Ingreso actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Ingreso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarIngreso($model)
    {
        $this->model = Ingreso::find($model['id']);
        $this->factura = $this->model['factura'];
        $this->cantidad = $this->model['cantidad'];
        $this->fecha = $this->model['fecha'];
        $this->concepto = $this->model['concepto'];
        $this->obraSeleccionada = $this->model['idObra'];
        $this->clienteSeleccionado = $this->model['idCliente'];
        $this->formaPagoSeleccionada = $this->model['idFormaPago'];
        $this->bancoSeleccionado = $this->model['idBanco'];

        $this->obrasEditarIngreso = Obra::with('detalle')->get();
        $this->clientesEditarIngreso = Cliente::all();
        $this->formasPagoEditarIngreso = FormaPago::all();
        $this->bancosEditarIngreso = Banco::all();

        $this->dispatch('actualizarIngreso', [
            'obrasEditarIngreso' => $this->obrasEditarIngreso,
            'clientesEditarIngreso' => $this->clientesEditarIngreso,
            'formasPagoEditarIngreso' =>$this->formasPagoEditarIngreso,
            'bancosEditarIngreso' =>$this->bancosEditarIngreso,
            'obraSeleccionada' => $this->obraSeleccionada,
            'bancoSeleccionado' =>  $this->bancoSeleccionado,
            'clienteSeleccionado' => $this->clienteSeleccionado,
            'formaPagoSeleccionada' => $this->formaPagoSeleccionada,
        ]);
        $this->showModal = true;
    }

    public function limpiar()
    {
        $this->reset('factura');
        $this->reset('cantidad');
        $this->reset('fecha');
        $this->reset('concepto');
        $this->reset('obraSeleccionada');
        $this->reset('clienteSeleccionado');
        $this->reset('formaPagoSeleccionada');
        $this->reset('bancoSeleccionado');
        $this->dispatch('resetSelect2');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
