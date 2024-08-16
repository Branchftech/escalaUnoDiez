<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'cliente';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'cedula',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearCliente($nombre, $apellido, $telefono, $cedula, $email, $userId)
    {
        $cliente = new Cliente();
        $cliente->nombre = $nombre;
        $cliente->apellido =$apellido;
        $cliente->telefono = $telefono;
        $cliente->cedula = $cedula;
        $cliente->email = $email;
        $cliente->created_at = now();
        $cliente->created_by =  $userId;
        $cliente->save();
        return $cliente;
    }


    static function editarCliente($id, $nombre, $apellido, $telefono, $cedula, $email, $userId)
    {
        $cliente = Cliente::findOrfail($id);
        $cliente->nombre = $nombre;
        $cliente->apellido =$apellido;
        $cliente->telefono = $telefono;
        $cliente->cedula = $cedula;
        $cliente->email = $email;
        $cliente->updated_at = now();
        $cliente->updated_by = $userId;
        $cliente->save();
        return $cliente;
    }

    static function eliminarCliente($id, $userId)
    {
        $cliente = Cliente::findOrfail($id);
        $cliente->deleted_at = now();
        $cliente->deleted_by =  $userId;
        $cliente->save();
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
