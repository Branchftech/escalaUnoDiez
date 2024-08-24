<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BitacoraObra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'bitacoraobra';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'descripcion',
        'idObra',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearBitacoraObra($descripcion,$idObra, $userId)
    {
        $bitacoraObra = new BitacoraObra();
        $bitacoraObra->descripcion = $descripcion;
        $bitacoraObra->idObra = $idObra;
        $bitacoraObra->created_at = now();
        $bitacoraObra->created_by =  $userId;
        $bitacoraObra->save();
        return $bitacoraObra;
    }

    static function editarBitacoraObra($id, $descripcion,$idObra, $userId)
    {
        $bitacoraObra = BitacoraObra::findOrfail($id);
        $bitacoraObra->descripcion = $descripcion;
        $bitacoraObra->idObra = $idObra;
        $bitacoraObra->updated_at = now();
        $bitacoraObra->updated_by =  $userId;
        $bitacoraObra->save();
        return $bitacoraObra;
    }

    static function eliminarBitacoraObra($id, $userId)
    {
        $bitacoraObra = BitacoraObra::findOrfail($id);
        $bitacoraObra->deleted_at = now();
        $bitacoraObra->deleted_by =  $userId;
        $bitacoraObra->save();
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

    // Este método define la relación con el modelo EstadoObra
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'idObra');
    }

}
