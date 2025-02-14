<?php

// app/Models/Maintenance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'details',
        'batterie_id',
        'marque'
    ];

    public function batterie()
    {
        return $this->belongsTo(Batterie::class, 'batterie_id');
    }
}
