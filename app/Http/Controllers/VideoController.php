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
        $videos = Video::where('user_id', Auth::id())->latest()->get();

        if ($request->ajax()) {
            // Return only the rendered component for AJAX refresh
            return view('components.video-list', compact('videos'))->render();
        }

        return view('dashboard.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,mov,avi,wmv', // 100 MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $file = $request->file('video');
        $path = $file->store('videos', 'local');

        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Store on local disk (storage/app/videos). This is private - not public/storage
        // returns e.g. "videos/abc.mp4"

        $video = Video::create([
            'user_id'   => Auth::id(),
            'title'     => $file->getClientOriginalName(),
            'file_path' => $path,
            'thumbnail' => $thumbPath,
            'size'      => $file->getSize(),
            'status'    => 'ready',
        ]);

        // Optionally dispatch a job for thumbnail/transcode here:
        // ProcessVideoJob::dispatch($video);

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded successfully.',
            'video'   => $video,
        ], 201);
    }
    public function uploadChunk(Request $request)
    {
        $request->validate([
            'chunk' => 'required|file',
            'fileName' => 'required|string',
            'start' => 'required|integer',
            'totalSize' => 'required|integer',
        ]);

        $videoId = $request->input('videoId');

        if (!$videoId) {
            $video = Video::create([
                'user_id' => auth()->id(),
                'title'   => $request->fileName,
                'file_path' => "videos/" . uniqid(),
                'size'    => $request->totalSize,
                'status'  => 'processing',
            ]);
            $videoId = $video->id;
        } else {
            $video = Video::findOrFail($videoId);
        }

        $chunk = $request->file('chunk');

        // ✅ Save to PRIVATE disk (not public)
        $storagePath = storage_path('app/private/' . $video->file_path);

        // Ensure the folder exists
        if (!is_dir(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0775, true);
        }

        $out = fopen($storagePath, $request->start == 0 ? "wb" : "ab");
        $in = fopen($chunk->getRealPath(), "rb");

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        fclose($in);
        fclose($out);

        if ($request->start + $chunk->getSize() >= $request->totalSize) {
            $video->status = "ready";
            $video->save();
        }

        return response()->json(['videoId' => $videoId]);
    }

    public function storeThumbnail(Request $request, Video $video)
    {
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $thumbPath = $request->file('thumbnail')->store('thumbnails', 'public');

        $video->thumbnail = $thumbPath;
        $video->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Delete physical file if exists
        if (Storage::disk('local')->exists($video->file_path)) {
            Storage::disk('local')->delete($video->file_path);
        }

        $video->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Stream video with HTTP Range support so browser can seek.
     */
    public function stream(Video $video, Request $request)
    {
        // Ownership check
        if ($video->user_id !== Auth::id()) {
            abort(403);
        }

        $fullPath = storage_path('app/private/' . $video->file_path);
        if (!file_exists($fullPath)) {
            abort(404);
        }

        $size = filesize($fullPath);
        $mime = mime_content_type($fullPath) ?: 'application/octet-stream';
        $headers = [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'private, max-age=3600',
        ];
        // Handle Range header for seeking
        if ($request->headers->has('range')) {
            $range = $request->header('range');
            if (preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
                $start = intval($matches[1]);
                $end = ($matches[2] !== '') ? intval($matches[2]) : ($size - 1);
                if ($end >= $size) $end = $size - 1;
                if ($start > $end) abort(416);

                $length = $end - $start + 1;

                $stream = function () use ($fullPath, $start, $length) {
                    $fh = fopen($fullPath, 'rb');
                    fseek($fh, $start);
                    $buffer = 1024 * 8;
                    $bytesSent = 0;
                    while (!feof($fh) && $bytesSent < $length) {
                        $read = min($buffer, $length - $bytesSent);
                        echo fread($fh, $read);
                        $bytesSent += $read;
                        flush();
                    }
                    fclose($fh);
                };

                return response()->stream($stream, 206, array_merge($headers, [
                    'Content-Range' => "bytes {$start}-{$end}/{$size}",
                    'Content-Length' => $length,
                ]));
            }
        }

        // No range header — send full file
        return response()->file($fullPath, $headers);
    }
}
