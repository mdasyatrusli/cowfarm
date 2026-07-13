<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedRecordRequest;
use App\Http\Requests\UpdateFeedRecordRequest;
use App\Models\Cow;
use App\Models\Feed;
use App\Models\FeedRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedRecordController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FeedRecord::class, 'feedRecord');
    }

    /**
     * Display a listing of the feed records.
     */
    public function index(Request $request): View
    {
        $feedRecords = FeedRecord::with(['cow', 'feed'])
            ->where('farm_id', $request->user()->farm_id)
            ->latest()
            ->paginate(15);

        return view('feed-records.index', compact('feedRecords'));
    }

    /**
     * Show the form for creating a new feed record.
     */
    public function create(Request $request): View
    {
        $cows = Cow::where('farm_id', $request->user()->farm_id)
            ->orderBy('tag_number')
            ->get();

        $feeds = Feed::where('farm_id', $request->user()->farm_id)
            ->orderBy('name')
            ->get();

        return view('feed-records.create', compact('cows', 'feeds'));
    }

    /**
     * Store a newly created feed record in storage.
     */
    public function store(StoreFeedRecordRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['recorded_by'] = $request->user()->id;

        FeedRecord::create($validated);

        return redirect()->route('feed-records.index')
            ->with('success', 'Feed record created successfully.');
    }

    /**
     * Show the form for editing the specified feed record.
     */
    public function edit(FeedRecord $feedRecord, Request $request): View
    {
        $cows = Cow::where('farm_id', $request->user()->farm_id)
            ->orderBy('tag_number')
            ->get();

        $feeds = Feed::where('farm_id', $request->user()->farm_id)
            ->orderBy('name')
            ->get();

        return view('feed-records.edit', compact('feedRecord', 'cows', 'feeds'));
    }

    /**
     * Update the specified feed record in storage.
     */
    public function update(UpdateFeedRecordRequest $request, FeedRecord $feedRecord): RedirectResponse
    {
        $feedRecord->update($request->validated());

        return redirect()->route('feed-records.index')
            ->with('success', 'Feed record updated successfully.');
    }

    /**
     * Remove the specified feed record from storage.
     */
    public function destroy(FeedRecord $feedRecord): RedirectResponse
    {
        $feedRecord->delete();

        return redirect()->route('feed-records.index')
            ->with('success', 'Feed record deleted successfully.');
    }
}
