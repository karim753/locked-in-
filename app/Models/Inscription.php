<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $table = 'inscriptions';

    protected $fillable = [
        'user_id',
        'keuzdeel_id',
        'status',
        'priority',
        'inscribed_at',
    ];

    protected $casts = [
        'inscribed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keuzdeel()
    {
        return $this->belongsTo(Keuzedeel::class, 'keuzdeel_id');
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isWaitlisted()
    {
        return $this->status === 'waitlist';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }
}
