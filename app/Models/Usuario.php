<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        
        'name',
        'email',
        'password',
        'username',
        'image', 
        'headline',
        'country',
        'city',
        'skills',
        'languages',
        'experience',
        'education'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jobs(){

        return $this->hasMany(Job::class);
    }

    public function interests(){

        return $this->hasMany(Interest::class);
    }

    public function receivedInterests(){

        return $this->hasManyThrough(Interest::class, Job::class);
    }
}
