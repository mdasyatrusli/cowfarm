<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBreedRequest;
use App\Http\Requests\UpdateBreedRequest;
use App\Models\Breed;

class BreedController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Breed::class, 'breed');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breeds = Breed::orderBy('name')->paginate(10);
        return view('breeds.index', compact('breeds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('breeds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBreedRequest $request)
    {
        Breed::create($request->validated());

        return redirect()->route('breeds.index')
            ->with('success', 'Breed created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Breed $breed)
    {
        return view('breeds.edit', compact('breed'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBreedRequest $request, Breed $breed)
    {
        $breed->update($request->validated());

        return redirect()->route('breeds.index')
            ->with('success', 'Breed updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Breed $breed)
    {
        $breed->delete();

        return redirect()->route('breeds.index')
            ->with('success', 'Breed deleted successfully.');
    }
}
