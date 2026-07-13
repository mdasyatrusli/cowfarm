<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedStockLogRequest;
use App\Models\Feed;
use App\Models\FeedStockLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedStockLogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FeedStockLog::class, 'feedStockLog');
    }

    /**
     * Show the form for creating a new feed stock log.
     */
    public function create(Request $request): View
    {
        $feeds = Feed::where('farm_id', $request->user()->farm_id)
            ->orderBy('name')
            ->get();

        return view('feed-stock-logs.create', compact('feeds'));
    }

    /**
     * Store a newly created feed stock log in storage.
     */
    public function store(StoreFeedStockLogRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        FeedStockLog::create($validated);

        return redirect()->route('feeds.index')
            ->with('success', 'Feed stock log created successfully.');
    }
}
