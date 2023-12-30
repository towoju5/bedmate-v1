<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'  => 'hashed',
        'kinks'     => 'array',
        'is_escort' => 'boolean',
        'tags'      => 'array',
        'metadata'  => 'array',
        'interested_in' => 'array',
        'sexual_preference' => 'array',
    ];


    /**
     * A user can have many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(ChatMessages::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function gallery() {
        return $this->hasMany(Gallery::class)->whereHas(function ($query) {
            $query->groupBy('file_type');
        });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function connections()
    {
        return $this->hasMany(Connection::class);
    }
    
    /**
     * Define the inverse of the 'user' relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stories()
    {
        return $this->hasMany(Story::class, 'user_id');
    }
}
