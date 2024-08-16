<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'banco';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'activo',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearBanco($nombre, $activo, $userId)
    {
        $banco = new Banco();
        $banco->nombre = $nombre;
        $banco->activo =$activo;
        $banco->created_at = now();
        $banco->created_by =  $userId;
        $banco->save();
        return $banco;
    }


    static function editarBanco($id, $nombre, $activo, $userId)
    {
        $banco = Banco::findOrfail($id);
        $banco->nombre = $nombre;
        $banco->activo =$activo;
        $banco->updated_at = now();
        $banco->updated_by =  $userId;
        $banco->save();
        return $banco;
    }

    static function eliminarbanco($id, $userId)
    {
        $banco = Banco::findOrfail($id);
        $banco->activo = 0;
        $banco->deleted_at = now();
        $banco->deleted_by =  $userId;
        $banco->save();
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
