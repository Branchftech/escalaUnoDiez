<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class DetalleObra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'detalleobra';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombreObra',
        'total',
        'moneda',
        'fechaInicio',
        'fechaFin',
        'idDireccionObra',
        'dictamenUsoSuelo',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];


    static function crearDetalleObra($nombreObra, $total,$moneda,$fechaInicio,
    $fechaFin,$croquis,$calle,$manzana,$lote,$metrosCuadrados,
    $fraccionamiento,$dictamenUsoSuelo,
    $userId)
    {
        $obra = new DetalleObra();
        $obra->nombreObra = $nombreObra;
        $obra->total = $total;
        $obra->moneda = $moneda;
        $obra->fechaInicio = $fechaInicio;
        $obra->fechaFin = $fechaFin;
        $obra->croquis = $croquis;
        $obra->calle = $calle;
        $obra->manzana = $manzana;
        $obra->lote = $lote;
        $obra->metrosCuadrados = $metrosCuadrados;
        $obra->fraccionamiento = $fraccionamiento;
        $obra->dictamenUsoSuelo = $dictamenUsoSuelo;
        $obra->created_at = now();
        $obra->created_by =  $userId;
        $obra->save();
        return $obra;
    }


    static function editarDetalleObra(
    $id, $nombreObra, $total,$moneda,$fechaInicio, $fechaFin,$dictamenUsoSuelo,
    $estadoObra,
    $calle,$manzana,$lote,$metrosCuadrados, $fraccionamiento,$estado, $pais, $latitud,$longitud,
    $proveedores = [], $cliente,
    $userId)
    {
        try {
            $detalleObra = DetalleObra::findOrFail($id);

            $detalleObra->nombreObra = $nombreObra;
            $detalleObra->total = $total;
            $detalleObra->moneda = $moneda;
            $detalleObra->fechaInicio = $fechaInicio;
            $detalleObra->fechaFin = $fechaFin;
            $detalleObra->dictamenUsoSuelo = $dictamenUsoSuelo;
			$detalleObra->updated_at = now();
            $detalleObra->updated_by = $userId;

            // Asegúrate de que los cambios en `obra` y `direccion` se guarden
            $detalleObra->obra->idEstadoObra = $estadoObra;
            $detalleObra->obra->idCliente = $cliente;
            if (!empty($proveedores)) {
                $proveedoresCollection = collect($proveedores);
                $proveedorIds = $proveedoresCollection->pluck('id')->toArray();
                $detalleObra->obra->proveedores()->sync($proveedorIds);
            }else{
                $detalleObra->obra->proveedores()->sync([]);
            }
            $detalleObra->obra->save();

            $detalleObra->direccion->calle = $calle;
            $detalleObra->direccion->manzana = $manzana;
            $detalleObra->direccion->lote = $lote;
            $detalleObra->direccion->metrosCuadrados = $metrosCuadrados;
            $detalleObra->direccion->fraccionamiento = $fraccionamiento;
            $detalleObra->direccion->idPais = $pais;
            $detalleObra->direccion->idEstado = $estado;
            $detalleObra->direccion->latitud = $latitud;
            $detalleObra->direccion->longitud = $longitud;
            $detalleObra->direccion->save();

            // Finalmente guarda el `detalleObra`
            $detalleObra->save();

            return $detalleObra;
        } catch (\Throwable $th) {
            Log::error('Error al actualizar DetalleObra: ' . $th->getMessage(), [
                'id' => $id,
                'nombreObra' => $nombreObra,
                'userId' => $userId,
                // Aquí puedes agregar más información relevante para depuración
            ]);

            // Relanzar la excepción para depuración adicional
            throw $th;
        }

    }

    static function eliminarDetalleObra($id, $userId)
    {
        $obra = DetalleObra::findOrfail($id);
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
    // Relación que indica la direccion de la obra
    public function direccion()
    {
        return $this->belongsTo(DireccionObra::class, 'idDireccionObra');
    }

     // Definir la relación uno a uno con el modelo obra
     public function obra()
     {
         return $this->hasOne(Obra::class, 'idDetalleObra');
     }

}
