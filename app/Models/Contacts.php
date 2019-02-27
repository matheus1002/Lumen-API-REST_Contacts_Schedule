<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model 
{
    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'date'
    ];

    protected $casts = [
        'date' => 'Timestamp'
    ];

    public $timestamps = false; 
}