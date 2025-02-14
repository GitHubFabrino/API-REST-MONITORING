<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graviter extends Model
{
    use HasFactory;

    // Champs remplissables
    protected $fillable = ['niveau'];
}
