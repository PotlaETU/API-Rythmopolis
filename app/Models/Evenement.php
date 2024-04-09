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

    public function artistes(){
        return $this->belongsToMany(Artiste::class, 'participants');
    }

    public function lieu(){
        return $this->belongsTo(Lieux::class);
    }

    public function prix(){
        return $this->hasMany(Prix::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function getTotalPlacesByCategory($categorie){
        $total = 0;
        foreach ($this->prix as $prix) {
            if($prix->categorie == $categorie){
                $total += $prix->quantite;
            }
        }
        return $total;
    }
}
