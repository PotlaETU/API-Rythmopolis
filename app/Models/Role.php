<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['nom'];

    const ADMIN = 'admin';
    const GESTIONNAIRE = 'gestionnaire';
    const ACTIF = 'actif';
    const NON_ACTIF = 'non-actif';

    const ROLES = [
        self::ADMIN,
        self::GESTIONNAIRE,
        self::ACTIF,
        self::NON_ACTIF,
    ];
}
