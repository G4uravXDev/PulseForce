<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class WorkoutAssignment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'workout_assignments';

    protected $fillable = [
        'user_id',
        'assigned_by',
        'goal',
        'level',
        'program_label',
        'completed_exercises', // ['Day 1' => ['Flat Barbell Bench Press', ...], ...]
        'notes',
        'status', // active, completed, paused
    ];

    protected $casts = [
        'completed_exercises' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
