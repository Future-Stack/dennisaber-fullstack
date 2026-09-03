<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TimeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_description',
        'started_at',
        'ended_at',
        'duration_seconds',
        'status',
        'last_resumed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'last_resumed_at' => 'datetime',
        'duration_seconds' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedDurationAttribute(): string
    {
        $seconds = $this->duration_seconds;
        if ($this->status === 'running' && $this->last_resumed_at) {
            $seconds += now()->diffInSeconds($this->last_resumed_at);
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    public function getFormattedDurationShortAttribute(): string
    {
        $seconds = $this->duration_seconds;
        if ($this->status === 'running' && $this->last_resumed_at) {
            $seconds += now()->diffInSeconds($this->last_resumed_at);
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        if ($hours > 0) {
            return "{$hours} Std. {$minutes} Min.";
        }
        return "{$minutes} Min.";
    }
}
