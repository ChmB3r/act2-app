<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Series;
use App\Models\TrackerEntry;
use App\Models\Genre;
use App\Models\PrivateNote;
use Illuminate\Support\Facades\Auth;

class ManhwaController extends Controller
{
    /**
     * Display a listing of the user's tracked manhwa.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $entries = $user->trackerEntries()
            ->with(['series.genres', 'privateNote'])
            ->latest()
            ->get();

        return view('manhwa.index', compact('entries'));
    }

    /**
     * Show the form for creating a new tracker entry.
     */
    public function create(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Get series that the user is not yet tracking
        $trackedSeriesIds = $user->trackerEntries()->pluck('series_id');
        $series = Series::whereNotIn('id', $trackedSeriesIds)->get();
        
        return view('manhwa.create', compact('series'));
    }

    /**
     * Store a newly created tracker entry in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:Reading,Plan to Read,Completed,On-hold,Dropped',
            'last_read_chapter' => 'required|integer|min:0',
            'rating' => 'nullable|integer|min:1|max:10',
            'note' => 'nullable|string',
            'mal_id' => 'nullable|integer',
            'cover_image' => 'nullable|url',
            'description' => 'nullable|string',
            'total_chapters' => 'nullable|integer',
        ]);

        $user = Auth::user();

        // Find or create the series
        if ($request->filled('mal_id')) {
            $series = Series::updateOrCreate(
                ['mal_id' => $request->mal_id],
                [
                    'title' => $request->title,
                    'cover_image' => $request->cover_image,
                    'description' => $request->description,
                    'total_chapters' => $request->total_chapters,
                ]
            );
        } else {
            $series = Series::firstOrCreate(
                ['title' => $request->title]
            );
        }

        // Check if user is already tracking this series
        if ($user->trackerEntries()->where('series_id', $series->id)->exists()) {
            return redirect()->back()->withErrors(['title' => 'You are already tracking this series.']);
        }

        $entry = $user->trackerEntries()->create([
            'series_id' => $series->id,
            'status' => $request->status,
            'last_read_chapter' => $request->last_read_chapter,
        ]);

        if ($request->filled('rating') || $request->filled('note')) {
            $entry->privateNote()->create([
                'rating' => $request->rating,
                'note' => $request->note,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Series added to your legend.');
    }

    /**
     * Display the specified tracker entry.
     */
    public function show(Request $request, TrackerEntry $manhwa)
    {
        if ($manhwa->user_id !== $request->user()->id) {
            abort(403);
        }

        $manhwa->load(['series.genres', 'privateNote']);
        
        return view('manhwa.show', compact('manhwa'));
    }

    /**
     * Show the form for editing the specified tracker entry.
     */
    public function edit(Request $request, TrackerEntry $manhwa)
    {
        // Ensure user owns the entry
        if ($manhwa->user_id !== $request->user()->id) {
            abort(403);
        }

        $manhwa->load(['series', 'privateNote']);
        
        return view('manhwa.edit', compact('manhwa'));
    }

    /**
     * Update the specified tracker entry in storage.
     */
    public function update(Request $request, TrackerEntry $manhwa)
    {
        if ($manhwa->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:Reading,Plan to Read,Completed,On-hold,Dropped',
            'last_read_chapter' => 'required|integer|min:0',
            'rating' => 'nullable|integer|min:1|max:10',
            'note' => 'nullable|string',
        ]);

        $manhwa->update([
            'status' => $validated['status'],
            'last_read_chapter' => $validated['last_read_chapter'],
        ]);

        $manhwa->privateNote()->updateOrCreate(
            ['entry_id' => $manhwa->id],
            [
                'rating' => $validated['rating'],
                'note' => $validated['note'],
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Tracker entry updated!');
    }

    /**
     * Remove the specified tracker entry from storage.
     */
    public function destroy(Request $request, TrackerEntry $manhwa)
    {
        if ($manhwa->user_id !== $request->user()->id) {
            abort(403);
        }

        $manhwa->delete();

        return redirect()->route('dashboard')->with('success', 'Series removed from your tracker.');
    }
}
