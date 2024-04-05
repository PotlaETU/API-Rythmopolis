<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
