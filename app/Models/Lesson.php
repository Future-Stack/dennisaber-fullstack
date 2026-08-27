<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'chapter_name',
        'title',
        'slug',
        'lesson_number',
        'duration_minutes',
        'video_url',
        'video_path',
        'audio_path',
        'pdf_attachment_path',
        'pdf_attachment_name',
        'content_html',
        'is_preview',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'lesson_number' => 'integer',
            'duration_minutes' => 'integer',
            'is_preview' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function isCompletedByUser(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->progresses()
            ->where('user_id', $user->id)
            ->where('is_completed', true)
            ->exists();
    }
}
