<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    protected $table='pieces';

    protected $fillable = ['name', 'image', 'prix_reparation', 'prix_remplacement'];

    

    public function parties()
    {
        return $this->belongsToMany(Partie::class, 'modeles_pieces_parts')
                    ->withPivot('modele_id', 'min_year', 'max_year')
                    ->withTimestamps();
    }
}
