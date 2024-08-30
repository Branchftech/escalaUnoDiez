<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class DocumentoObra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'documentoobra';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'path',
        'idTipoDocumento',
        'idObra',
        'updated_at',
        'deleted_at',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    static function crearDocumentoObra($nombre, $path,$idTipoDocumento, $idObra, $userId)
    {
        $documentoObra = new DocumentoObra();
        $documentoObra->nombre = $nombre;
        $documentoObra->path = $path;
        $documentoObra->idTipoDocumento = $idTipoDocumento;
        $documentoObra->idObra = $idObra;
        $documentoObra->created_at = now();
        $documentoObra->created_by =  $userId;
        $documentoObra->save();
        return $documentoObra;
    }


    static function editarDocumentoObra($id,$nombre, $path,$idTipoDocumento, $idObra, $userId)
    {
        $documentoObra = DocumentoObra::findOrfail($id);
        $documentoObra->nombre = $nombre;
        $documentoObra->path = $path;
        $documentoObra->idTipoDocumento = $idTipoDocumento;
        $documentoObra->idObra = $idObra;
        $documentoObra->updated_at = now();
        $documentoObra->updated_by =  $userId;
        $documentoObra->save();
        return $documentoObra;
    }

    static function eliminarDocumentoObra($id, $userId)
    {
        $documentoObra = DocumentoObra::findOrfail($id);

        // Eliminar el archivo del sistema de archivos
        if (Storage::exists($documentoObra->path)) {
            Storage::delete($documentoObra->path);
        }

        $documentoObra->deleted_at = now();
        $documentoObra->deleted_by =  $userId;
        $documentoObra->save();
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

    // Este método define la relación con el modelo tipodocumento
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumentoObra::class, 'idTipoDocumento');
    }

     // Este método define la relación con el modelo Obra
     public function obra()
     {
         return $this->belongsTo(Obra::class, 'idObra');
     }
}
