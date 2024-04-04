<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['titre', 'description', 'date_event', 'lieu_id'];

    public function types(){
        return $this->belongsToMany(Type::class);
    }
}
