<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Genre', properties: [
    new OA\Property(property: 'id', description: 'Identifiant unique du genre', type: 'integer', format: 'int64'),
    new OA\Property(property: 'nom', description: 'Nom du genre', type: 'string'),
])]
class Genre extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['nom'];

    const POP = "Pop";
    const ROCK = "Rock";
    const CLASSIQUE = "Classique";
    const RAP = "Rap";
    const FOLK = "Folk";
    const SPORTIF = "Sportif";
    const COMEDIEN = "Comédien";
    const VARIETE = "Variété";

    const GENRES = [
        self::POP,
        self::ROCK,
        self::CLASSIQUE,
        self::RAP,
        self::FOLK,
        self::SPORTIF,
        self::COMEDIEN,
        self::VARIETE
    ];
}
