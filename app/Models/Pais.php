<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'paises';
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

    static function crearPais($nombre, $userId)
    {
        $pais = new Pais();
        $pais->nombre = $nombre;
        $pais->created_at = now();
        $pais->created_by =  $userId;
        $pais->save();
        return $pais;
    }


    static function editarPais($id, $nombre, $userId)
    {
        $pais = Pais::findOrfail($id);
        $pais->nombre = $nombre;
        $pais->updated_at = now();
        $pais->updated_by =  $userId;
        $pais->save();
        return $pais;
    }

    static function eliminarPais($id, $userId)
    {
        $pais = Pais::findOrfail($id);
        $pais->deleted_at = now();
        $pais->deleted_by =  $userId;
        $pais->save();
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
    // Relaciones

    public function estados()
    {
        return $this->hasMany(Estado::class, 'idPais');
    }
}
