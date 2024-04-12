<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prix extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['categorie', 'nombre', 'valeur', 'evenement_id'];
    public $table = 'prix';
}
