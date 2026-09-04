<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'username',
        'email',
        'password',
        'role',
        'invoice_number',
        'is_active',
        'occupation',
        'access_from',
        'access_until',
        'permissions',
        'security_code_hash',
        'security_code_expires_at',
        'device_id',
        'device_name',
        'device_bound_at',
        'last_device_activity_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'security_code_hash',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'security_code_expires_at' => 'datetime',
            'device_bound_at' => 'datetime',
            'last_device_activity_at' => 'datetime',
            'access_from' => 'date',
            'access_until' => 'date',
            'permissions' => 'array',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function hasPermission(string $perm): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! $this->isStaff()) {
            return false;
        }

        return ! empty($this->permissions[$perm]);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot(['id', 'invoice_number', 'started_at', 'expires_at', 'is_active', 'early_start_agreed'])
            ->withTimestamps();
    }

    public function lessonProgresses(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function adminNotes(): HasMany
    {
        return $this->hasMany(AdminNote::class);
    }

    public function versionNotes(): HasMany
    {
        return $this->hasMany(VersionNote::class);
    }

    /**
     * Check if user is actively enrolled in a course
     */
    public function isEnrolledIn(Course $course): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->enrollments()
            ->where('course_id', $course->id)
            ->where('is_active', true)
            ->where('started_at', '<=', now()->toDateString())
            ->where('expires_at', '>=', now()->toDateString())
            ->exists();
    }
}
