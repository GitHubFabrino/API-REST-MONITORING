<?php
// app/Models/AlerteBatterie.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlerteBatterie extends Model
{
    use HasFactory;

    protected $fillable = [
        'valeur_alerte',
        'valeur_seuil',
        'message',
        'read',
        'type',
        'graviter',
        'contact_id',
        'batterie_id'
    ];

    public function typeAlerte()
    {
        return $this->belongsTo(TypeAlerte::class);
    }

    public function graviter()
    {
        return $this->belongsTo(Graviter::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function batterie()
    {
        return $this->belongsTo(Batterie::class);
    }
}
