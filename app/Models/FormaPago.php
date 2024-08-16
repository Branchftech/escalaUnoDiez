<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormaPago extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'formapago';
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

    static function crearFormaPago($nombre, $userId)
    {
        $FormaPago = new FormaPago();
        $FormaPago->nombre = $nombre;
        $FormaPago->created_at = now();
        $FormaPago->created_by =  $userId;
        $FormaPago->save();
        return $FormaPago;
    }


    static function editarFormaPago($id, $nombre, $userId)
    {
        $FormaPago = FormaPago::findOrfail($id);
        $FormaPago->nombre = $nombre;
        $FormaPago->updated_at = now();
        $FormaPago->updated_by =  $userId;
        $FormaPago->save();
        return $FormaPago;
    }

    static function eliminarFormaPago($id, $userId)
    {
        $FormaPago = FormaPago::findOrfail($id);
        $FormaPago->deleted_at = now();
        $FormaPago->deleted_by =  $userId;
        $FormaPago->save();
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
