<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Permisos extends Model
{
    use HasFactory;



    protected $connection = 'mysql';
    public $table = 'permissions';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];



    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_has_permissions', 'permission_id', 'role_id')->orderBy('name', 'asc');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id', 'model_id')->orderBy('name', 'asc');
    }


    static function crearPermiso($name)
    {
        $permiso = new Permisos();
        $permiso->name = $name;
        $permiso->guard_name = 'web';
        $permiso->save();
        return $permiso;
    }


    static function editarPermiso($id, $name)
    {
        $permiso = Permisos::findOrfail($id);
        $permiso->name = $name;
        $permiso->save();
        return $permiso;
    }

    static function eliminarPermiso($id)
    {
        $permiso = Permisos::findOrfail($id);
        $permiso->delete();
    }

    public function getCreatedAtCustomAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
