<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory,SoftDeletes;

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
