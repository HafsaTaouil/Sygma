<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    use HasFactory;

    protected $table='parties';


    protected $fillable = ['name'];

    public function dossiers()
    {
        return $this->belongsToMany(Dossier::class);
    }


    public function modeles()
    {
        return $this->belongsToMany(Modele::class, 'modeles_pieces_parts')
                    ->withPivot('piece_id', 'min_year', 'max_year')
                    ->withTimestamps();
    }
}
