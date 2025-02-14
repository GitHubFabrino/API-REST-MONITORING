<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Champs modifiables
    protected $fillable = [
        'type', 
        'choix', 
        'valeur', 
        'parc_id'
    ];

    // Relation avec Parc
    public function parc()
    {
        return $this->belongsTo(Parc::class);
    }
}
