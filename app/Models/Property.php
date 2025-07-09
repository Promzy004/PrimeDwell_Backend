<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Property extends Model
{
     protected $fillable = [
        'title',
        'thumbnail_image',
        'property_type',
        'location',
        'price',
        'description',
        'bed',
        'room',
        'bath',
        'square_meter',
        'status',
        'user_id'
    ];

    protected $appends = ['thumbnail_url'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function property_images () {
        return $this->hasMany(PropertyImage::class);
    }

    public function getThumbnailUrlAttribute () {
        return asset('storage/' . $this->thumbnail_image);
    }

    //using belongs to many for pivoted table, favorite table is a pivoted table, i.e property is related to user table
    //through the favorite table, user id and property id in the favorite table
    public function favoritedBy () {
        return $this->belongsToMany(User::class, 'favorite', 'property_id', 'user_id');
    }

    public function favorites () {
        return $this->hasMany(Favorite::class);
    }
}
