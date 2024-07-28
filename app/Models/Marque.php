<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    use HasFactory;

    protected $table='marques';

    protected $fillable = ['name'];


    public function modeles()
    {
        return $this->hasMany(Modele::class);
    }
    public function dossiers()
{
    return $this->hasMany(Dossier::class);
}
}
