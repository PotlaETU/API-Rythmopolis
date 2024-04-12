<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Artiste'
, properties: [
    new OA\Property(property: 'id', type: 'integer', format: 'int64', description: 'Identifiant unique de l\'artiste'),
    new OA\Property(property: 'nom', type: 'string', description: 'Nom de l\'artiste'),
    new OA\Property(property: 'genre', type: 'string', description: 'Genre musical de l\'artiste'),
])]
class Artiste extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['nom', 'genre'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
