<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    // Fetch user videos
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $videos = Video::where('user_id', Auth::id())->latest()->get();
            return view('components.video-list', compact('videos'))->render(); // return component only
        }

        return view('dashboard.index');
    }

    // Store new video
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400', // 100MB
        ]);

        $file = $request->file('video');
        $path = $file->store('videos', 'public');

        $video = Video::create([
            'user_id' => Auth::id(),
            'title' => $file->getClientOriginalName(),
            'file_path' => $path,
            'size' => $file->getSize(),
            'status' => 'ready',
        ]);

        return response()->json(['success' => true, 'message' => 'Video uploaded successfully!']);
    }

    // Delete video
    public function destroy(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($video->file_path);
        $video->delete();

        return response()->json(['success' => true]);
    }
}
