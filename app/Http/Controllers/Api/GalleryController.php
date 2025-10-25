<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class GalleryController extends Controller
{
    public function index()
    {

        $galleries = Gallery::with('category')->get();
        return GalleryResource::collection($galleries);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = FacadesValidator::make($request->all(), [
            // 'src' => 'required|string',
            'alt' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);


        if ($validated->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "error" => $validated->errors()
                ],
                422
            );
        }
        if ($request->hasFile('src')) {
            $file = $request->file('src');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs('gallery', $filename, 'public');
        }

        $gallery = Gallery::create([
            'src' => $path ?? null,
            'alt' => $request->alt,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return new GalleryResource($gallery);
    }

    public function show(Gallery $gallery)
    {
        return new GalleryResource($gallery);
    }

    public function update(Request $request, Gallery $gallery)
    {

        $validated = FacadesValidator::make($request->all(), [
            //  'src' => 'sometimes|string',
            'alt' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "error" => $validated->errors()
                ],
                422
            );
        }

        if ($request->hasFile('src')) {
            if($gallery->src){
                Storage::disk('public')->delete($gallery->src);
            }
            $file = $request->file('src');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs('gallery', $filename, 'public');
        }

        $gallery->update([
            'src' => $path ?? null,
            'alt' => $request->alt,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description
        ]);


        return new GalleryResource($gallery);
    }

    public function destroy(Gallery $gallery)
    {
        // Delete image file if it exists
        if ($gallery->src && Storage::disk('public')->exists($gallery->src)) {
            Storage::disk('public')->delete($gallery->src);
        }

        // Delete record from DB
        $gallery->delete();

        return response()->json(['message' => 'Gallery item and image deleted successfully']);
    }
}
