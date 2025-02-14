<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametreBatterie extends Model
{
    use HasFactory;
    /**
     * Les attributs qui sont assignables.
     */
    protected $fillable = [
        'plage_temperature_min',
        'plage_temperature_max',
        'plage_tension_min',
        'plage_tension_max',
        'plage_courant_min',
        'plage_courant_max',
        'plage_puissance_min',
        'plage_puissance_max',
        'seuil_alerte_soc',
        'seuil_alerte_dod',
        'profondeur_charge_max',
    ];
}
