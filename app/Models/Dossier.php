<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dossier extends Model
{
    use HasFactory;
    
    protected $table="dossiers";


    protected $fillable = [
        'registration_number', 'previous_registration', 'first_registration',
        'MC_maroc', 'usage', 'owner', 'address', 'validity_end',
        'type', 'genre', 'fuel_type', 'chassis_nbr', 'cylinder_nbr',
        'fiscal_power', 'cartegrise_recto', 'cartegrise_verso',
        'permis_recto', 'permis_verso'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parties()
    {
        return $this->belongsToMany(Partie::class);
    }

    public function modele()
    {
        return $this->belongsTo(Modele::class);
    }

    public function dossierParties()
    {
        return $this->hasMany(DossierPartie::class);
    }
}
