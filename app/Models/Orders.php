<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use HasFactory;

    protected $table="orders";

    protected $casts = [
        'orders' => 'array'
    ];

    public function etapes()
    {
        // Assuming 'orders' JSON field contains etapes IDs as an array
        return Etapes::whereIn('id', $this->orders)->get();
    }
}
