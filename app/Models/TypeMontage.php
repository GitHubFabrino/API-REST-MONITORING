<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMontage extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_type',
    ];
}
