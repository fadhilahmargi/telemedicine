<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|static firstOrCreate(array $attributes = [], array $values = [])
 * @method static \Illuminate\Database\Eloquent\Builder|static firstOrFail($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|static create(array $attributes = [])
 */
class AppSetting extends Model
{

    protected $fillable = [
        'app_name',
        'app_logo',
        'app_description',
    ];
}
