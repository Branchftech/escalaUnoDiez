<?php
namespace App\Livewire\DetallesObras;

use App\Livewire\ServicesComponent;
use App\Models\DetalleObra;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\EstadoObra;
use App\Models\Obra;

use App\Livewire\DetallesObras\DetallesObrasTable;
use Illuminate\Support\Facades\Auth;

class EditarDetalleObra extends ServicesComponent
{
    public $nombreObra, $total,$moneda,$fechaInicio,
    $fechaFin,$calle,$manzana,$lote,$metrosCuadrados,
    $fraccionamiento,$dictamenUsoSuelo, $estados, $paises, $paisSeleccionado, $estadoSeleccionado,
    $estadosObra, $estadoObraSeleccionado;
    public $model, $id;


    public function mount($id)
    {
        $this->id= $id;
        $obra = Obra::find($id);
        $this->model =  $obra->detalle;
        $this->calle = $this->model->direccion->calle;
        $this->manzana = $this->model->direccion->manzana;
        $this->lote = $this->model->direccion->lote;
        $this->paisSeleccionado = $this->model->direccion->pais->id;
        $this->estadoSeleccionado = $this->model->direccion->estado->id;
        $this->metrosCuadrados = $this->model->direccion->metrosCuadrados;
        $this->fraccionamiento = $this->model->direccion->fraccionamiento;
        $this->nombreObra = $this->model->nombreObra;
        $this->total = $this->model->total;
        $this->moneda = $this->model->moneda;
        $this->fechaInicio = $this->model->fechaInicio;
        $this->fechaFin = $this->model->fechaFin;
        $this->dictamenUsoSuelo = $this->model->dictamenUsoSuelo;
        $this->paises = Pais::all();
        $this->estadosObra = EstadoObra::all();
        $this->estadoObraSeleccionado= $this->model->obra->estado->id;
        $this->estados = [];
    }

    public function render()
    {
        return view('livewire.detalles-obras.editar-detalle-obra');
    }

    public function cambiar()
    {
        $this->estados = Estado::where('idPais', $this->paisSeleccionado)->get();
        $this->estadoSeleccionado = null;
    }

    public function editarDetalleObra()
    {
        $this->validate([
            'nombreObra'=> 'required|string',
            'total' => 'required|numeric',
            'moneda'=> 'required|in:mnx,dls',
            'fechaInicio'=> 'required|date',
            'fechaFin'=> 'required|date',
            'calle'=> 'required|string',
            'manzana'=> 'required|string',
            'lote'=> 'required|string',
            'metrosCuadrados'=> 'required|numeric',
            'fraccionamiento'=> 'required|string',
            'dictamenUsoSuelo'=> 'required|string',
            'paisSeleccionado' => 'required|exists:paises,id',
            'estadoSeleccionado' => 'required|exists:estados,id',
            'estadoObraSeleccionado' => 'required|exists:estadoobra,id',
        ]);
        try{
            $user = Auth::user();
            DetalleObra::editarDetalleObra(
            $this->model->id, $this->nombreObra, $this->total,$this->moneda,$this->fechaInicio, $this->fechaFin,$this->dictamenUsoSuelo,
            $this->estadoObraSeleccionado,
            $this->calle,$this->manzana,$this->lote,$this->metrosCuadrados, $this->fraccionamiento,$this->estadoSeleccionado, $this->paisSeleccionado,
            $user->id);

            //$this->dispatch('refreshClientesTable')->to(ClientesTable::class);
            $this->render();

            // $this->limpiar();
            $this->alertService->success($this, 'Detalle Obra editado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar la obra');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    // public function limpiar()
    // {
        // $this->reset('nombreObra');
        // $this->reset('total');
        // $this->reset('moneda');
        // $this->reset('fechaInicio');
        // $this->reset('fechaFin');
        // $this->reset('calle');
        // $this->reset('manzana');
        // $this->reset('lote');
        // $this->reset('metrosCuadrados');
        // $this->reset('fraccionamiento');
        // $this->reset('dictamenUsoSuelo');
        // $this->reset('estadoObraSeleccionado');
        // $this->reset('estadoSeleccionado');
        // $this->reset('paisSeleccionado');

        // $this->paises = Pais::all();
        // $this->estados = [];
    //}
}
