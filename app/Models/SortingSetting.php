<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortingSetting extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'sort_column', 'sort_direction'];

    public static function getSettingFor($model)
    {
        return static::firstOrCreate(['model' => $model], [
            'sort_column' => 'name',
            'sort_direction' => 'asc'
        ]);
    }

    public static function updateSetting($model, $column, $direction)
    {
        return static::updateOrCreate(['model' => $model], [
            'sort_column' => $column,
            'sort_direction' => $direction
        ]);
    }
}
