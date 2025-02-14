<?php
// app/Models/Charge.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_equipement',
        'type_equipement',
        'type_source',
        'puissance_equipement',
        'tension_equipement',
        'courant_equipement',
        'parc_id',
    ];

    protected $casts = [
        'puissance_equipement' => 'float',
        'tension_equipement' => 'float',
        'courant_equipement' => 'float',
    ];

    public function parc()
    {
        return $this->belongsTo(Parc::class);
    }
}
