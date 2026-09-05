<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeTrackingController extends Controller
{
    /**
     * Get active timer and recent history for current user.
     */
    public function status()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Nicht angemeldet'], 401);
        }

        $activeEntry = TimeEntry::where('user_id', $user->id)
            ->whereIn('status', ['running', 'paused'])
            ->latest()
            ->first();

        $recentEntries = TimeEntry::where('user_id', $user->id)
            ->where('status', 'stopped')
            ->latest('ended_at')
            ->take(3)
            ->get();

        $currentDuration = 0;
        if ($activeEntry) {
            $currentDuration = (int) $activeEntry->duration_seconds;
            if ($activeEntry->status === 'running' && $activeEntry->last_resumed_at) {
                $diff = now()->timestamp - Carbon::parse($activeEntry->last_resumed_at)->timestamp;
                $currentDuration += max(0, $diff);
            }
        }

        return response()->json([
            'user_name' => $user->first_name ?: $user->name,
            'active_entry' => $activeEntry,
            'current_duration' => max(0, $currentDuration),
            'recent_entries' => $recentEntries,
        ]);
    }

    /**
     * Start a new time tracking timer.
     */
    public function start(Request $request)
    {
        $request->validate([
            'activity_description' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        // Stop any currently running timer
        $existing = TimeEntry::where('user_id', $user->id)
            ->whereIn('status', ['running', 'paused'])
            ->first();

        if ($existing) {
            if ($existing->status === 'running' && $existing->last_resumed_at) {
                $diff = now()->timestamp - Carbon::parse($existing->last_resumed_at)->timestamp;
                $existing->duration_seconds += max(0, $diff);
            }
            $existing->update([
                'status' => 'stopped',
                'ended_at' => now(),
            ]);

            // Enforce Dennis's reference rule: Maximum 3 completed entries.
            // As soon as a 4th measurement is completed, the oldest entry is automatically deleted.
            $completed = TimeEntry::where('user_id', $user->id)
                ->where('status', 'stopped')
                ->orderBy('ended_at', 'desc')
                ->get();

            if ($completed->count() > 3) {
                $toDelete = $completed->slice(3);
                TimeEntry::whereIn('id', $toDelete->pluck('id'))->delete();
            }
        }

        $entry = TimeEntry::create([
            'user_id' => $user->id,
            'activity_description' => $request->activity_description,
            'started_at' => now(),
            'last_resumed_at' => now(),
            'duration_seconds' => 0,
            'status' => 'running',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Zeiterfassung gestartet.',
            'entry' => $entry,
        ]);
    }

    /**
     * Pause the running timer.
     */
    public function pause(?TimeEntry $timeEntry = null)
    {
        $user = Auth::user();
        $entry = ($timeEntry && $timeEntry->exists) ? $timeEntry : TimeEntry::where('user_id', $user->id)->where('status', 'running')->latest()->first();

        if (!$entry) {
            return response()->json(['error' => 'Keine aktive Zeiterfassung gefunden.'], 404);
        }

        if ($entry->user_id !== $user->id) {
            return response()->json(['error' => 'Nicht autorisiert.'], 403);
        }

        if ($entry->status === 'running') {
            $added = $entry->last_resumed_at ? max(0, now()->timestamp - Carbon::parse($entry->last_resumed_at)->timestamp) : 0;
            $entry->update([
                'status' => 'paused',
                'duration_seconds' => max(0, (int)$entry->duration_seconds + $added),
                'last_resumed_at' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Zeiterfassung pausiert.',
            'entry' => $entry,
        ]);
    }

    /**
     * Resume a paused timer.
     */
    public function resume(?TimeEntry $timeEntry = null)
    {
        $user = Auth::user();
        $entry = ($timeEntry && $timeEntry->exists) ? $timeEntry : TimeEntry::where('user_id', $user->id)->where('status', 'paused')->latest()->first();

        if (!$entry) {
            return response()->json(['error' => 'Keine pausierte Zeiterfassung gefunden.'], 404);
        }

        if ($entry->user_id !== $user->id) {
            return response()->json(['error' => 'Nicht autorisiert.'], 403);
        }

        if ($entry->status === 'paused') {
            $entry->update([
                'status' => 'running',
                'last_resumed_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Zeiterfassung fortgesetzt.',
            'entry' => $entry,
        ]);
    }

    /**
     * Stop the timer and finalize duration.
     */
    public function stop(?TimeEntry $timeEntry = null)
    {
        $user = Auth::user();
        $entry = ($timeEntry && $timeEntry->exists) ? $timeEntry : TimeEntry::where('user_id', $user->id)->whereIn('status', ['running', 'paused'])->latest()->first();

        if (!$entry) {
            return response()->json(['error' => 'Keine aktive Zeiterfassung gefunden.'], 404);
        }

        if ($entry->user_id !== $user->id) {
            return response()->json(['error' => 'Nicht autorisiert.'], 403);
        }

        $totalSeconds = (int)$entry->duration_seconds;
        if ($entry->status === 'running' && $entry->last_resumed_at) {
            $diff = now()->timestamp - Carbon::parse($entry->last_resumed_at)->timestamp;
            $totalSeconds += max(0, $diff);
        }

        $entry->update([
            'status' => 'stopped',
            'ended_at' => now(),
            'duration_seconds' => max(0, $totalSeconds),
            'last_resumed_at' => null,
        ]);

        // Dennis's Reference Rule: Maximum 3 completed entries are stored.
        // As soon as a 4th measurement is completed, the oldest entry is automatically deleted.
        $completed = TimeEntry::where('user_id', $user->id)
            ->where('status', 'stopped')
            ->orderBy('ended_at', 'desc')
            ->get();

        if ($completed->count() > 3) {
            $toDelete = $completed->slice(3);
            TimeEntry::whereIn('id', $toDelete->pluck('id'))->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Zeiterfassung beendet und gespeichert.',
            'entry' => $entry,
        ]);
    }

    /**
     * Admin view: get all time entries across employees.
     */
    public function adminOverview(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Nur für Administratoren zugänglich.'], 403);
        }

        $entries = TimeEntry::with('user')
            ->latest('started_at')
            ->paginate(50);

        return response()->json($entries);
    }
}
