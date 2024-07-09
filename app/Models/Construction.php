<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Construction extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(ConstructionImages::class, 'construction_id', 'id');
    }
}
