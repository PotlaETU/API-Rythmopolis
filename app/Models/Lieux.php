<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Lieux', properties: [
    new OA\Property(property: 'id', description: 'Identifiant unique du lieu', type: 'integer', format: 'int64'),
    new OA\Property(property: 'nom', description: 'Nom du lieu', type: 'string'),
    new OA\Property(property: 'adresse', description: 'Adresse du lieu', type: 'string'),
    new OA\Property(property: 'code_postal', description: 'Code postal du lieu', type: 'string'),
    new OA\Property(property: 'ville', description: 'Ville du lieu', type: 'string'),
    new OA\Property(property: 'lat', description: 'Latitude du lieu', type: 'number', format: 'float'),
    new OA\Property(property: 'long', description: 'Longitude du lieu', type: 'number', format: 'float'),
])]
class Lieux extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lieux';
    protected $fillable = ['nom', 'adresse', 'code_postal', 'ville', 'lat', 'long'];
}
