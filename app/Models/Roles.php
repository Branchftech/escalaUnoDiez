<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    public $table = 'roles';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];

    public function permissions()
    {

        return $this->belongsToMany(Permisos::class, 'role_has_permissions', 'role_id', 'permission_id')->orderBy('name', 'asc');
    }

    public function permisos()
    {

        return $this->belongsToMany(Permisos::class, 'role_has_permissions', 'role_id', 'permission_id')->orderBy('name', 'asc');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id')->orderBy('name', 'asc');
    }

    static function crearRol($name, $permisos = [])
    {
        $rol = new Roles();
        $rol->name = $name;
        $rol->guard_name = 'web';
        $rol->save();
        // Asignar permisos al rol

        if (!empty($permisos)) {
            $permisosCollection = collect($permisos);
            $permisoIds = $permisosCollection->pluck('id')->toArray();
            // Sincronizar los permisos
            $rol->permissions()->sync($permisoIds);
        }
        return $rol;
    }


    static function editarRol($id, $name, $permisos = [])
    {
        $rol = Roles::findOrfail($id);
        $rol->name = $name;
        $rol->save();
        if (!empty($permisos)) {
            $permisosCollection = collect($permisos);
            $permisoIds = $permisosCollection->pluck('id')->toArray();
            $rol->permissions()->sync($permisoIds);
        }else{
            $rol->permissions()->sync([]);
        }
        return $rol;
    }

    static function eliminarRol($id)
    {
        $rol = Roles::findOrfail($id);
        $rol->permissions()->sync([]);
        $rol->delete();
    }

    public function getCreatedAtCustomAttribute()
    {
        return $this->created_at->format('d M Y');
    }
}
