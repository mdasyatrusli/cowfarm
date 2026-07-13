<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedRequest;
use App\Http\Requests\UpdateFeedRequest;
use App\Models\Feed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Feed::class, 'feed');
    }

    /**
     * Display a listing of the feeds.
     */
    public function index(): View
    {
        $feeds = Feed::with('farm')
            ->latest()
            ->paginate(15);

        return view('feeds.index', compact('feeds'));
    }

    /**
     * Show the form for creating a new feed.
     */
    public function create(): View
    {
        return view('feeds.create');
    }

    /**
     * Store a newly created feed in storage.
     */
    public function store(StoreFeedRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Remove initial_stock from feed creation (not a column on feeds table)
        $initialStock = $validated['initial_stock'] ?? 0;
        unset($validated['current_stock'], $validated['initial_stock']);

        // Create feed with current_stock = 0 (default from migration)
        $feed = Feed::create($validated);

        // If initial stock > 0, create a stock-in log (auto-increments via FeedStockLog::booted)
        if ($initialStock > 0) {
            $feed->stockLogs()->create([
                'farm_id' => $request->user()->farm_id,
                'type' => 'in',
                'quantity' => $initialStock,
                'note' => 'Initial stock',
                'log_date' => now(),
            ]);
        }

        return redirect()->route('feeds.index')
            ->with('success', 'Feed created successfully.');
    }

    /**
     * Show the form for editing the specified feed.
     */
    public function edit(Feed $feed): View
    {
        return view('feeds.edit', compact('feed'));
    }

    /**
     * Update the specified feed in storage.
     */
    public function update(UpdateFeedRequest $request, Feed $feed): RedirectResponse
    {
        $validated = $request->validated();

        $feed->update($validated);

        return redirect()->route('feeds.index')
            ->with('success', 'Feed updated successfully.');
    }

    /**
     * Remove the specified feed from storage.
     */
    public function destroy(Feed $feed): RedirectResponse
    {
        $feed->delete();

        return redirect()->route('feeds.index')
            ->with('success', 'Feed deleted successfully.');
    }
}
