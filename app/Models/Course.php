<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'subtitle',
        'description',
        'thumbnail',
        'duration_days',
        'total_hours',
        'public_url',
        'order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'duration_days' => 'integer',
            'order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order')->orderBy('lesson_number');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot(['id', 'invoice_number', 'started_at', 'expires_at', 'is_active', 'early_start_agreed'])
            ->withTimestamps();
    }

    public function getProgressForUser(?User $user): int
    {
        if (! $user) {
            return 0;
        }

        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->where('course_id', $this->id)
            ->where('is_completed', true)
            ->count();

        return (int) round(($completedLessons / $totalLessons) * 100);
    }

    public function getCompletedLessonIdsForUser(?User $user): array
    {
        if (! $user) {
            return [];
        }

        return LessonProgress::where('user_id', $user->id)
            ->where('course_id', $this->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();
    }
}
