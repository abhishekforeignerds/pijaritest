<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id','package_id','inclusion','date','time','city','language','location'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }

}
