<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = [
        'images',
        'property_id'
    ];

    protected $appends = ['image_url'];

    public function property () {
        return $this->belongsTo(Property::class);
    }

    public function getImageUrlAttribute () {
        return asset('storage/' . $this->images);
    }
}
