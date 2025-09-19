@extends('layouts.master')
@section('title', 'Dashboard')
@push('style')
    <style>
        /* Dashboard Page */
        .dashboard-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .dashboard-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        /* Tabs */
        .dashboard-tabs .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .dashboard-tabs .tab {
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            background: #f8f9fa;
            transition: all 0.2s ease;
        }

        .dashboard-tabs .tab:hover {
            background: #e9ecef;
        }

        .dashboard-tabs .tab.active {
            background: #0d6efd;
            color: #fff;
        }

        /* Sections */
        .section-tabs {
            display: none;
        }

        .section-tabs.active {
            display: block;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Video Card */
        .video-card {
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .video-thumbnail {
            position: relative;
            width: 100%;
        }

        /* Fix video height issue */
        .video-thumbnail video {
            width: 100%;
            height: 200px;
            /* 👈 fixed max height */
            object-fit: cover;
            /* 👈 crop/scale video without stretching */
            display: block;
        }

        .video-details {
            padding: .75rem;
            background: #f8f9fa;
        }



        .status {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #fff;
        }

        .status.processing {
            background: #ffc107;
            /* Yellow */
        }

        .status.completed {
            background: #28a745;
            /* Green */
        }

        .status.failed {
            background: #dc3545;
            /* Red */
        }

        /* Menu button */
        .menu-btn {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            border: none;
            background: transparent;
            font-size: 1.25rem;
            cursor: pointer;
            color: #495057;
        }

        .menu-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            border: none;
            background: rgba(255, 255, 255, 0.8);
            /* 👈 add a faint bg */
            font-size: 1.5rem;
            cursor: pointer;
            border-radius: 20%;
            padding: 2px 6px;
            line-height: 1;
        }

        .menu-options button {
            padding: 0.5rem 1rem;
            border: none;
            background: transparent;
            text-align: left;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .menu-options button:hover {
            background: #f8f9fa;
        }

        /* Video Details */
        .video-details {
            padding: 2rem 1rem;
        }

        .video-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .video-meta {
            font-size: 0.875rem;
            color: #6c757d;
            display: flex;
            justify-content: space-between;
        }
    </style>
@endpush
@section('content')


    <!-- Dashboard Header -->
    <div class="mb-4 text-center">
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Manage your videos and track performance</p>
    </div>

    <!-- Tabs -->
    <div class="dashboard-tabs mb-4">
        <div class="tabs justify-content-center">
            <div class="tab active" onclick="switchTab('videos')">Videos</div>
            <div class="tab" onclick="switchTab('upload')">Upload</div>
        </div>
    </div>

    <!-- Videos Section -->
    <section class="section-tabs active" id="videos">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title">My Videos</h2>
            <span class="badge bg-secondary">
                {{ count($videos ?? []) }} {{ Str::plural('Video', count($videos ?? [])) }}
            </span>
        </div>

        {{-- Video list component --}}
        @include('components.video-list', ['videos' => $videos ?? []])
    </section>

    <!-- Upload Section -->
    <section class="section-tabs" id="upload">
        <h2 class="section-title mb-3">Upload Video</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Upload form component --}}
                <x-upload-form :maxMb="100" />
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function switchTab(tab) {
            // remove active class from all tabs
            document.querySelectorAll(".tab").forEach((el) => el.classList.remove("active"));
            document.querySelectorAll(".section-tabs").forEach((el) => el.classList.remove("active"));

            // set active on clicked tab + related section
            document.querySelector(`.tab[onclick="switchTab('${tab}')"]`).classList.add("active");
            document.getElementById(tab).classList.add("active");
        }
        (function() {
            // Allowed mime list - adjust if you want more
            const ALLOWED = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv'];

            // Helpers
            function $(sel) {
                return document.querySelector(sel);
            }

            function $all(sel) {
                return Array.from(document.querySelectorAll(sel));
            }

            // Elements
            const fileInput = $('#component-file-input');
            const uploadArea = $('#upload-area');
            const errorEl = $('#upload-error');
            const progressWrap = $('#upload-progress-wrap');
            const progressBar = $('#upload-progress');
            const progressText = $('#upload-progress-text');
            const spinner = $('#upload-spinner');
            const uploadUrl = $('#component-upload-url')?.value || '/videos';
            const maxBytes = parseInt($('#component-max-bytes')?.value || (100 * 1024 * 1024), 10);

            function showError(msg) {
                if (!errorEl) return;
                errorEl.style.display = 'block';
                errorEl.innerText = msg;
            }

            function clearError() {
                if (!errorEl) return;
                errorEl.style.display = 'none';
                errorEl.innerText = '';
            }

            function showProgress() {
                if (!progressWrap) return;
                progressWrap.style.display = 'block';
                progressBar.style.width = '0%';
                progressText.innerText = '0%';
                if (spinner) spinner.style.display = 'inline-block';
            }

            function hideProgress() {
                if (!progressWrap) return;
                if (spinner) spinner.style.display = 'none';
                setTimeout(() => progressWrap.style.display = 'none', 600);
            }

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
                    if (list) list.innerHTML = html;
                } catch (e) {
                    console.error(e);
                }
            }

            function uploadFile(file) {
                clearError();
                if (!file) return;
                if (!ALLOWED.includes(file.type)) {
                    showError('Invalid file type. Allowed: mp4, mov, avi, wmv.');
                    return;
                }
                if (file.size > maxBytes) {
                    showError('File too large. Max: ' + Math.round(maxBytes / 1024 / 1024) + ' MB');
                    return;
                }

                showProgress();

                const fd = new FormData();
                fd.append('video', file);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', uploadUrl, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.upload.addEventListener('progress', e => {
                    if (e.lengthComputable) {
                        const p = Math.round((e.loaded / e.total) * 100);
                        progressBar.style.width = p + '%';
                        progressText.innerText = p + '%';
                    }
                });

                xhr.addEventListener('load', e => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        progressBar.style.width = '100%';
                        progressText.innerText = '100%';
                        setTimeout(() => {
                            hideProgress();
                            loadVideos();
                            showToast('Upload complete — good job ❤️');
                        }, 600);
                    } else {
                        let msg = 'Upload failed. Try again.';
                        try {
                            const json = JSON.parse(xhr.responseText);
                            if (json && json.message) msg = json.message;
                            if (json && json.errors) {
                                const first = Object.values(json.errors)[0];
                                if (first && first[0]) msg = first[0];
                            }
                        } catch (e) {}
                        showError(msg);
                        hideProgress();
                    }
                });

                xhr.addEventListener('error', () => {
                    showError('Network error during upload.');
                    hideProgress();
                });

                xhr.send(fd);
            }

            // wire up file input
            if (fileInput) {
                fileInput.addEventListener('change', e => {
                    const f = e.target.files[0];
                    uploadFile(f);
                    e.target.value = ''; // reset so same file can be picked again
                });
            }

            // drag & drop
            if (uploadArea) {
                uploadArea.addEventListener('dragover', e => {
                    e.preventDefault();
                    uploadArea.classList.add('dragover');
                });
                uploadArea.addEventListener('dragleave', e => {
                    uploadArea.classList.remove('dragover');
                });
                uploadArea.addEventListener('drop', e => {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');
                    const f = e.dataTransfer.files[0];
                    uploadFile(f);
                });
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

            // toast quick function (small)
            function showToast(msg, timeout = 3000) {
                const root = document.getElementById('toast-root') || (function() {
                    const r = document.createElement('div');
                    r.id = 'toast-root';
                    document.body.appendChild(r);
                    return r;
                })();
                const t = document.createElement('div');
                t.className = 'toast';
                t.style.marginBottom = '8px';
                t.style.padding = '10px 14px';
                t.style.borderRadius = '8px';
                t.style.background = 'rgba(17,24,39,0.95)';
                t.style.color = '#fff';
                t.style.boxShadow = '0 8px 24px rgba(15,23,42,0.35)';
                t.innerText = msg;
                root.appendChild(t);
                setTimeout(() => t.style.opacity = '0.95', 10);
                setTimeout(() => {
                    t.style.opacity = '0';
                    setTimeout(() => root.removeChild(t), 260);
                }, timeout);
            }

            // initial load + polling
            document.addEventListener('DOMContentLoaded', function() {
                loadVideos();
                setInterval(loadVideos, 10000000); // polling - adjust if needed
            });

        })();
    </script>
@endpush
