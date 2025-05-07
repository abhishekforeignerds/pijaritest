<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    public function userData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
