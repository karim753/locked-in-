<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'enrollment_opens_at',
        'enrollment_closes_at',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'enrollment_opens_at' => 'datetime',
        'enrollment_closes_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function keuzedelen()
    {
        return $this->hasMany(Keuzedeel::class);
    }

    public function inscriptions()
    {
        return $this->hasManyThrough(Inscription::class, Keuzdeel::class);
    }

    public function isEnrollmentOpen()
    {
        $now = now();
        return $this->is_active && 
               $now->gte($this->enrollment_opens_at) && 
               $now->lte($this->enrollment_closes_at);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeEnrollmentOpen($query)
    {
        $now = now();
        return $query->where('is_active', true)
                     ->where('enrollment_opens_at', '<=', $now)
                     ->where('enrollment_closes_at', '>=', $now);
    }
}
