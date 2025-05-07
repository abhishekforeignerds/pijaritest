<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'privacy_policy',
        'privacy_policy_hindi',
        'return_policy',
        'return_policy_hindi',
        'shipping_policy',
        'terms_and_conditions',
        'terms_and_conditions_hindi',
        'how_we_work',
        'how_we_work_hindi'
    ];
}
