<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stories extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'hashtags' => 'array'
    ];

    protected $hidden = [
        'updated_at',
    ];


    /**
     * Define the 'user' relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
