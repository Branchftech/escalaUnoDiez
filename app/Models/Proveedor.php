<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'proveedores';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'direccion',
        'email',
        'telefono',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearProveedor($nombre, $direccion,$email, $telefono, $userId)
    {
        $proveedor = new Proveedor();
        $proveedor->nombre = $nombre;
        $proveedor->direccion = $direccion;
        $proveedor->email = $email;
        $proveedor->telefono = $telefono;
        $proveedor->created_at = now();
        $proveedor->created_by =  $userId;
        $proveedor->save();
        return $proveedor;
    }


    static function editarProveedor($id, $nombre,$direccion,$email, $telefono, $userId, $servicios = [])
    {
        $proveedor = Proveedor::findOrfail($id);
        $proveedor->nombre = $nombre;

        $proveedor->direccion = $direccion;
        $proveedor->email = $email;
        $proveedor->telefono = $telefono;
        $proveedor->updated_at = now();
        $proveedor->updated_by = $userId;
        $proveedor->save();

        if (!empty($servicios)) {
            $serviciosCollection = collect($servicios);
            $servicioIds = $serviciosCollection->pluck('id')->toArray();
            $proveedor->servicios()->sync($servicioIds);

        }else{
            $proveedor->servicios()->sync([]);
        }
        return $proveedor;
    }

    static function eliminarProveedor($id, $userId)
    {
        $proveedor = Proveedor::findOrfail($id);
        $proveedor->deleted_at = now();
        $proveedor->deleted_by =  $userId;
        $proveedor->save();
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

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'proveedor_servicio', 'idProveedor', 'idServicio');
    }
}
