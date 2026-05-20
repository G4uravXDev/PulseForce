<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DietAssignment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'diet_assignments';

    protected $fillable = [
        'user_id',
        'assigned_by',
        'goal',
        'type',
        'plan_label',
        'completed_meals', // ['2026-05-20' => ['Breakfast:Paneer Paratha', ...], ...]
        'notes',
        'status', // active, completed, paused
    ];

    protected $casts = [
        'completed_meals' => 'array',
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
