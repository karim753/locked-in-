<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_module_id',
        'status',
        'preference_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preference_order' => 'integer',
    ];

    /**
     * Get the user that owns the enrollment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course module that the enrollment is for.
     */
    public function courseModule(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class);
    }

    /**
     * Scope a query to only include confirmed enrollments.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include waiting list enrollments.
     */
    public function scopeWaitingList($query)
    {
        return $query->where('status', 'waiting_list');
    }

    /**
     * Check if the enrollment is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if the enrollment is on the waiting list.
     */
    public function isOnWaitingList(): bool
    {
        return $this->status === 'waiting_list';
    }
}
