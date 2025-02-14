<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlerteGlobal extends Model
{
    use HasFactory;

    protected $fillable = [
        'valeur_alerte',
        'valeur_seuil',
        'horodatage',
        'type_alerte_id',
        'graviter_id',
        'contact_id'
    ];

    // Relation avec TypeAlerte
    public function typeAlerte()
    {
        return $this->belongsTo(TypeAlerte::class);
    }

    // Relation avec Graviter
    public function graviter()
    {
        return $this->belongsTo(Graviter::class);
    }

    // Relation avec Contact
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
