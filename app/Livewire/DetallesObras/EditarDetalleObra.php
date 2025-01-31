<?php
namespace App\Livewire\DetallesObras;

use App\Livewire\ServicesComponent;
use App\Models\DetalleObra;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Proveedor;
use App\Models\Cliente;
use App\Models\EstadoObra;
use App\Models\Obra;
use App\Livewire\DetallesObras\DetallesObrasTable;
use Illuminate\Support\Facades\Auth;

class EditarDetalleObra extends ServicesComponent
{
    public $nombreObra, $total,$moneda,$fechaInicio,
    $fechaFin,$calle,$manzana,$lote,$metrosCuadrados,
    $fraccionamiento,$dictamenUsoSuelo, $estados, $paises,$ciudades, $paisSeleccionado, $estadoSeleccionado,$ciudadSeleccionado,
    $estadosObra, $estadoObraSeleccionado,$clienteSeleccionado, $clientes, $proveedores, $licenciaConstruccion, $contrato;
    #select proveedores
    public $proveedorSeleccionado = [];
    public $selectedProveedores = [];
    public $latitud, $longitud;
    public $model, $id;
    protected $listeners = ['refreshDireccion' => 'refreshDireccion'];

    public function mount($id)
    {
        $this->id = $id;
        $obra = Obra::with(['detalle' => function ($query) {
            $query->whereNull('deleted_at');
        }])->find($id);

        // Si no se encuentra la obra, redirigir a la página de error 404
        if (! $obra) {
            abort(404); // Redirige a la vista de error 404
        }
        $this->model = $obra->detalle;

        // Verifica si la dirección existe antes de acceder a sus propiedades
        if ($this->model->direccion) {
            $this->calle = $this->model->direccion->calle ?? null;
            $this->manzana = $this->model->direccion->manzana ?? null;
            $this->lote = $this->model->direccion->lote ?? null;
            $this->paisSeleccionado = $this->model->direccion->pais->id ?? null;
            $this->estadoSeleccionado = $this->model->direccion->estado->id ?? null;
            $this->ciudadSeleccionado = $this->model->direccion->ciudad->id ?? null;
            $this->metrosCuadrados = $this->model->direccion->metrosCuadrados ?? null;
            $this->fraccionamiento = $this->model->direccion->fraccionamiento ?? null;
            $this->latitud = $this->model->direccion->latitud ?? null;
            $this->longitud = $this->model->direccion->longitud ?? null;
        }
        // Resto de las propiedades
        $this->nombreObra = $this->model->nombreObra;
        $this->total = $this->model->total;
        $this->moneda = $this->model->moneda;
        $this->fechaInicio = $this->model->fechaInicio;
        $this->fechaFin = $this->model->fechaFin;
        $this->dictamenUsoSuelo = $this->model->dictamenUsoSuelo;

        // Cargar los países y estados de obra
        $this->paises = Pais::all();
        $this->estados = Estado::all();
        $this->ciudades = Ciudad::all();
        $this->proveedores = Proveedor::all();
        $this->clientes = Cliente::all();
        $this->estadosObra = EstadoObra::all();
        $this->estadoObraSeleccionado = $this->model->obra->estado->id ?? null;
        $this->clienteSeleccionado = $this->model->obra->idCliente ?? null;
        $this->selectedProveedores = Proveedor::whereIn('id', $this->model->obra->proveedores?->pluck('id') ?? [])->get();
        $this->licenciaConstruccion= $this->model->obra->licenciaConstruccion ?? null;
        $this->contrato= $this->model->obra->contrato ?? null;
    }

    public function render()
    {
        return view('livewire.detalles-obras.editar-detalle-obra');
    }

    public function editarDetalleObra()
    {
        $this->validate([
            'nombreObra'=> 'required|string',
            'total' => ['required', 'numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            //'moneda'=> 'nullable|in:mnx,dls',
            'fechaInicio'=> 'required|date',
            'fechaFin'=> 'required|date',
            'calle'=> 'required|string',
            'manzana'=> 'nullable|string',
            'lote'=> 'nullable|string',
            'metrosCuadrados'=> 'nullable|numeric',
            'fraccionamiento'=> 'required|string',

            //'dictamenUsoSuelo'=> 'nullable|string',
            'paisSeleccionado' => 'nullable|exists:paises,id',
            'estadoSeleccionado' => 'nullable|exists:estados,id',
            'ciudadSeleccionado' => 'nullable|exists:ciudades,id',
            'estadoObraSeleccionado' => 'nullable|exists:estadoobra,id',

            'clienteSeleccionado' => 'required|min:1|exists:cliente,id',
            //'selectedProveedores' => 'nullable|array',
        ]);
        try{
            $this->latitud = substr($this->latitud, 0, -1);
            $this->longitud = substr($this->longitud, 0, -1);
            $user = Auth::user();
            DetalleObra::editarDetalleObra(
            $this->model->id, $this->nombreObra, $this->total,$this->moneda,$this->fechaInicio, $this->fechaFin,$this->dictamenUsoSuelo,
            $this->estadoObraSeleccionado,
            $this->calle,$this->manzana,$this->lote,$this->metrosCuadrados, $this->fraccionamiento,$this->estadoSeleccionado, $this->paisSeleccionado, $this->ciudadSeleccionado,$this->latitud, $this->longitud,
            $this->selectedProveedores, $this->clienteSeleccionado,
            $user->id);
            $this->render();
            // Emitir evento para recargar el mapa con las nuevas coordenadas
            //$this->dispatch('refreshMapa', $this->latitud, $this->longitud);
            $this->alertService->success($this, 'Detalle Obra editado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar la obra');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function refreshDireccion($calle, $estado, $pais, $latitud, $longitud)
    {
        $this->calle = $calle;
        $this->latitud = $latitud."s";
        $this->longitud = $longitud."s";
        // Busca el ID del estado sin importar mayúsculas o minúsculas
        $estadoEncontrado = Estado::whereRaw('LOWER(nombre) = ?', [strtolower($estado)])->first();
        if ($estadoEncontrado) {
            $this->estadoSeleccionado = $estadoEncontrado->id;
        } else {
            // Manejar el caso donde no se encontró el estado
            $this->estadoSeleccionado = null;
        }

        // Busca el ID del país sin importar mayúsculas o minúsculas
        $paisEncontrado = Pais::whereRaw('LOWER(nombre) = ?', [strtolower($pais)])->first();

        if ($paisEncontrado) {
            $this->paisSeleccionado = $paisEncontrado->id;
        } else {
            // Manejar el caso donde no se encontró el país
            $this->paisSeleccionado = null;
        }
        //$this->dispatch( 'recargarMapa', $this->model->id);
    }

    public function updatedProveedorSeleccionado($proveedorId)
    {
        $this->validate([
            'proveedorSeleccionado' => 'required|exists:proveedores,id',
        ]);

        $proveedor = Proveedor::find($proveedorId);

        if ($proveedor && !$this->selectedProveedores->contains($proveedor)) {
            $this->selectedProveedores->push($proveedor);
        }
    }



    public function eliminarProveedor($proveedorId)
    {
        $this->selectedProveedores = $this->selectedProveedores->filter(function($proveedor) use ($proveedorId) {
            return $proveedor->id !== $proveedorId;
        });
    }

}
