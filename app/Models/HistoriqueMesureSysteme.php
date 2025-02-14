<?php
// app/Models/HistoriqueMesureSysteme.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueMesureSysteme extends Model
{
    use HasFactory;

    protected $fillable = [
        'avg_tension',
        'avg_courant',
        'avg_temperature',
        'avg_soc',
        'avg_dod',
        'avg_soh',
        'min_tension',
        'max_tension',
        'min_courant',
        'max_courant',
        'min_temperature',
        'max_temperature',
        'total_consommation',
        'niveau_anteriorite_id',
        'parc_id'
    ];

    public function niveauAnteriorite()
    {
        return $this->belongsTo(NiveauAnteriorite::class, 'niveau_anteriorite_id');
    }

    public function parc()
    {
        return $this->belongsTo(Parc::class, 'parc_id');
    }
}
