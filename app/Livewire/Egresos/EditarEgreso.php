<?php

namespace App\Livewire\Egresos;

use App\Livewire\ServicesComponent;
use App\Models\Egreso;
use App\Models\Obra;
use App\Models\Proveedor;
use App\Models\FormaPago;
use App\Models\Banco;
use App\Models\Servicio;
use App\Models\Destajo;
use Illuminate\Support\Facades\Auth;

class EditarEgreso extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $cantidad, $fecha, $concepto;

    // Select obras
    public $obras;
    public $obraSeleccionada;

    # select destahos
    public $destajos;
    public $destajoSeleccionado;

    // Select proveedores
    public $proveedores;
    public $proveedorSeleccionado;

    // Select formas de pago
    public $formasPago;
    public $formaPagoSeleccionada;

    // Select bancos
    public $bancos;
    public $bancoSeleccionado;

    // Select servicios
    public $servicios;
    public $servicioSeleccionado;
    public $selectedServiciosEditar = [];

    public $listeners = ['cargarModalEditarEgreso', 'actualizarEgreso' => 'actualizarEgreso'];

    public function mount(Egreso $model)
    {
        $this->model = $model;
        $this->cantidad = $model->cantidad;
        $this->fecha = $model->fecha;
        $this->concepto = $model->concepto;
        $this->obraSeleccionada = $model->idObra;
        $this->proveedorSeleccionado = $model->idProveedor;
        $this->formaPagoSeleccionada = $model->idFormaPago;
        $this->bancoSeleccionado = $model->idBanco;
        $this->destajoSeleccionado = $model->idDestajo;

        $this->obras = Obra::with('detalle')->get();
        $this->destajos = Destajo::all();
        $this->proveedores = Proveedor::all();
        $this->formasPago = FormaPago::all();
        $this->bancos = Banco::all();

        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();

    }

    public function render()
    {
        $this->obras = Obra::with('detalle')->get();
        $this->destajos = Destajo::all();
        $this->proveedores = Proveedor::all();
        $this->formasPago = FormaPago::all();
        $this->bancos = Banco::all();
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();

        return view('livewire.egresos.editar-egreso');
    }

    public function editarEgreso()
    {
        $this->validate([
            'cantidad' => ['required', 'numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'fecha' => 'required|date',
            'concepto' => 'required|string',
            'obraSeleccionada' => 'required|exists:obra,id',
            'proveedorSeleccionado' => 'required|exists:proveedores,id',
            'formaPagoSeleccionada' => 'required|exists:formapago,id',
            'bancoSeleccionado' => 'required|exists:banco,id',
            'destajoSeleccionado' => 'nullable|exists:destajo,id',
            // 'selectedServiciosEditar' => 'required|array',
            // 'selectedServiciosEditar. *' => 'exists:servicio,id',
        ]);
        try {
            if($this->destajoSeleccionado){
                //busco el destajo que esta seleccionado
                $destajo = Destajo::findOrFail($this->destajoSeleccionado);
                // Suma de todos los egresos asociados al destajo, excepto el que estamos editando
                $sumaEgresos = Egreso::where('idDestajo', $this->destajoSeleccionado)->where('id', '!=', $this->model['id'])->sum('cantidad');
                // Validar si la nueva cantidad más la suma de los otros egresos no supera el presupuesto del destajo
                if (($sumaEgresos + $this->cantidad) > $destajo->presupuesto) {
                    $this->alertService->error($this, 'La cantidad total de egresos supera el presupuesto del destajo.');
                }
            }else{
                $this->destajoSeleccionado = null;
            }
            $user = Auth::user();
            $egreso= Egreso::editarEgreso($this->model['id'], $this->cantidad, $this->obraSeleccionada, $this->proveedorSeleccionado, $this->formaPagoSeleccionada, $this->bancoSeleccionado,  $this->destajoSeleccionado, $this->selectedServiciosEditar, $this->concepto, $this->fecha, $user->id);

            $this->dispatch('refreshEgresosTable')->to(EgresosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Egreso actualizado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Egreso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarEgreso($model)
    {
        $this->model = Egreso::find($model['id']);
        $this->cantidad = $this->model['cantidad'];
        $this->fecha = $this->model['fecha'];
        $this->concepto = $this->model['concepto'];
        $this->obraSeleccionada = $this->model['idObra'];
        $this->proveedorSeleccionado = $this->model['idProveedor'];
        $this->formaPagoSeleccionada = $this->model['idFormaPago'];
        $this->bancoSeleccionado = $this->model['idBanco'];
        $this->destajoSeleccionado = $this->model['idDestajo'];
        $this->selectedServiciosEditar =  Servicio::whereIn('id', $this->model->servicios->pluck('id'))->get();// Obtener IDs de servicios seleccionados
        $this->obras = Obra::with('detalle')->get();
        $this->destajos = Destajo::all();
        $this->proveedores = Proveedor::all();
        $this->formasPago = FormaPago::all();
        $this->bancos = Banco::all();
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();


        $this->dispatch('actualizarEgreso', [
            'obras' => $this->obras,
            'proveedores' => $this->proveedores,
            'formasPago' =>$this->formasPago,
            'bancos' =>$this->bancos,
            'servicios' =>$this->servicios,
            'destajos' => $this->destajos,
            'obraSeleccionada' => $this->obraSeleccionada,
            'bancoSeleccionado' =>  $this->bancoSeleccionado,
            'proveedorSeleccionado' => $this->proveedorSeleccionado,
            'formaPagoSeleccionada' => $this->formaPagoSeleccionada,
            'destajoSeleccionado' => $this->destajoSeleccionado,
        ]);

        $this->showModal = true;
    }

    public function limpiar()
    {
        $this->reset('cantidad');
        $this->reset('fecha');
        $this->reset('concepto');
        $this->reset('obraSeleccionada');
        $this->reset('proveedorSeleccionado');
        $this->reset('formaPagoSeleccionada');
        $this->reset('bancoSeleccionado');
        $this->reset('destajoSeleccionado');
        $this->reset('selectedServiciosEditar');
        $this->dispatch('resetSelect2');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updatedServicioSeleccionado($servicioId)
    {

        $this->validate([
            'servicioSeleccionado' => 'required|exists:servicio,id',
        ]);

        $servicio = Servicio::find($servicioId);

        // if ($servicio && !in_array($servicioId, $this->selectedServiciosEditar)) {
        //     $this->selectedServiciosEditar[] = $servicioId;
        // }
        if ($servicio && !$this->selectedServiciosEditar->contains($servicio)) {
            $this->selectedServiciosEditar->push($servicio);
        }
    }

    public function eliminarServicio($servicioId)
    {
        $this->selectedServiciosEditar = $this->selectedServiciosEditar->filter(function($servicio) use ($servicioId) {
            return $servicio->id !== $servicioId;
        });
    }

}
