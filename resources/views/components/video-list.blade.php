<div id="video-list" class="row">
    @forelse($videos as $video)
        <div class="col-md-4">
            <x-video-card :video="$video" />
        </div>
    @empty
        <div class="col-12 text-center text-muted py-4">
            No videos uploaded yet.
        </div>
    @endforelse
</div>
