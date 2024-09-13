<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Egreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'egresos';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cantidad',
        'idObra',
        'idProveedor',
        'idFormaPago',
        'idBanco',
        'concepto',
        'fecha',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Método para crear un egreso
    static function crearEgreso($cantidad, $idObra, $idProveedor, $idFormaPago, $idBanco, $servicios = [], $concepto, $fecha, $userId)
    {
        $egreso = new Egreso();
        $egreso->cantidad = $cantidad;
        $egreso->idObra = $idObra;
        $egreso->idProveedor = $idProveedor;
        $egreso->idFormaPago = $idFormaPago;
        $egreso->idBanco = $idBanco;
        $egreso->concepto = $concepto;
        $egreso->fecha = $fecha;
        $egreso->created_by = $userId;
        $egreso->created_at = now();
        $egreso->save();

        // Aquí simplemente sincronizas los IDs de servicios seleccionados
        if (!empty($servicios)) {
            $egreso->servicios()->sync($servicios);
        } else {
            $egreso->servicios()->sync([]); // Si no hay servicios seleccionados
        }

        return $egreso;
    }

    // Método para editar un egreso
    static function editarEgreso($id, $cantidad, $idObra, $idProveedor, $idFormaPago, $idBanco, $servicios = [], $concepto, $fecha, $userId)
    {
        try {
            $egreso = Egreso::findOrFail($id);
            $egreso->cantidad = $cantidad;
            $egreso->idObra = $idObra;
            $egreso->idProveedor = $idProveedor;
            $egreso->idFormaPago = $idFormaPago;
            $egreso->idBanco = $idBanco;
            $egreso->concepto = $concepto;
            $egreso->fecha = $fecha;
            if (!empty($servicios)) {
                $serviciosCollection = collect($servicios);
                $servicioIds = $serviciosCollection->pluck('id')->toArray();
                $egreso->servicios()->sync($servicioIds);

            }else{
                $egreso->servicios()->sync([]);
            }
            $egreso->updated_by = $userId;
            $egreso->updated_at = now();
            $egreso->save();
            return $egreso;
        } catch (\Throwable $th) {
            Log::error('Error al actualizar Egreso: ' . $th->getMessage(), [
                'id' => $id,
                'userId' => $userId,
            ]);
            throw $th;
        }
    }

    // Método para eliminar un egreso (Soft delete)
    static function eliminarEgreso($id, $userId)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->deleted_by = $userId;
        $egreso->deleted_at = now();
        $egreso->save();
    }

    // Relación con el modelo Obra
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'idObra');
    }

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor');
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

    // Relación con el usuario que creó el egreso
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con el usuario que actualizó el egreso
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relación con el usuario que eliminó el egreso
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    //relacion con servicios
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'egreso_servicio', 'idEgreso', 'idServicio');
    }
}
