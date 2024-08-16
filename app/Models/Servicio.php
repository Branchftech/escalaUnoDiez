<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'servicio';
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

    static function crearServicio($nombre, $userId)
    {
        $Servicio = new Servicio();
        $Servicio->nombre = $nombre;
        $Servicio->created_at = now();
        $Servicio->created_by =  $userId;
        $Servicio->save();
        return $Servicio;
    }


    static function editarServicio($id, $nombre, $userId)
    {
        $Servicio = Servicio::findOrfail($id);
        $Servicio->nombre = $nombre;
        $Servicio->updated_at = now();
        $Servicio->updated_by = $userId;
        $Servicio->save();
        return $Servicio;
    }

    static function eliminarServicio($id, $userId)
    {
        $Servicio = Servicio::findOrfail($id);
        $Servicio->deleted_at = now();
        $Servicio->deleted_by =  $userId;
        $Servicio->save();
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

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'proveedor_servicio', 'servicio_id', 'proveedor_id');
    }

}
