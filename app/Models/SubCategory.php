<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }


    protected $casts = [
        'icon' => 'string',
    ];

    protected $appends = ['full_image_url'];

    // Define an accessor for the 'full_image_url' attribute
    public function getFullImageUrlAttribute()
    {
        // Assuming your images are stored in the public folder under 'images'
        return uploaded_asset($this->icon);
    }

}
