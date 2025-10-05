@props(['video'])
<div class="video-card">
    <div class="video-thumbnail-wrapper" data-video-id="{{ $video->id }}">
        <img class="video-thumb"
             src="{{ asset('storage/'.$video->thumbnail) }}"
             alt="{{ $video->title }}">
        <button class="play-btn">
            ▶
        </button>
    </div>

    <div class="video-player d-none" id="player-{{ $video->id }}">
        <video class="plyr__video-embed" playsinline preload="metadata">
            <source src="{{ route('videos.stream', $video->id) }}" type="video/mp4" />
        </video>
    </div>

    <div class="video-details">
        <div class="video-title">{{ $video->title }}</div>
        <div class="video-meta">
           <div> 👁 0 views</div>
           <div> 📅 {{ $video->created_at->format('m/d/Y') }}</div>
            <div> 💾 {{ number_format($video->size / 1048576, 2) }} MB</div>
        </div>
    </div>
</div>
