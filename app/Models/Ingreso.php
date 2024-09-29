<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Ingreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'ingresos';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'factura',
        'cantidad',
        'idCliente',
        'idFormaPago',
        'idBanco',
        'concepto',
        'fecha',
        'idObra',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Método para crear un ingreso
    static function crearIngreso($factura, $cantidad, $idCliente, $idFormaPago, $idBanco, $concepto, $fecha, $idObra, $userId)
    {
        $ingreso = new Ingreso();
        $ingreso->factura = $factura;
        $ingreso->cantidad = $cantidad;
        $ingreso->idCliente = $idCliente;
        $ingreso->idFormaPago = $idFormaPago;
        $ingreso->idBanco = $idBanco;
        $ingreso->concepto = $concepto;
        $ingreso->fecha = $fecha;
        $ingreso->idObra = $idObra;
        $ingreso->created_by = $userId;
        $ingreso->created_at = now();
        $ingreso->save();

        return $ingreso;
    }

    // Método para editar un ingreso
    static function editarIngreso($id, $factura, $cantidad, $idObra, $idCliente, $idFormaPago, $idBanco, $concepto, $fecha, $userId)
    {
        try {
            $ingreso = Ingreso::findOrFail($id);
            $ingreso->factura = $factura;
            $ingreso->cantidad = $cantidad;
            $ingreso->idObra = $idObra;
            $ingreso->idCliente = $idCliente;
            $ingreso->idFormaPago = $idFormaPago;
            $ingreso->idBanco = $idBanco;
            $ingreso->concepto = $concepto;
            $ingreso->fecha = $fecha;
            $ingreso->updated_by = $userId;
            $ingreso->updated_at = now();
            $ingreso->save();

            return $ingreso;
        } catch (\Throwable $th) {
            Log::error('Error al actualizar Ingreso: ' . $th->getMessage(), [
                'id' => $id,
                'userId' => $userId,
            ]);
            throw $th;
        }
    }

    // Método para eliminar un ingreso (Soft delete)
    static function eliminarIngreso($id, $userId)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->deleted_by = $userId;
        $ingreso->deleted_at = now();
        $ingreso->save();
    }

    // Relación con el modelo Obra
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'idObra');
    }

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    // Relación con el modelo FormaPago
    public function formaPago()
    {
        return $this->belongsTo(FormaPago::class, 'idFormaPago');
    }

    // Relación con el modelo Banco
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'idBanco');
    }

    // Relación con el usuario que creó el ingreso
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con el usuario que actualizó el ingreso
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relación con el usuario que eliminó el ingreso
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
