<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoObra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'estadoobra';
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

    static function crearEstadoObra($nombre, $userId)
    {
        $estadoObra = new EstadoObra();
        $estadoObra->nombre = $nombre;
        $estadoObra->created_at = now();
        $estadoObra->created_by =  $userId;
        $estadoObra->save();
        return $estadoObra;
    }


    static function editarEstadoObra($id, $nombre, $userId)
    {
        $estadoObra = EstadoObra::findOrfail($id);
        $estadoObra->nombre = $nombre;
        $estadoObra->updated_at = now();
        $estadoObra->updated_by =  $userId;
        $estadoObra->save();
        return $estadoObra;
    }

    static function eliminarEstadoObra($id, $userId)
    {
        $estadoObra = EstadoObra::findOrfail($id);
        $estadoObra->deleted_at = now();
        $estadoObra->deleted_by =  $userId;
        $estadoObra->save();
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

    // Este método define la relación con el modelo Obra
    public function obras()
    {
        return $this->hasMany(Obra::class);
    }
}
