<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $table = 'personnel';

    // Si vous avez des colonnes supplémentaires dans la table pivot, vous pouvez les définir ici
    protected $fillable = ['user_id', 'parc_id'];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Parc
    public function parc()
    {
        return $this->belongsTo(Parc::class);
    }
}
