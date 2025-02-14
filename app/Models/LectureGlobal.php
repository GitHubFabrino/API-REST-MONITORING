<?php

// app/Models/LectureGlobal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureGlobal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tension_total',
        'courant_total',
        'temperature_moyenne',
        'soc_global',
        'dod_global',
        'horodatage',
        'parc_id',
    ];

    protected $casts = [
        'tension_total' => 'decimal:2',
        'courant_total' => 'decimal:2',
        'temperature_moyenne' => 'decimal:2',
        'soc_global' => 'integer',
        'dod_global' => 'integer',
        'horodatage' => 'datetime',
    ];

    public function parc()
    {
        return $this->belongsTo(Parc::class);
    }
}
