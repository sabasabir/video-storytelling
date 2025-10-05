{{-- resources/views/components/upload-form.blade.php --}}
@props(['uploadUrl' => route('videos.chunks'), 'maxMb' => 100])

<div class="upload-component">
    <div id="upload-area" class="upload-area">
        <p class="mb-2">Drag & drop your video here or</p>
        <input type="file" id="component-file-input" accept="video/*" style="display:none" />
        <div class="col-md-4 offset-md-4">
            <label for="component-file-input" class="btn btn-primary">Browse Files</label>

            <div id="upload-error" class="upload-error"></div>

            <div id="upload-progress-wrap" class="progress-wrap">
                <div class="progress-bar-bg">
                    <div id="upload-progress" class="progress-bar-fill"></div>
                </div>
                <div id="upload-progress-text" class="progress-text">0%</div>
            </div>
        </div>
    </div>
    <input type="hidden" id="component-upload-url" value="{{ $uploadUrl }}">
    <input type="hidden" id="component-max-bytes" value="{{ intval($maxMb) * 1024 * 1024 }}">
</div>
@push('scripts')
    <script>
        (function() {
            const ALLOWED = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv'];
            const CHUNK_SIZE = 5 * 1024 * 1024; // 5MB

            function $(sel) {
                return document.querySelector(sel);
            }

            const fileInput = $('#component-file-input');
            const uploadArea = $('#upload-area');
            const progressBar = $('#upload-progress');
            const progressText = $('#upload-progress-text');
            const errorEl = $('#upload-error');
            const progressWrap = $('#upload-progress-wrap');
            const uploadUrl = $('#component-upload-url')?.value || '/videos/chunks';

            function showProgress() {
                if (!progressWrap) return;
                progressWrap.style.display = 'block';
                progressBar.style.width = '0%';
                progressText.innerText = '0%';
            }

            function updateProgress(p) {
                progressBar.style.width = p + '%';
                progressText.innerText = p + '%';
            }

            function hideProgress() {
                if (!progressWrap) return;
                setTimeout(() => progressWrap.style.display = 'none', 600);
            }

            function showError(msg) {
                if (!errorEl) return;
                errorEl.style.display = 'block';
                errorEl.innerText = msg;
                errorEl.classList.add('shake');
                setTimeout(() => errorEl.classList.remove('shake'), 500);
            }

            function clearError() {
                if (!errorEl) return;
                errorEl.style.display = 'none';
                errorEl.innerText = '';
            }
            async function uploadFileInChunks(file) {
                if (!ALLOWED.includes(file.type)) {
                    alert('Invalid file type.');
                    return;
                }

                showProgress();

                let uploadedBytes = 0;
                let videoId = null;

                for (let start = 0; start < file.size; start += CHUNK_SIZE) {
                    const chunk = file.slice(start, start + CHUNK_SIZE);
                    const fd = new FormData();
                    fd.append('chunk', chunk);
                    fd.append('fileName', file.name);
                    fd.append('start', start);
                    fd.append('totalSize', file.size);
                    if (videoId) fd.append('videoId', videoId);

                    const res = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: fd
                    });
                    const data = await res.json();
                    videoId = data.videoId;

                    uploadedBytes += chunk.size;
                    updateProgress(Math.round((uploadedBytes / file.size) * 100));
                }

                // ✅ Thumbnail after chunks uploaded
                try {
                    const thumbBlob = await generateThumbnailBlob(file);
                    const fdThumb = new FormData();
                    fdThumb.append('thumbnail', thumbBlob, 'thumb.jpg');

                    await fetch(`/videos/${videoId}/thumbnail`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: fdThumb
                    });
                } catch (err) {
                    console.warn('Thumbnail skipped:', err.message);
                }

                hideProgress();
                alert("Upload complete ❤️");
            }

            // file input
            if (fileInput) {
                fileInput.addEventListener('change', e => {
                    const f = e.target.files[0];
                    uploadFileInChunks(f);
                    e.target.value = '';
                });
            }

            // drag & drop
            if (uploadArea) {
                uploadArea.addEventListener('drop', e => {
                    e.preventDefault();
                    const f = e.dataTransfer.files[0];
                    uploadFileInChunks(f);
                });
            }
            async function generateThumbnailBlob(file) {
                return new Promise((resolve, reject) => {
                    const video = document.createElement('video');
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    video.preload = 'metadata';
                    video.src = URL.createObjectURL(file);
                    video.muted = true;
                    video.playsInline = true;
                    video.currentTime = 1;

                    video.onloadeddata = () => {
                        canvas.width = video.videoWidth / 2;
                        canvas.height = video.videoHeight / 2;
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        canvas.toBlob(
                            (blob) => blob ? resolve(blob) : reject(new Error(
                                'Thumbnail generation failed.')),
                            'image/jpeg',
                            0.8
                        );
                    };

                    video.onerror = () => reject(new Error('Cannot load video for thumbnail.'));
                });
            }
        })();
    </script>
@endpush
