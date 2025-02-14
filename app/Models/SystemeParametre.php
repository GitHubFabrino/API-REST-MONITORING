<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SystemeParametre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_batterie_serie',
        'nombre_batterie_parallele',
        'type_montage_id',
    ];

    // Relation avec TypeMontage
    public function typeMontage()
    {
        return $this->belongsTo(TypeMontage::class, 'type_montage_id');
    }
}
