<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parc extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_parc',
        'description',
        'adresse',
        'email',
        'nombre_batteries',
        'user_id',
        'file_id' // Ajoutez cette ligne
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'parc_id');
    }

    public function batteries()
    {
        return $this->hasMany(Batterie::class);
    }


}
