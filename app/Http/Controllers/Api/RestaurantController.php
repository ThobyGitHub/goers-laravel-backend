<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Restaurant::query()
        ->where('is_deleted', false);
        
        if ($request->filled('name')) {
            $query->filterName($request->name);
            logger('Filtering by name:', ['name' => $request->name]);
        }
        
        if ($request->filled('day')) {
            $query->filterDay($request->day);
            logger('Filtering by day:', ['day' => $request->day]);
            
        }
        
        if ($request->filled('time')) {
            $query->filterTime($request->time);
            logger('Filtering by time:', ['time' => $request->time]);
        }
        
        return response()->json($query->with('openTimes')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'note' => 'nullable|string',
            'open_times' => 'nullable|array',
            'open_times.*.day_start' => 'required|string',
            'open_times.*.day_end' => 'required|string',
            'open_times.*.time_start' => 'required',
            'open_times.*.time_end' => 'required',
        ]);
    
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();
        $restaurant = Restaurant::create($validated);
        if (!empty($validated['open_times'])) {
            foreach ($validated['open_times'] as $openTime) {
                $restaurant->openTimes()->create($openTime);
            }
        }
        $restaurant->load('openTimes');
        return response()->json($restaurant, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Restaurant::where("id", $id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $restaurant = Restaurant::find($id);
        
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'note' => 'nullable|string',
            'open_times' => 'nullable|array',
            'open_times.*.day_start' => 'required_with:open_times',
            'open_times.*.day_end' => 'required_with:open_times',
            'open_times.*.time_start' => 'required_with:open_times|string',
            'open_times.*.time_end' => 'required_with:open_times|string',
        ]);

        $validated['updated_by'] = auth()->id();

        $restaurant->update($validated);
        if ($request->has('open_times')) {

            // Delete old open times
            $restaurant->openTimes()->delete();
    
            // Recreate new ones
            foreach ($request->open_times as $openTime) {
                $restaurant->openTimes()->create($openTime);
            }
        }
    

        $restaurant->load('openTimes');

        return response()->json($restaurant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        $restaurant->update([
            'is_deleted' => true,
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Deleted']);
    }
}