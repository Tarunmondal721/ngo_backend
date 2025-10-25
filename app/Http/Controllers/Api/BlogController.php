<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = BlogPost::with('category')->get();
        return  BlogResource::collection($blog);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = FacadesValidator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'excerpt'      => 'required|string',
            'author'       => 'required|string|max:255',
            'date'         => 'required|date',
            'read_time'    => 'nullable|string|max:255',
            'category_id'  => 'required|string|max:255',
            'content'      => 'required|string',
            'featured'     => 'boolean',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $path = $file->storeAs('blog', $filename, 'public');
            $data['image'] = $path;
        }

        $data['slug'] =  Str::slug($data['title']) . '-' . time();

        $blog = BlogPost::create($data);

        return new BlogResource($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blog)
    {
        // dd($blog_post);
        return new BlogResource($blog);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(BlogPost $blog_post)
    // {
    //     $data = BlogPost::findorfail($blog_post->id);
    //     return new BlogResource($data);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blog)
    {
        
        $validated = FacadesValidator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'excerpt'      => 'required|string',
            'author'       => 'required|string|max:255',
            'date'         => 'required|date',
            'read_time'    => 'nullable|string|max:255',
            'category_id'  => 'required|string|max:255',
            'content'      => 'required|string',
            'featured'     => 'boolean',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], 422);
        }

        $data = $validated->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blog', $filename, 'public');
            $data['image'] = $path;
        }

        $data['slug'] =  Str::slug($data['title']) . '-' . time();

        $blog->update($data);

        return new BlogResource($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blog)
    {
        
        if($blog->image){
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();
        return response()->json([
            'message'=>'Blog deleted successfully!'
        ]);
    }


    public function findSlug($slug){
        
       $blog = BlogPost::where('slug', $slug)->firstOrFail();
        return new BlogResource($blog);

    }
}
