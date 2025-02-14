<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $fillable = ['tension', 'courant', 'temperature', 'soc', 'dod', 'batterie_id'];


    public function batterie()
    {
        return $this->belongsTo(Batterie::class);
    }
}
