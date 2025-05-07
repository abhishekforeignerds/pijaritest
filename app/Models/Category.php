<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    public function product()
    {
        return $this->hasmany(ProductStock::class,'category_id','id');
    }

    public function subcategory()
    {
        return $this->hasMany(SubCategory::class,'category_id','id');
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
