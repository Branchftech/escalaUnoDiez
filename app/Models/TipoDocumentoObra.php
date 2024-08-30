<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDocumentoObra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'tipodocumentoobra';
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

    static function crearTipoDocumentoObra($nombre, $userId)
    {
        $tipoDocumentoObra = new TipoDocumentoObra();
        $tipoDocumentoObra->nombre = $nombre;
        $tipoDocumentoObra->created_at = now();
        $tipoDocumentoObra->created_by =  $userId;
        $tipoDocumentoObra->save();
        return $tipoDocumentoObra;
    }


    static function editarTipoDocumentoObra($id, $nombre, $userId)
    {
        $tipoDocumentoObra = TipoDocumentoObra::findOrfail($id);
        $tipoDocumentoObra->nombre = $nombre;
        $tipoDocumentoObra->updated_at = now();
        $tipoDocumentoObra->updated_by =  $userId;
        $tipoDocumentoObra->save();
        return $tipoDocumentoObra;
    }

    static function eliminarTipoDocumentoObra($id, $userId)
    {
        $tipoDocumentoObra = TipoDocumentoObra::findOrfail($id);
        $tipoDocumentoObra->deleted_at = now();
        $tipoDocumentoObra->deleted_by =  $userId;
        $tipoDocumentoObra->save();
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

    // Este método define la relación con el modelo Obra
    public function documentosObras()
    {
        return $this->hasMany(DocumentoObra::class);
    }
}
