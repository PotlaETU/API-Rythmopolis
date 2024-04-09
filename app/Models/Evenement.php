<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Evenement', properties: [
    new OA\Property(property: 'id', description: 'Identifiant unique de l\'événement', type: 'integer', format: 'int64'),
    new OA\Property(property: 'titre', description: 'Titre de l\'événement', type: 'string'),
    new OA\Property(property: 'description', description: 'Description de l\'événement', type: 'string'),
    new OA\Property(property: 'date_event', description: 'Date de l\'événement', type: 'string', format: 'date'),
    new OA\Property(property: 'lieu_id', description: 'Identifiant du lieu de l\'événement', type: 'integer', format: 'int64'),
])]
class Evenement extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['titre', 'description', 'date_event', 'lieu_id'];

    public function types(){
        return $this->belongsToMany(Type::class);
    }

    public function artistes(){
        return $this->belongsToMany(Artiste::class, 'participants');
    }

    public function lieu(){
        return $this->belongsTo(Lieux::class);
    }

    public function prix(){
        return $this->hasMany(Prix::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}
