<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'thumbnail' => 'string',
        'photos' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function product_stock()
    {
        return $this->hasmany(ProductStock::class,'product_id','id');
    }

    public function temple_detail()
    {
        return $this->belongsTo(TempleDetails::class,'id','product_id');
    }

    protected $appends = ['full_image_url'];

    // Define an accessor for the 'full_image_url' attribute
    public function getFullImageUrlAttribute()
    {
        // Assuming your images are stored in the public folder under 'images'
        return uploaded_asset($this->thumbnail);
    }

    public function packages()
    {
        return $this->hasMany(Package::class, 'product_id', 'id');
    }

}
