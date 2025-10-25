<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Eventcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('category')->get();
        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'nullable|string|max:255',
            'location'    => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'description' => 'required|string',
            'attendees'   => 'nullable|string|max:255',
            'impact'      => 'nullable|string|max:255',
            'status'      => 'nullable|string|in:processing,active,completed,cancelled',
            'price'       => 'nullable|string|max:255',
            'featured'    => 'boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // validate file
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], 422);
        }

        $data = $validated->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('event', $filename, 'public');
            $data['image'] = $path; 
        }

        $event = Event::create($data);

        return new EventResource($event);
    }


    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // dd($event);
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Event $event)
    {
        $validated = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'nullable|string|max:255',
            'location'    => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'description' => 'required|string',
            'attendees'   => 'nullable|string|max:255',
            'impact'      => 'nullable|string|max:255',
            'status'      => 'nullable|string|in:processing,completed',
            'price'       => 'nullable|string|max:255',
            'featured'    => 'boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], 422);
        }

        $data = $validated->validated();

        if ($request->hasFile('image')) {
            if($event->image){
                Storage::disk('public')->delete($event->image);
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('event', $filename, 'public');
            $data['image'] = $path;
        }

        $event->update($data);

        return new EventResource($event);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if($event->image){
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return response()->json([
            'message'=>'Event deleted successfully!'
        ]);
    }
}
