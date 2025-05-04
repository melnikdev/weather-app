<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'city',
        'temperature',
        'condition',
        'humidity',
        'wind_speed',
        'last_updated',
    ];

}
