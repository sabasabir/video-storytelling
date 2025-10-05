<div id="video-list" class="row">
    @forelse($videos as $video)
        <div class="col-md-3">
            <x-video-card :video="$video" />
        </div>
    @empty
        <div class="col-12 text-center text-muted py-4">
            No videos uploaded yet.
        </div>
    @endforelse
</div>
@push('scripts')
    <script>
        async function loadVideos() {
            try {
                const res = await fetch('{{ route('dashboard') }}', {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });
                if (!res.ok) return;
                const html = await res.text();
                const list = document.getElementById('video-list');
                if (list) {
                    list.innerHTML = html;
                    initVideoCards(); // 👈 add this so new cards get bound
                }
            } catch (e) {
                console.error(e);
            }
        }
        // deleteVideo & menu helpers (global functions used in components)
        window.deleteVideo = async function(id) {
            if (!confirm('Delete this video?')) return;
            try {
                const res = await fetch(`/videos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                if (res.ok) loadVideos();
                else alert('Delete failed.');
            } catch (e) {
                console.error(e);
                alert('Delete failed.');
            }
        };
        window.toggleMenu = function(btn) {
            const menu = btn.nextElementSibling;
            document.querySelectorAll('.menu-options').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });
            menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        };


        // === Video thumbnail → play → pause others ===
        const activePlayers = [];

        function pauseAllExcept(current) {
            activePlayers.forEach(p => {
                if (p !== current) p.pause();
            });
        }

        function initVideoCards() {
            document.querySelectorAll('.video-thumbnail-wrapper').forEach(wrapper => {
                // avoid double binding when loadVideos() refreshes HTML
                if (wrapper.dataset.bound) return;
                wrapper.dataset.bound = 'true';

                wrapper.addEventListener('click', () => {
                    const id = wrapper.dataset.videoId;
                    const playerWrap = document.getElementById(`player-${id}`);
                    wrapper.classList.add('d-none');
                    playerWrap.classList.remove('d-none');

                    const player = new Plyr(playerWrap.querySelector('video'), {
                        controls: ['play', 'progress', 'current-time', 'mute', 'volume',
                            'fullscreen'
                        ]
                    });

                    activePlayers.push(player);
                    player.play();
                    player.on('play', () => pauseAllExcept(player));
                });
            });
        }

        // initial load + polling
        document.addEventListener('DOMContentLoaded', function() {
            loadVideos();
            initVideoCards();
            setInterval(loadVideos, 10000000); // polling - adjust if needed
        });
    </script>
@endpush
