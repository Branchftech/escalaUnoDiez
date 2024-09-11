<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Obra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'obra';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'contrato',
        'idDetalleObra',
        'idCliente',
        'idEstadoObra',
        'licenciaConstruccion',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearObra( $nombreObra, $total,$moneda,$fechaInicio, $fechaFin,$dictamenUsoSuelo,
    $estadoObra, $contrato, $licenciaConstruccion,
    $calle,$manzana,$lote,$metrosCuadrados, $fraccionamiento,$estado, $pais,$proveedores = [], $cliente,
    $userId)
    {
        // try {
        //     $Obra = new Obra();

        //     $Obra->detalle->nombreObra = $nombreObra;
        //     $Obra->detalle->total = $total;
        //     $Obra->detalle->moneda = $moneda;
        //     $Obra->detalle->fechaInicio = $fechaInicio;
        //     $Obra->detalle->fechaFin = $fechaFin;
        //     $Obra->detalle->dictamenUsoSuelo = $dictamenUsoSuelo;
        //     $Obra->detalle->created_at = now();
        //     $Obra->detalle->created_by = $userId;

        //     // Asegúrate de que los cambios en `obra` y `direccion` se guarden
        //     $Obra->idEstadoObra = $estadoObra;
        //     $Obra->contrato = $contrato;
        //     $Obra->licenciaConstruccion = $licenciaConstruccion;
        //     $Obra->created_at = now();
        //     $Obra->created_by = $userId;

        //     $Obra->detalle->direccion->calle = $calle;
        //     $Obra->detalle->direccion->manzana = $manzana;
        //     $Obra->detalle->direccion->lote = $lote;
        //     $Obra->detalle->direccion->metrosCuadrados = $metrosCuadrados;
        //     $Obra->detalle->direccion->fraccionamiento = $fraccionamiento;
        //     $Obra->detalle->direccion->idPais = $pais;
        //     $Obra->detalle->direccion->idEstado = $estado;
        //     $Obra->detalle->direccion->created_at = now();
        //     $Obra->detalle->direccion->created_by = $userId;
        //     $Obra->detalle->direccion->save();
        //     $Obra->detalle->save();

        //     // Finalmente guarda el `detalleObra`
        //     $Obra->save();

        //     return $Obra;
        // } catch (\Throwable $th) {
        //     Log::error('Error al crear obra: ' . $th->getMessage());
        //     throw $th;
        // }
            // Crear el detalle de la obra
            $detalle = new DetalleObra([
                'nombreObra' => $nombreObra,
                'total' => $total,
                'moneda' => $moneda,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'dictamenUsoSuelo' => $dictamenUsoSuelo,
                'created_at' => now(),
                'created_by' => $userId,
            ]);
            $detalle->save();

            // Crear la dirección asociada al detalle
            $direccion = new DireccionObra([
                'calle' => $calle,
                'manzana' => $manzana,
                'lote' => $lote,
                'metrosCuadrados' => $metrosCuadrados,
                'fraccionamiento' => $fraccionamiento,
                'idPais' => $pais,
                'idEstado' => $estado,
                'created_at' => now(),
                'created_by' => $userId,
            ]);
            $direccion->save();

            // Asignar la dirección al detalle
            $detalle->direccion()->associate($direccion);
            $detalle->save();

            // Crear la obra
            $obra = new Obra([
                'idDetalleObra' => $detalle->id,
                'idCliente' => $cliente, // Asigna el ID del cliente si lo tienes
                'idEstadoObra' => $estadoObra,
                'contrato' => $contrato,
                'licenciaConstruccion' => $licenciaConstruccion,
                'created_at' => now(),
                'created_by' => $userId,
            ]);

            $obra->save();
            if (!empty($proveedores)) {
                $proveedoresCollection = collect($proveedores);
                // Usamos sync para asociar los materiales al insumo
                $obra->proveedores()->sync($proveedoresCollection->all());
            }else{
                $obra->proveedores()->sync([]);
            }
            return $obra;

    }

    static function editarObra($id, $contrato, $userId)
    {
        $obra = Obra::findOrfail($id);
        $obra->contrato = $contrato;
        $obra->updated_at = now();
        $obra->updated_by =  $userId;
        $obra->save();
        return $obra;
    }

    static function eliminarObra($id, $userId)
    {
        $obra = Obra::findOrfail($id);
        $obra->activo = 0;
        $obra->deleted_at = now();
        $obra->deleted_by =  $userId;
        $obra->save();
    }

    public function getCreatedAtCustomAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    // Relación que indica qué usuario creó una entrada específica
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación que indica qué usuario actualizó por última vez una entrada
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relación que indica qué usuario eliminó una entrada
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // relación con el modelo detalle Obra
    public function detalle()
    {
        return $this->belongsTo(DetalleObra::class, 'idDetalleObra');
    }
    // relación con el modelo cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }
    // relación con el modelo proveedores
    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'proveedor_obra', 'idObra', 'idProveedor');
    }
    // relación con el modelo estado
    public function estado()
    {
        return $this->belongsTo(EstadoObra::class, 'idEstadoObra');
    }
    // Este método define la relación con el modelo bitacoraObra
    public function bitacoras()
    {
        return $this->hasMany(BitacoraObra::class, 'idObra');
    }

    // Este método define la relación con el modelo bitacoraObra
    public function documentos()
    {
        return $this->hasMany(DocumentoObra::class, 'idObra');
    }

}
