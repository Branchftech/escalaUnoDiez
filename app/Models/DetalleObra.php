<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleObra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'detalleObra';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombreObra',
        'total',
        'moneda',
        'fechaInicio',
        'fechaFin',
        'croquis',
        'calle',
        'manzana',
        'lote',
        'metrosCuadrados',
        'fraccionamiento',
        'dictamenUsoSuelo',
        'incrementoDensidad',
        'informeDensidad',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearDetalleObra($nombreObra, $total,$moneda,$fechaInicio,
    $fechaFin,$croquis,$calle,$manzana,$lote,$metrosCuadrados,
    $fraccionamiento,$dictamenUsoSuelo,$incrementoDensidad,
    $informeDensidad, $userId)
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
        $obra->incrementoDensidad = $incrementoDensidad;
        $obra->informeDensidad = $informeDensidad;
        $obra->created_at = now();
        $obra->created_by =  $userId;
        $obra->save();
        return $obra;
    }


    static function editarDetalleObra($id, $nombreObra, $total,$moneda,$fechaInicio,
    $fechaFin,$croquis,$calle,$manzana,$lote,$metrosCuadrados,
    $fraccionamiento,$dictamenUsoSuelo,$incrementoDensidad,
    $informeDensidad, $userId)
    {
        $obra = DetalleObra::findOrfail($id);
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
        $obra->incrementoDensidad = $incrementoDensidad;
        $obra->informeDensidad = $informeDensidad;
        $obra->updated_at = now();
        $obra->updated_by =  $userId;
        $obra->save();
        return $obra;
    }

    static function eliminarDetalleObra($id, $userId)
    {
        $obra = DetalleObra::findOrfail($id);
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


}
