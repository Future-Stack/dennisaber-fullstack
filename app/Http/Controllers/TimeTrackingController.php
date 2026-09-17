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

        $activeEntry = TimeEntry::with(['assignedStaff', 'user'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['running', 'paused'])
            ->latest()
            ->first();

        $recentEntries = TimeEntry::with(['assignedStaff', 'user'])
            ->where('user_id', $user->id)
            ->where('status', 'stopped')
            ->latest('ended_at')
            ->take(3)
            ->get()
            ->map(function ($entry) {
                return [
                    'id' => $entry->id,
                    'subject' => $entry->activity_1 ?: ($entry->activity_description ?: 'Kundenbetreuung'),
                    'activities' => $entry->activities_list,
                    'activity_description' => $entry->activity_description,
                    'duration_seconds' => $entry->duration_seconds,
                    'formatted_duration' => $entry->formatted_duration,
                    'started_at' => $entry->started_at?->toISOString(),
                    'stopped_at' => $entry->ended_at?->toISOString(),
                    'started_at_formatted' => $entry->started_at ? $entry->started_at->timezone('Europe/Berlin')->format('d.m.Y H:i') : '',
                    'stopped_at_formatted' => $entry->ended_at ? $entry->ended_at->timezone('Europe/Berlin')->format('d.m.Y H:i') : '',
                    'assigned_staff_name' => $entry->assignedStaff ? $entry->assignedStaff->name : null,
                ];
            });

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
            'active_entry' => $activeEntry ? [
                'id' => $activeEntry->id,
                'subject' => $activeEntry->activity_1 ?: ($activeEntry->activity_description ?: 'Kundenbetreuung'),
                'activities' => $activeEntry->activities_list,
                'activity_description' => $activeEntry->activity_description,
                'status' => $activeEntry->status,
                'started_at' => $activeEntry->started_at?->toISOString(),
                'duration_seconds' => $currentDuration,
                'assigned_staff_name' => $activeEntry->assignedStaff ? $activeEntry->assignedStaff->name : null,
            ] : null,
            'current_duration' => max(0, $currentDuration),
            'recent_entries' => $recentEntries,
        ]);
    }

    /**
     * Start a new time tracking timer with up to 5 activity fields.
     */
    public function start(Request $request)
    {
        $request->validate([
            'activity_1' => ['nullable', 'string', 'max:255'],
            'activity_2' => ['nullable', 'string', 'max:255'],
            'activity_3' => ['nullable', 'string', 'max:255'],
            'activity_4' => ['nullable', 'string', 'max:255'],
            'activity_5' => ['nullable', 'string', 'max:255'],
            'activity_description' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'assigned_staff_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $user = Auth::user();

        // Extract activities from the 5 fields
        $act1 = trim($request->input('activity_1') ?: ($request->input('subject') ?: $request->input('activity_description') ?: 'Kundenbetreuung'));
        $act2 = trim($request->input('activity_2', ''));
        $act3 = trim($request->input('activity_3', ''));
        $act4 = trim($request->input('activity_4', ''));
        $act5 = trim($request->input('activity_5', ''));

        $activitiesList = array_values(array_filter([$act1, $act2, $act3, $act4, $act5]));
        if (empty($activitiesList)) {
            $activitiesList = ['Kundenbetreuung'];
            $act1 = 'Kundenbetreuung';
        }

        $combinedDescription = implode(' · ', $activitiesList);

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

            // Enforce Dennis's reference rule: Maximum 3 completed entries stored.
            // When 4th measurement completes, oldest is permanently deleted.
            $completed = TimeEntry::where('user_id', $user->id)
                ->where('status', 'stopped')
                ->orderBy('ended_at', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            if ($completed->count() > 3) {
                $toDelete = $completed->slice(3);
                TimeEntry::whereIn('id', $toDelete->pluck('id'))->delete();
            }
        }

        $entryData = [
            'user_id' => $user->id,
            'assigned_staff_id' => $request->input('assigned_staff_id') ?: null,
            'activity_description' => $combinedDescription,
            'started_at' => now(),
            'last_resumed_at' => now(),
            'duration_seconds' => 0,
            'status' => 'running',
        ];

        // Safe assign if columns exist
        if (\Illuminate\Support\Facades\Schema::hasColumn('time_entries', 'activity_1')) {
            $entryData['activity_1'] = $act1;
            $entryData['activity_2'] = $act2 ?: null;
            $entryData['activity_3'] = $act3 ?: null;
            $entryData['activity_4'] = $act4 ?: null;
            $entryData['activity_5'] = $act5 ?: null;
        }

        $entry = TimeEntry::create($entryData);

        return response()->json([
            'success' => true,
            'message' => 'Zeiterfassung gestartet.',
            'entry' => $entry,
            'activities' => $activitiesList,
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
            ->orderBy('id', 'desc')
            ->get();

        if ($completed->count() > 3) {
            $toDelete = $completed->slice(3);
            TimeEntry::whereIn('id', $toDelete->pluck('id'))->delete();
        }

        $recentEntries = TimeEntry::with(['assignedStaff', 'user'])
            ->where('user_id', $user->id)
            ->where('status', 'stopped')
            ->latest('ended_at')
            ->take(3)
            ->get()
            ->map(function ($e) {
                return [
                    'id' => $e->id,
                    'subject' => $e->activity_1 ?: ($e->activity_description ?: 'Kundenbetreuung'),
                    'activities' => $e->activities_list,
                    'activity_description' => $e->activity_description,
                    'duration_seconds' => $e->duration_seconds,
                    'formatted_duration' => $e->formatted_duration,
                    'started_at' => $e->started_at?->toISOString(),
                    'stopped_at' => $e->ended_at?->toISOString(),
                    'started_at_formatted' => $e->started_at ? $e->started_at->timezone('Europe/Berlin')->format('d.m.Y H:i') : '',
                    'stopped_at_formatted' => $e->ended_at ? $e->ended_at->timezone('Europe/Berlin')->format('d.m.Y H:i') : '',
                    'assigned_staff_name' => $e->assignedStaff ? $e->assignedStaff->name : null,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Zeiterfassung beendet und gespeichert.',
            'entry' => $entry,
            'recent_entries' => $recentEntries,
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
