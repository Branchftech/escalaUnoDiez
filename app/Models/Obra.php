<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'obra';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'contrato',
        'idDetalleObra',
        'idProveedor',
        'idCliente',
        'idEstadoObra',
        'licenciaConstruccion',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearObra($contrato, $userId)
    {
        $obra = new Obra();
        $obra->contrato = $contrato;
        $obra->created_at = now();
        $obra->created_by =  $userId;
        $obra->save();
        return $obra;
    }


    static function editarObra($id, $contrato, $userId)
    {
        $obra = Obra::findOrfail($id);
        $obra->contrato = $contrato;
        $obra->updated_at = now();
        $obra->updated_by =  $userId;
        $obra->save();
        return $obra;
    }

    static function eliminarObra($id, $userId)
    {
        $obra = Obra::findOrfail($id);
        $obra->activo = 0;
        $obra->deleted_at = now();
        $obra->deleted_by =  $userId;
        $obra->save();
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

    // relación con el modelo detalle Obra
    public function detalle()
    {
        return $this->belongsTo(DetalleObra::class, 'idDetalleObra');
    }
    // relación con el modelo cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }
    // relación con el modelo proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor');
    }
    // relación con el modelo estado
    public function estado()
    {
        return $this->belongsTo(EstadoObra::class, 'idEstadoObra');
    }

      // Este método define la relación con el modelo bitacoraObra
      public function bitacoras()
      {
          return $this->hasMany(BitacoraObra::class);
      }
}
