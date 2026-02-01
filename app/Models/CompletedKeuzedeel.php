<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedKeuzedeel extends Model
{
    use HasFactory;

    protected $table = 'completed_keuzedelen';

    protected $fillable = [
        'user_id',
        'keuzdeel_id',
        'completion_date',
        'grade',
        'remarks',
    ];

    protected $casts = [
        'completion_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keuzdeel()
    {
        return $this->belongsTo(Keuzedeel::class, 'keuzdeel_id');
    }
}
