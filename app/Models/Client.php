<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Client'
    , properties: [
        new OA\Property(property: 'id', description: 'Identifiant unique du client', type: 'integer', format: 'int64'),
        new OA\Property(property: 'user_id', description: 'Identifiant de l\'utilisateur du client', type: 'integer'),
        new OA\Property(property: 'nom', description: 'Nom du client', type: 'string'),
        new OA\Property(property: 'prenom', description: 'Prénom du client', type: 'string'),
        new OA\Property(property: 'telephone', description: 'Numéro de téléphone du client', type: 'string'),
        new OA\Property(property: 'adresse', description: 'Adresse du client', type: 'string'),
        new OA\Property(property: 'code_postal', description: 'Code postal du client', type: 'string'),
        new OA\Property(property: 'ville', description: 'Ville du client', type: 'string'),
        new OA\Property(property: 'pays', description: 'Pays du client', type: 'string'),
    ])]
class Client extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
