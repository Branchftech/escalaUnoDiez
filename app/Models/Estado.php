<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'estados';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'idPais',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearEstado($nombre, $idPais, $userId)
    {
        $estado = new Estado();
        $estado->nombre = $nombre;
        $estado->idPais =$idPais;
        $estado->created_at = now();
        $estado->created_by =  $userId;
        $estado->save();
        return $estado;
    }


    static function editarEstado($id, $nombre,  $userId, $idPais)
    {
        $estado = Estado::findOrfail($id);
        $estado->nombre = $nombre;
        $estado->idPais =$idPais;
        $estado->updated_at = now();
        $estado->updated_by =  $userId;
        $estado->save();
        return $estado;
    }

    static function eliminarEstado($id, $userId)
    {
        $estado = Estado::findOrFail($id);

        // Eliminar en cascada todas las ciudades relacionadas con este estado
        Ciudad::where('idEstado', $id)->update([
            'deleted_at' => now(),
            'deleted_by' => $userId
        ]);

        // Marcar el estado como eliminado
        $estado->deleted_at = now();
        $estado->deleted_by = $userId;
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
     // Relación que indica la relacion con su pais
     public function pais()
     {
         return $this->belongsTo(Pais::class, 'idPais');
     }

}
