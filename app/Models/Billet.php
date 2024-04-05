<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['quantite', 'prix_id', 'reservation_id'];
}
