<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insumo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'insumos';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'costo',
        'cantidad',
        'idObra',
        'fecha',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearInsumo($costo, $cantidad, $fecha, $idObra, $materiales = [], $userId )
    {

        $insumo = new Insumo();
        $insumo->costo = $costo;
        $insumo->cantidad =$cantidad;
        $insumo->fecha =$fecha;
        $insumo->idObra = $idObra;
        $insumo->created_at = now();
        $insumo->created_by =  $userId;
        $insumo->save();
        if (!empty($materiales)) {
            $materialesCollection = collect($materiales);
            // Usamos sync para asociar los materiales al insumo
            $insumo->materiales()->sync($materialesCollection->all());
        }else{
            $insumo->materiales()->sync([]);
        }
        return $insumo;
    }

    static function editarInsumo($id, $costo, $cantidad, $fecha, $idObra, $materiales = [], $userId)
    {
        $insumo =  Insumo::findOrfail($id);
        $insumo->costo = $costo;
        $insumo->cantidad =$cantidad;
        $insumo->fecha =$fecha;
        $insumo->idObra = $idObra;
        $insumo->updated_at = now();
        $insumo->updated_by = $userId;
        $insumo->save();
        if (!empty($materiales)) {
            $materialesCollection = collect($materiales);
            // Usamos sync para asociar los materiales al insumo
            $insumo->materiales()->sync($materialesCollection->all());
        }else{
            $insumo->materiales()->sync([]);
        }
        return $insumo;
    }

    static function eliminarInsumo($id, $userId)
    {
        $insumo = Insumo::findOrfail($id);
        $insumo->deleted_at = now();
        $insumo->deleted_by =  $userId;
        $insumo->save();
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
    //relacion con materiales
    public function materiales()
    {
        return $this->belongsToMany(Material::class, 'insumo_material', 'idInsumo', 'idMaterial');
    }
    // relación con el modelo Obra
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'idObra');
    }
}
