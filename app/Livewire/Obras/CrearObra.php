<?php
namespace App\Livewire\Obras;

use App\Livewire\ServicesComponent;
use App\Models\Obra;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Proveedor;
use App\Models\Cliente;
use App\Models\EstadoObra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CrearObra extends ServicesComponent
{
    public $nombreObra, $total,$moneda,$fechaInicio,
    $fechaFin,$calle,$manzana,$lote,$metrosCuadrados,
    $fraccionamiento,$dictamenUsoSuelo, $estados, $paises,$ciudades, $proveedores, $clientes, $paisSeleccionado, $estadoSeleccionado,$ciudadSeleccionado, $clienteSeleccionado,
    $estadosObra, $estadoObraSeleccionado, $licenciaConstruccion, $contrato;
    #select proveedores
    public $proveedoresSeleccionados = [];
    public $selectedProveedores = [];

    public function mount()
    {
        #select materiales

        //direccion de obra
        // $this->calle = $this->model->detalle->direccion->calle;
        // $this->manzana = $this->model->detalle->direccion->manzana;
        // $this->lote = $this->model->detalle->direccion->lote;
        // $this->paisSeleccionado = $this->model->detalle->direccion->pais->id;
        // $this->estadoSeleccionado = $this->model->detalle->direccion->estado->id;
        // $this->metrosCuadrados = $this->model->detalle->direccion->metrosCuadrados;
        // $this->fraccionamiento = $this->model->detalle->direccion->fraccionamiento;
        // //detalle de obra
        // $this->nombreObra = $this->model->detalle->nombreObra;
        // $this->total = $this->model->detalle->total;
        // $this->moneda = $this->model->detalle->moneda;
        // $this->fechaInicio = $this->model->detalle->fechaInicio;
        // $this->fechaFin = $this->model->detalle->fechaFin;
        // $this->dictamenUsoSuelo = $this->model->detalle->dictamenUsoSuelo;
        $this->paises = Pais::all();
        $this->estados = [];
        $this->ciudades = [];
        $this->estadosObra = EstadoObra::all();
        //obra
        $this->proveedores = Proveedor::all();
        $this->clientes = Cliente::all();
        // $this->estadoObraSeleccionado= $this->model->estado->id;
        // $this->contrato= $this->model->contrato;
        // $this->licenciaConstruccion= $this->model->licenciaConstruccion;
        // $this->proveedorObraSeleccionado= $this->model->proveedor->id;
        // $this->clienteObraSeleccionado= $this->model->cliente->id;

    }

    public function render()
    {
        return view('livewire.obras.crear-obra');
    }

    public function cambiar()
    {
        $this->estados = Estado::where('idPais', $this->paisSeleccionado)->get();
        $this->estadoSeleccionado = null;
    }

    public function cambiarCiudad()
    {
        if ($this->estadoSeleccionado) {
            $this->ciudades = Ciudad::where('idEstado', $this->estadoSeleccionado)->get();
        } else {
            $this->ciudades = [];
        }

        $this->ciudadSeleccionado = null;
    }

    public function crearObra()
    {

        $this->validate([
            'nombreObra'=> 'required|string',
            'total' => ['required', 'numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            //'moneda'=> 'required|in:mnx,dls',
            'fechaInicio'=> 'required|date',
            'fechaFin'=> 'required|date',
            'calle'=> 'required|string',
            'manzana'=> 'nullable|string',
            'lote'=> 'nullable|string',
            'metrosCuadrados'=> 'nullable|numeric',
            'fraccionamiento'=> 'required|string',
            //'dictamenUsoSuelo'=> 'required|string',
            'contrato'=> 'nullable|string',
            'licenciaConstruccion'=> 'nullable|string',
            'paisSeleccionado' => 'nullable|min:1|exists:paises,id',
            'estadoSeleccionado' => 'nullable|min:1|exists:estados,id',
            'ciudadSeleccionado' => 'nullable|min:1|exists:ciudades,id',
            'estadoObraSeleccionado' => 'nullable|min:1|exists:estadoobra,id',
            'clienteSeleccionado' => 'required|min:1|exists:cliente,id',
            'proveedoresSeleccionados.*' => 'nullable|min:1|exists:proveedores,id',
            'proveedoresSeleccionados' => 'nullable|array',
        ]);
        try{
            $user = Auth::user();
            Obra::crearObra( $this->nombreObra, $this->total,$this->moneda,$this->fechaInicio, $this->fechaFin,$this->dictamenUsoSuelo,
            $this->estadoObraSeleccionado ?? 9,$this->contrato, $this->licenciaConstruccion,
            $this->calle,$this->manzana,$this->lote,$this->metrosCuadrados, $this->fraccionamiento,$this->estadoSeleccionado, $this->paisSeleccionado, $this->ciudadSeleccionado, $this->proveedoresSeleccionados, $this->clienteSeleccionado,
            $user->id);

            $this->dispatch('refreshObrasTable')->to(ObrasTable::class);
            $this->render();
            $this->alertService->success($this, 'Obra creada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear la obra');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function updatedProveedorSeleccionado($proveedor)
    {
        $this->validate([
            'proveedoresSeleccionados.*' => 'exists:proveedores,id', // Validación de que cada ID existe en la tabla materiales
        ]);

        $proveedor = Proveedor::find($proveedor);

        if ($proveedor && !in_array($proveedor, $this->selectedProveedores)) {
            $this->selectedProveedores[] = $proveedor;
        }
    }

    public function eliminarProveedores($index)
    {
        $this->selectedProveedores = array_filter($this->selectedProveedores, function($proveedor) use ($index) {
            return $proveedor->id !== $index;
        });
    }

    public function limpiar()
    {
        $this->reset('nombreObra','total','moneda','fechaInicio',
            'fechaFin','calle','manzana','lote','metrosCuadrados',
            'fraccionamiento','dictamenUsoSuelo','paisSeleccionado', 'estadoSeleccionado','ciudadSeleccionado','clienteSeleccionado',
            'estadoObraSeleccionado', 'licenciaConstruccion', 'contrato');

    }


}
