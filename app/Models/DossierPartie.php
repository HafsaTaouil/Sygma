<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierPartie extends Model
{
    use HasFactory;

    protected $table="dossier_parties";

    protected $fillable = ['damage', 'damage_image'];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
    public function partie()
    {
        return $this->belongsTo(Partie::class);
    }

}
