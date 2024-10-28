<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acceso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'acceso';

    protected $fillable = [
        'nombre',
        'url',
        'icono',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * Relación con el modelo Role.
     * Un acceso pertenece a un rol.
     */
    public function roles()
{
    return $this->belongsToMany(Roles::class, 'acceso_role', 'acceso_id', 'role_id');
}

    /**
     * Relación con el modelo User para saber quién creó el acceso.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con el modelo User para saber quién actualizó el acceso.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relación con el modelo User para saber quién eliminó el acceso.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
