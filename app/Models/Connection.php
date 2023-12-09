<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'connection_id',
        'status', // pending, accepted, rejected
        'payment_status', // paid, unpaid (for males only)
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function connectionUser()
    {
        return $this->belongsTo(User::class, 'connection_id');
    }
}
