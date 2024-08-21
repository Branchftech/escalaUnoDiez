<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidad extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'unidad';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearUnidad($nombre, $userId)
    {
        $unidad = new Unidad();
        $unidad->nombre = $nombre;
        $unidad->created_at = now();
        $unidad->created_by =  $userId;
        $unidad->save();
        return $unidad;
    }


    static function editarUnidad($id, $nombre, $userId)
    {
        $unidad = Unidad::findOrfail($id);
        $unidad->nombre = $nombre;
        $unidad->updated_at = now();
        $unidad->updated_by =  $userId;
        $unidad->save();
        return $unidad;
    }

    static function eliminarUnidad($id, $userId)
    {
        $unidad = Unidad::findOrfail($id);
        $unidad->activo = 0;
        $unidad->deleted_at = now();
        $unidad->deleted_by =  $userId;
        $unidad->save();
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
