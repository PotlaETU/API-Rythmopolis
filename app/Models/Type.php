<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['nom'];

    const THEATRE = "Théatre";
    const CINEMA = "Cinéma";
    const CONCERT = "Concert";
    const FESTIVAL = "Festival";
    const COMPETITION = "Compétition";

    const TYPES = [self::THEATRE, self::CINEMA, self::CONCERT, self::FESTIVAL, self::COMPETITION];
}
