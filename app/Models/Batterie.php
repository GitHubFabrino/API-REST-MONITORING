<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batterie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'capacite_nominal',
        'date_installation',
        'technologie',
        'marque',
        'parc_id',
        'parametre_batterie_id',
        'description',
        'tension_nominale',
        'capacite',
        'utilisation_veille',
        'utilisation_cyclique',
        'courant',
        'temperature',
        'dod_max',
        'file_id',
    ];

    // Relation avec la table parc
    public function parc()
    {
        return $this->belongsTo(Parc::class);
    }

    public function parametreBatteries()
    {
        return $this->belongsTo(ParametreBatterie::class, 'parametre_batterie_id');
    }

    public function file()
{
    return $this->belongsTo(File::class);
}


}
