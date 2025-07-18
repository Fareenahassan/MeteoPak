<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Show the form for creating a new media upload.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('media-upload');
    }

    /**
     * Store a newly created media resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media_type' => 'required|in:image,video',
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:102400', // 100MB max
            'tags' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            
            // Generate a unique file name
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Determine the storage directory based on media type
            $directory = $request->media_type === 'image' ? 'images' : 'videos';
            
            // Store the file
            $filePath = $file->storeAs('public/' . $directory, $fileName);
            
            // Create media record in database
            $media = new Media();
            $media->title = $request->title;
            $media->description = $request->description;
            $media->type = $request->media_type;
            $media->file_path = $filePath;
            $media->file_name = $fileName;
            $media->mime_type = $file->getMimeType();
            $media->size = $file->getSize();
            
            // Handle tags
            if ($request->has('tags') && !empty($request->tags)) {
                $tags = array_map('trim', explode(',', $request->tags));
                $media->tags = json_encode($tags);
            }
            
            $media->save();
            
            return back()->with('success', 'Media uploaded successfully!');
        }
        
        return back()->with('error', 'Failed to upload media.');
    }
}