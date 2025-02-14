<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueMesure extends Model
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
        'batterie_id',
    ];

    protected $casts = [
        'avg_tension' => 'float',
        'avg_courant' => 'float',
        'avg_temperature' => 'float',
        'avg_soc' => 'float',
        'avg_dod' => 'float',
        'avg_soh' => 'float',
        'min_tension' => 'float',
        'max_tension' => 'float',
        'min_courant' => 'float',
        'max_courant' => 'float',
        'min_temperature' => 'float',
        'max_temperature' => 'float',
        'total_consommation' => 'float',
    ];

    // Relation avec NiveauAnteriorite
    public function niveauAnteriorite()
    {
        return $this->belongsTo(NiveauAnteriorite::class, 'niveau_anteriorite_id');
    }

    // Relation avec Batterie
    public function batterie()
    {
        return $this->belongsTo(Batterie::class, 'batterie_id');
    }
}
