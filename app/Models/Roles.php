<?php
// app/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // app/Models/User.php
    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }

    public function hasRole($roleName)
    {
        return $this->roles->contains('name', $roleName);
    }
    public function accesos()
    {
        return $this->belongsToMany(Acceso::class, 'acceso_role', 'role_id', 'acceso_id');
    }
}
