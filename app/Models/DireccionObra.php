<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionObra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'direccionobra';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'calle',
        'manzana',
        'lote',
        'latitud',
        'longitud',
        'metrosCuadrados',
        'fraccionamiento',
        'idPais',
        'idEstado',
        'idCiudad',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    static function crearDireccionObra($calle, $manzana,$lote, $metrosCuadrados,$fraccionamiento, $idPais, $idEstado, $idCiudad,$latitud,$longitud, $userId)
    {
        $estado = new DireccionObra();
        $estado->calle = $calle;
        $estado->manzana =$manzana;
        $estado->lote = $lote;
        $latitud->manzana =$latitud;
        $longitud->lote = $longitud;
        $estado->metrosCuadrados =$metrosCuadrados;
        $estado->fraccionamiento = $fraccionamiento;
        $estado->idPais =$idPais;
        $estado->idEstado =$idEstado;
        $estado->idCiudad =$idCiudad;
        $estado->created_at = now();
        $estado->created_by =  $userId;
        $estado->save();
        return $estado;
    }


    static function editarDireccionObra($id, $calle, $manzana,$lote, $metrosCuadrados,$fraccionamiento, $idPais,$idEstado,$idCiudad,$latitud,$longitud, $userId)
    {
        $estado = DireccionObra::findOrfail($id);
        $estado->calle = $calle;
        $estado->manzana =$manzana;
        $estado->lote = $lote;
        $latitud->manzana =$latitud;
        $longitud->lote = $longitud;
        $estado->metrosCuadrados =$metrosCuadrados;
        $estado->fraccionamiento = $fraccionamiento;
        $estado->idPais =$idPais;
        $estado->idEstado =$idEstado;
        $estado->idCiudad =$idCiudad;
        $estado->updated_at = now();
        $estado->updated_by =  $userId;
        $estado->save();
        return $estado;
    }

    static function eliminarDireccionObrao($id, $userId)
    {
        $estado = DireccionObra::findOrfail($id);
        $estado->deleted_at = now();
        $estado->deleted_by =  $userId;
        $estado->save();
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
    // Definir la relación con el modelo Pais
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'idPais');
    }
    // Definir la relación con el modelo Estado (si existe)
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }
    // Definir la relación con el modelo ciudad (si existe)
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'idCiudad');
    }

}
