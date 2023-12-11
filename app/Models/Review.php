<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_id",
        "content",
        "ratings",
<<<<<<< HEAD
        "rated_by"
=======
>>>>>>> d9c9e64fa65359c8b436f513e49a8158be33773b
    ];
}
