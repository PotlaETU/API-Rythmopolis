<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['date_res', 'nb_billets', 'montant', 'statut', 'evenement_id', 'client_id'];

    public function status()
    {
        return $this->belongsTo(Statut::class);
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function billets()
    {
        return $this->hasMany(Billet::class);
    }
}
