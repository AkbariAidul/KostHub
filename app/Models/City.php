<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = 
    [
        'image',
        'name',
        'slug',
    ];

    public function boardingHouses()
    {
        return $this -> hasMany(BoardingHouse::class);
    }

}
