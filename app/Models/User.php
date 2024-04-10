<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'User'
    , properties: [
        new OA\Property(property: 'id', description: 'Identifiant unique de l\'utilisateur', type: 'integer', format: 'int64'),
        new OA\Property(property: 'name', description: 'Nom de l\'utilisateur', type: 'string'),
        new OA\Property(property: 'email', description: 'Adresse email de l\'utilisateur', type: 'string'),
        new OA\Property(property: 'email_verified_at', description: 'Date de vérification de l\'adresse email', type: 'string', format: 'date-time'),
        new OA\Property(property: 'password', description: 'Mot de passe de l\'utilisateur', type: 'string'),
        new OA\Property(property: 'remember_token', description: 'Jeton de connexion', type: 'string'),
    ])]

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

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

    public $timestamps = false;



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
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [

        ];
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }
}
