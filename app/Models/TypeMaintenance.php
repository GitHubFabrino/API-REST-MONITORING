<?php

// app/Models/TypeMaintenance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    protected $table = 'type_maintenances';
}
