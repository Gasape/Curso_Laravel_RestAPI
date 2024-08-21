<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const Usuario_Verificado = '1';
    const Usuario_No_Verificado = '0';

    const Usuario_Administrador = 'true';
    const Usuario_Regular = 'false';

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    public function setNameAttribute($valor){
        $this->attributes['name'] = strtolower($valor);
    }
    public function getNameAttribute($valor){
        return ucwords($valor);
    }
    public function setEmailAttribute($valor){
        $this->attributes['email'] = strtolower($valor);
    }

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function esVerificado(){
        return $this->verified == User::Usuario_Verificado;
    }

    public function esAdministrador (){
        return $this->admin == User::Usuario_Administrador;
    }

    public static function generarVerificationToken(){
        return Str::random(40);
    }
}
