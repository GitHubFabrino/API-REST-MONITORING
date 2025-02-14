<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAlerte extends Model
{
    use HasFactory;

    // Champs remplissables
    protected $fillable = ['type'];
}
