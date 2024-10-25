<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'menu';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'url',
        'icono',
        'idRol',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Método para crear un Menu
    static function crearMenu($nombre, $url, $icono, $idRol,$userId)
    {
        $menu = new Menu();
        $menu->nombre = $nombre;
        $menu->url = $url;
        $menu->icono = $icono;
        $menu->idRol = $idRol;
        $menu->created_by = $userId;
        $menu->created_at = now();
        $menu->save();

        return $menu;
    }

    // Método para editar un Menu
    static function editarMenu($id, $nombre, $url, $icono, $idRol,$userId)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->nombre = $nombre;
            $menu->url = $url;
            $menu->icono = $icono;
            $menu->idRol = $idRol;
            $menu->updated_by = $userId;
            $menu->updated_at = now();
            $menu->save();

            return $menu;
        } catch (\Throwable $th) {
            Log::error('Error al actualizar Menu: ' . $th->getMessage(), [
                'id' => $id,
                'userId' => $userId,
            ]);
            throw $th;
        }
    }

    // Método para eliminar un Menu (Soft delete)
    static function eliminarMenu($id, $userId)
    {
        $menu = Menu::findOrFail($id);
        $menu->deleted_by = $userId;
        $menu->deleted_at = now();
        $menu->save();
    }

    // Relación con el modelo rol
    public function rol()
    {
        return $this->belongsTo(Roles::class, 'idRol');
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
