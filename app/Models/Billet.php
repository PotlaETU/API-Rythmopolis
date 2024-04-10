<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Billet'
    , properties: [
        new OA\Property(property: 'id', type: 'integer', format: 'int64', description: 'Identifiant unique du billet'),
        new OA\Property(property: 'quantite', type: 'integer', description: 'Quantité de billets'),
        new OA\Property(property: 'prix_id', type: 'integer', description: 'Identifiant du prix du billet'),
        new OA\Property(property: 'reservation_id', type: 'integer', description: 'Identifiant de la réservation du billet'),
    ])]
class Billet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['quantite', 'prix_id', 'reservation_id'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function prix()
    {
        return $this->belongsTo(Prix::class);
    }
}
