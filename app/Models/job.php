<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model{

    use HasFactory;

    protected $fillable = [

        'title',
        'user_id',
        'category',
        'subcategory',
        'job_type',
        'location',
        'salary',
        'salaryPer',
        'time_period',
        'description',
        'required_skills',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function interests(){

        return $this->hasMany(Interest::class);
    }

    public function interested(User $user){

        return $this->interests->contains('user_id', $user->id);
    }
}
