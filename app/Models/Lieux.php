<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lieux extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lieux';
    protected $fillable = ['nom', 'adresse', 'code_postal', 'ville', 'lat', 'long'];
}
