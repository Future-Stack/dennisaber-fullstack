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
        'assigned_staff_id',
        'activity_description',
        'activity_1',
        'activity_2',
        'activity_3',
        'activity_4',
        'activity_5',
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

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    /**
     * Get list of all 5 activity entries
     */
    public function getActivitiesListAttribute(): array
    {
        $activities = [];
        for ($i = 1; $i <= 5; $i++) {
            $prop = "activity_{$i}";
            if (!empty($this->$prop)) {
                $activities[] = $this->$prop;
            }
        }

        if (empty($activities) && !empty($this->activity_description)) {
            $decoded = json_decode($this->activity_description, true);
            if (is_array($decoded)) {
                return array_filter($decoded);
            }
            if (str_contains($this->activity_description, ' · ')) {
                return explode(' · ', $this->activity_description);
            }
            return [$this->activity_description];
        }

        return $activities;
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
