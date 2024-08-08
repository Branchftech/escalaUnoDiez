<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Banco extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    public $table = 'banco';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'activo',
        'created_at',
        'updated_at',
    ];

    static function crearBanco($nombre)
    {
        $banco = new Banco();
        $banco->nombre = $nombre;
        $banco->activo =1;
        $banco->save();
        return $banco;
    }


    static function editarBanco($id, $nombre)
    {
        $banco = Banco::findOrfail($id);
        $banco->nombre = $nombre;
        $banco->save();
        return $banco;
    }

    static function eliminarbanco($id)
    {
        $banco = Banco::findOrfail($id);
        $banco->delete();
    }

    public function getCreatedAtCustomAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
