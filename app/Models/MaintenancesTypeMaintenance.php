<?php
// app/Models/MaintenancesTypeMaintenance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenancesTypeMaintenance extends Model
{
    use HasFactory;

    protected $fillable = ['maintenance_id', 'type_maintenance_id'];

    // Optionnel : Définir la table si elle ne suit pas la convention de nommage
    protected $table = 'maintenances_type_maintenance';

    // Relations
    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function typeMaintenance()
    {
        return $this->belongsTo(TypeMaintenance::class);
    }
}
