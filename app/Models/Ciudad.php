<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciudad extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'ciudades';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'idEstado',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearCiudad($nombre, $userId, $idEstado)
    {
        $ciudad = new Ciudad();
        $ciudad->nombre = $nombre;
        $ciudad->idEstado =  $idEstado;
        $ciudad->created_at = now();
        $ciudad->created_by =  $userId;
        $ciudad->save();
        return $ciudad;
    }


    static function editarCiudad($id, $nombre, $userId, $idEstado)
    {
        $ciudad = Ciudad::findOrfail($id);
        $ciudad->nombre = $nombre;
        $ciudad->idEstado =  $idEstado;
        $ciudad->updated_at = now();
        $ciudad->updated_by = $userId;
        $ciudad->save();


        return $ciudad;
    }

    static function eliminarCiudad($id, $userId)
    {
        $ciudad = Ciudad::findOrfail($id);
        $ciudad->deleted_at = now();
        $ciudad->deleted_by =  $userId;
        $ciudad->save();
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

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }
}
