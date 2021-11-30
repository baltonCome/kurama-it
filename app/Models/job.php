<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model{


    use HasFactory;

    protected $fillable = [

        'job-title',
        'job-type',
        'location',
        'salary',
        'time-period',
        'description',
        'required-skills',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }
}
