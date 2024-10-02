<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Destajo extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'destajo';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'presupuesto',
        'idObra',
        'idProveedor',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Método para crear un destajo
    static function crearDestajo($presupuesto, $idObra, $idProveedor, $servicios = [],$userId)
    {
        $destajo = new Destajo();
        $destajo->presupuesto = $presupuesto;
        $destajo->idObra = $idObra;
        $destajo->idProveedor = $idProveedor;

        $destajo->created_by = $userId;

        $destajo->created_at = now();
        $destajo->save();
        if (!empty($servicios)) {
            $serviciosCollection = collect($servicios);
            $servicioIds = $serviciosCollection->pluck('id')->toArray();
            $destajo->servicios()->sync($servicioIds);

        }else{
            $destajo->servicios()->sync([]);
        }
        $destajo->save();
        return $destajo;
    }

    // Método para editar un destajo
    static function editarDestajo($id, $presupuesto, $idObra, $idProveedor, $servicios = [], $userId)
    {
        try {
            $destajo = Destajo::findOrFail($id);
            $destajo->presupuesto = $presupuesto;
            $destajo->idObra = $idObra;
            $destajo->idProveedor = $idProveedor;
            if (!empty($servicios)) {
                $serviciosCollection = collect($servicios);
                $servicioIds = $serviciosCollection->pluck('id')->toArray();
                $destajo->servicios()->sync($servicioIds);

            }else{
                $destajo->servicios()->sync([]);
            }
            $destajo->updated_by = $userId;
            $destajo->updated_at = now();
            $destajo->save();

            return $destajo;
        } catch (\Throwable $th) {
            Log::error('Error al actualizar Destajo: ' . $th->getMessage(), [
                'id' => $id,
                'userId' => $userId,
            ]);
            throw $th;
        }
    }

    // Método para eliminar un destajo (Soft delete)
    static function eliminarDestajo($id, $userId)
    {
        $destajo = Destajo::findOrFail($id);
        $destajo->deleted_by = $userId;
        $destajo->deleted_at = now();
        $destajo->save();
    }

    // Relación con el modelo Obra
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'idObra');
    }

    // Relación con el modelo proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor');
    }

    // Relación con el modelo servicios
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'destajo_servicio', 'idDestajo', 'idServicio');
    }

    // Relación con el usuario que creó el destajo
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con el usuario que actualizó el destajo
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relación con el usuario que eliminó el destajo
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
