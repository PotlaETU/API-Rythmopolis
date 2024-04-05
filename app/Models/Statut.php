<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['nom'];

    const EN_ATTENTE = "en attente";
    const PAYE = "payé";
    const ANNULE = "annulé";
    const BILLET_EDITE = "billet édité";

    const STATUTS = [
        self::EN_ATTENTE,
        self::PAYE,
        self::ANNULE,
        self::BILLET_EDITE
    ];
}
