<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuzedeel extends Model
{
    use HasFactory;

    protected $table = 'keuzedelen';

    protected $fillable = [
        'title',
        'description',
        'period_id',
        'min_participants',
        'max_participants',
        'is_repeatable',
        'is_active',
        'teacher_name',
        'schedule_info',
        'credits',
    ];

    protected $casts = [
        'is_repeatable' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'keuzdeel_id');
    }

    public function completedKeuzedelen()
    {
        return $this->hasMany(CompletedKeuzedeel::class, 'keuzdeel_id');
    }

    public function currentEnrollments()
    {
        return $this->inscriptions()
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->count();
    }

    public function availableSpots()
    {
        return $this->max_participants - $this->currentEnrollments();
    }

    public function isFull()
    {
        return $this->currentEnrollments() >= $this->max_participants;
    }

    public function hasMinimumParticipants()
    {
        return $this->currentEnrollments() >= $this->min_participants;
    }

    public function isAvailableForUser($user)
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->period->isEnrollmentOpen()) {
            return false;
        }

        // Check if user already has an active inscription for this keuzedeel
        $hasActiveInscription = $user->inscriptions()
            ->where('keuzdeel_id', $this->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasActiveInscription) {
            return false;
        }

        // Check if user has already completed this keuzedeel
        if ($user->hasCompletedKeuzedeel($this->id)) {
            return false;
        }

        // Check if user has enrollment in period (REMOVED - allow multiple keuzedelen per period)
        // if ($user->hasEnrollmentInPeriod($this->period_id)) {
        //     return false;
        // }

        return true;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->active()
                    ->whereHas('period', function ($q) {
                        $q->enrollmentOpen();
                    });
    }
}
