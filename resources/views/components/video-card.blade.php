<div class="video-card">
    <div class="video-thumbnail">
        <div class="status {{ $video->status }}">{{ ucfirst($video->status) }}</div>
        
        <video width="100%" controls>
            <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <button class="menu-btn" onclick="toggleMenu(this)">⋮</button>
        <div class="menu-options">
            <button onclick="deleteVideo({{ $video->id }})">Delete</button>
        </div>
    </div>

    <div class="video-details">
        <div class="video-title">{{ $video->title }}</div>
        <div class="video-meta">
            <span>📅 {{ $video->created_at->format('M d, Y') }}</span>
            <span>💾 {{ number_format($video->size / 1048576, 2) }} MB</span>
        </div>
    </div>
</div>
