<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Attendance extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'attendance';

    protected $fillable = [
        'user_id',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
