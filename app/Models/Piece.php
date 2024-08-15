<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    protected $table = 'pieces';

    protected $fillable = [
        'name', 
        'image', 
        'price_replacement', 
        'price_scratch', 
        'price_quickRepair', 
        'price_painting', 
        'price_bodywork'
    ];

    public function parties()
    {
        return $this->belongsToMany(Partie::class, 'modeles_pieces_parts')
                    ->withPivot('modele_id', 'min_year', 'max_year')
                    ->withTimestamps();
    }
}
