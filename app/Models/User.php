<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $connection = 'mysql';
    public $table = 'users';
    public $incrementing = true;
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    static function editarUsuario($id, $name, $email, $roles= [], $userId)
    {
        $user = User::findOrfail($id);
        $user->name = $name;
        $user->email = $email;

        $user->updated_at = now();
        $user->updated_by = $userId;
        $user->save();

        if (!empty($roles)) {
            $rolesCollection = collect($roles);
            $rolIds = $rolesCollection->pluck('id')->toArray();
            $user->roles()->sync($rolIds);

        }else{
            $user->roles()->sync([]);
        }
        return $user;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     /**
     * Relación muchos a muchos con el modelo Role.
     */
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_user', 'user_id', 'role_id');
    }


    /**
     * Verifica si el usuario tiene un rol específico.
     */
    public function hasRole($roleName)
    {
        return $this->roles->contains('name', $roleName);
    }

    public function accesos()
    {
        return $this->roles->flatMap(function ($role) {
            return $role->accesos;
        })->unique('id');
    }
}
