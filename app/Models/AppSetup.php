<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetup extends Model
{
    use HasFactory;

    protected $fillable = [ 'name','value' ];
}
