<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteFactory> */
    use HasFactory;

    public function users () {
        return $this->belongsTo(User::class);
    }

    public function property () {
        return $this->belongsTo(Property::class);
    }
}
