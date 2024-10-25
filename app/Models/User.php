<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable
{

    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;


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



    static public function crearUsuario($name, $email, $password)
    {

        $usuario = new User();
        $usuario->name = $name;
        $usuario->email = $email;
        $usuario->password = Hash::make($password);
        $usuario->save();


        return $usuario;
    }

    static public function editarUsuario($id, $name, $email, $password, $roles = [], $permisos = [])
    {

        $usuario = User::findOrfail($id);
        $usuario->name = $name;
        $usuario->email = $email;
        if(!empty($password))
        {
            $usuario->password = Hash::make($password);
        }


        if(!empty($roles)){

            $rolesCollection = collect($roles);
            $rolesIds = $rolesCollection->pluck('id')->toArray();
            $usuario->roles()->sync($rolesIds);
        }else{
            $usuario->roles()->sync([]);
        }

        if(!empty($permisos)){
            $permisosCollection = collect($permisos);
            $permisosIds = $permisosCollection->pluck('id')->toArray();
            $usuario->permissions()->sync($permisosIds);
        }else{
            $usuario->permissions()->sync([]);
        }


        $usuario->save();
        return $usuario;
    }

    static public function eliminarUsuario($id)
    {
        $usuario = User::findOrfail($id);
        $usuario->roles()->sync([]);
        $usuario->permissions()->sync([]);
        $usuario->delete();
    }


    public function getCreatedAtCustomAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('d M Y');
    }
}
