<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packages extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts =  [
        'other_package_details' => 'array'
    ];
}
