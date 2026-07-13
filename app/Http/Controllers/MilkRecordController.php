<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMilkRecordRequest;
use App\Http\Requests\UpdateMilkRecordRequest;
use App\Models\Cow;
use App\Models\MilkRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MilkRecordController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MilkRecord::class, 'milkRecord');
    }

    /**
     * Display a listing of milk records.
     */
    public function index(): View
    {
        $milkRecords = MilkRecord::with('cow')
            ->latest('record_date')
            ->latest('created_at')
            ->paginate(15);

        return view('milk-records.index', compact('milkRecords'));
    }

    /**
     * Show the form for creating a new milk record.
     */
    public function create(): View
    {
        // Only active cows from the user's farm (BelongsToTenant scope applies automatically)
        $cows = Cow::where('status', 'active')->orderBy('tag_number')->get();

        return view('milk-records.create', compact('cows'));
    }

    /**
     * Store a newly created milk record in storage.
     */
    public function store(StoreMilkRecordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        MilkRecord::create($validated);

        return redirect()->route('milk-records.index')
            ->with('success', 'Milk record created successfully.');
    }

    /**
     * Show the form for editing the specified milk record.
     */
    public function edit(MilkRecord $milkRecord): View
    {
        $cows = Cow::where('status', 'active')->orderBy('tag_number')->get();

        return view('milk-records.edit', compact('milkRecord', 'cows'));
    }

    /**
     * Update the specified milk record in storage.
     */
    public function update(UpdateMilkRecordRequest $request, MilkRecord $milkRecord): RedirectResponse
    {
        $validated = $request->validated();

        $milkRecord->update($validated);

        return redirect()->route('milk-records.index')
            ->with('success', 'Milk record updated successfully.');
    }

    /**
     * Remove the specified milk record from storage.
     */
    public function destroy(MilkRecord $milkRecord): RedirectResponse
    {
        $milkRecord->delete();

        return redirect()->route('milk-records.index')
            ->with('success', 'Milk record deleted successfully.');
    }
}
