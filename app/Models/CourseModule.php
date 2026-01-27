<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class CourseModule extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'title',
        'description',
        'learning_goals',
        'content',
        'minimum_students',
        'maximum_students',
        'allow_multiple_enrollments',
        'is_active',
        'period',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'minimum_students' => 'integer',
        'maximum_students' => 'integer',
        'allow_multiple_enrollments' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the enrollments for the course module.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the confirmed enrollments for the course module.
     */
    public function confirmedEnrollments()
    {
        return $this->enrollments()->confirmed();
    }

    /**
     * Get the waiting list enrollments for the course module.
     */
    public function waitingListEnrollments()
    {
        return $this->enrollments()->waitingList();
    }

    /**
     * Check if the course module is full.
     */
    public function isFull(): bool
    {
        return $this->confirmedEnrollments()->count() >= $this->maximum_students;
    }

    /**
     * Check if the course module has enough students to start.
     */
    public function hasEnoughStudents(): bool
    {
        return $this->confirmedEnrollments()->count() >= $this->minimum_students;
    }

    /**
     * Check if the course module is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Scope a query to only include active course modules.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include course modules in a specific period.
     */
    public function scopeForPeriod(Builder $query, string $period): Builder
    {
        return $query->where('period', $period);
    }

    /**
     * Get the available spots remaining.
     */
    public function availableSpots(): int
    {
        return max(0, $this->maximum_students - $this->confirmedEnrollments()->count());
    }
}
