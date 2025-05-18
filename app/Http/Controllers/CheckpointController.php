<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckpointController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Only show checkpoints to admin, driver, or the owner
        if ($user->isAdmin() || $user->isDriver()) {
            $checkpoints = Checkpoint::all();
        } else {
            $checkpoints = $user->checkpoints;
        }
        
        return view('user.dashboard', compact('checkpoints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|in:daily,weekly,biweekly,monthly',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $checkpoint = Auth::user()->checkpoints()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'schedule' => $validated['schedule'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Collection point added successfully.',
            'checkpoint' => $checkpoint
        ]);
    }

    public function update(Request $request, Checkpoint $checkpoint)
    {
        $this->authorize('update', $checkpoint);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|in:daily,weekly,biweekly,monthly',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $checkpoint->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Collection point updated successfully.',
            'checkpoint' => $checkpoint
        ]);
    }

    public function destroy(Checkpoint $checkpoint)
    {
        $this->authorize('delete', $checkpoint);
        
        $checkpoint->delete();

        return response()->json([
            'success' => true,
            'message' => 'Collection point deleted successfully.'
        ]);
    }
} 