<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    protected $casts = [
        'image' => 'string',
    ];

    protected $appends = ['full_image_url'];

    // Define an accessor for the 'full_image_url' attribute
    public function getFullImageUrlAttribute()
    {
        // Assuming your images are stored in the public folder under 'images'
        return uploaded_asset($this->image);
    }
}
