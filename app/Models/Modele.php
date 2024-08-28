<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    use HasFactory;


    protected $table='modeles';

    protected $fillable = ['name', 'marque_id'];

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    public function piecesParties()
{
    return $this->belongsToMany(Piece::class, 'modeles_pieces_parts')
                ->withPivot('partie_id', 'min_year', 'max_year')
                ->withTimestamps();
}

    public function hasPieceForPart($partId)
{
    return $this->pieces()->whereHas('parts', function ($query) use ($partId) {
        $query->where('partie_id', $partId);
    })->exists();
}

}
