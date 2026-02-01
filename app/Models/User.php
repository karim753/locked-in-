<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'student_number',
        'program',
        'role', // student, admin, slber
        'microsoft_id',
        'microsoft_office_location',
        'microsoft_department',
        'study_program',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'microsoft_id',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'role' => 'string',
        ];
    }

    /**
     * Get the enrollments for the user.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the inscriptions for the user.
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Get the completed keuzedelen for the user.
     */
    public function completedKeuzedelen()
    {
        return $this->hasMany(CompletedKeuzedeel::class);
    }

    /**
     * Get the course modules the user is enrolled in.
     */
    public function courseModules()
    {
        return $this->belongsToMany(CourseModule::class, 'enrollments')
            ->using(Enrollment::class)
            ->withPivot('status', 'preference_order')
            ->withTimestamps();
    }

    /**
     * Check if user has completed a specific keuzedeel.
     */
    public function hasCompletedKeuzedeel($keuzdeelId)
    {
        return $this->completedKeuzedelen()->where('keuzdeel_id', $keuzdeelId)->exists();
    }

    /**
     * Check if user has an enrollment in a specific period.
     */
    public function hasEnrollmentInPeriod($periodId)
    {
        return $this->inscriptions()
                   ->whereHas('keuzdeel', function ($query) use ($periodId) {
                       $query->where('period_id', $periodId);
                   })
                   ->whereIn('status', ['pending', 'confirmed'])
                   ->exists();
    }

    /**
     * Get current enrollment for a period.
     */
    public function getCurrentEnrollment($periodId)
    {
        return $this->inscriptions()
                   ->whereHas('keuzdeel', function ($query) use ($periodId) {
                       $query->where('period_id', $periodId);
                   })
                   ->whereIn('status', ['pending', 'confirmed'])
                   ->first();
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a student.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Check if user is an SLB (mentor).
     */
    public function isSlb(): bool
    {
        return $this->role === 'slber';
    }

    /**
     * Check if user can enroll in keuzedelen.
     */
    public function canEnroll(): bool
    {
        return $this->isStudent();
    }
}
