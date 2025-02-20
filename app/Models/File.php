<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'file_name'
    ];
    public function batteries()
    {
        return $this->hasMany(Batterie::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
