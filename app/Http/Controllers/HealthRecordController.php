<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthRecordRequest;
use App\Http\Requests\UpdateHealthRecordRequest;
use App\Models\Cow;
use App\Models\HealthRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HealthRecordController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(HealthRecord::class, 'healthRecord');
    }

    /**
     * Display a listing of health records.
     */
    public function index(): View
    {
        $healthRecords = HealthRecord::with('cow')
            ->latest('record_date')
            ->latest('created_at')
            ->paginate(15);

        return view('health-records.index', compact('healthRecords'));
    }

    /**
     * Show the form for creating a new health record.
     */
    public function create(): View
    {
        // Only cows from the user's farm (BelongsToTenant scope applies automatically)
        $cows = Cow::where('status', 'active')->orderBy('tag_number')->get();

        return view('health-records.create', compact('cows'));
    }

    /**
     * Store a newly created health record in storage.
     */
    public function store(StoreHealthRecordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        HealthRecord::create($validated);

        return redirect()->route('health-records.index')
            ->with('success', 'Health record created successfully.');
    }

    /**
     * Show the form for editing the specified health record.
     */
    public function edit(HealthRecord $healthRecord): View
    {
        $cows = Cow::where('status', 'active')->orderBy('tag_number')->get();

        return view('health-records.edit', compact('healthRecord', 'cows'));
    }

    /**
     * Update the specified health record in storage.
     */
    public function update(UpdateHealthRecordRequest $request, HealthRecord $healthRecord): RedirectResponse
    {
        $validated = $request->validated();

        $healthRecord->update($validated);

        return redirect()->route('health-records.index')
            ->with('success', 'Health record updated successfully.');
    }

    /**
     * Remove the specified health record from storage.
     */
    public function destroy(HealthRecord $healthRecord): RedirectResponse
    {
        $healthRecord->delete();

        return redirect()->route('health-records.index')
            ->with('success', 'Health record deleted successfully.');
    }
}
