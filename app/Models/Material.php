<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'material';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'precioNormal',
        'idUnidad',
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearEditarMaterial($id, $nombre, $precioNormal, $idUnidad, $userId)
    {
        if($id){
            $material = Material::findOrfail($id);
            $material->updated_at = now();
            $material->updated_by =  $userId;
        }else{
            $material = new Material();
            $material->created_at = now();
            $material->created_by =  $userId;

        }
        $material->nombre = $nombre;
        $material->precioNormal =$precioNormal;
        $material->idUnidad = $idUnidad;
        $material->save();
        return $material;
    }


    // static function editarMaterial($id, $nombre, $precioNormal, $idUnidad, $userId)
    // {
    //     $Material = Material::findOrfail($id);
    //     $Material->nombre = $nombre;
    //     $Material->precioNormal =$precioNormal;
    //     $Material->idUnidad = $idUnidad;
    //     $Material->updated_at = now();
    //     $Material->updated_by =  $userId;
    //     $Material->save();
    //     return $Material;
    // }

    static function eliminarMaterial($id, $userId)
    {
        $Material = Material::findOrfail($id);
        $Material->precioNormal = 0;
        $Material->deleted_at = now();
        $Material->deleted_by =  $userId;
        $Material->save();
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

     // relación con el modelo unidad
     public function unidad()
     {
         return $this->belongsTo(Unidad::class, 'idUnidad');
     }
}
