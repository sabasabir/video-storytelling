<!-- Main Dashboard -->
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<main>
    <h1 class="dashboard-title">Dashboard</h1>
    <p class="dashboard-subtitle">Manage your videos and track performance</p>

    <!-- Tabs -->
    <div class="dashboard-tabs">
        <div class="tabs">
            <div class="tab active" onclick="switchTab('videos')">Videos</div>
            <div class="tab" onclick="switchTab('upload')">Upload</div>
        </div>
    </div>

    <!-- Videos Section -->
    <section class="section-tabs active" id="videos">
        <h2 class="section-title">My Videos</h2>
        <p>4 videos total</p>

        <div class="video-grid">
            <!-- Video Card Example -->
            <div class="video-card">
                <div class="video-thumbnail">
                    <div class="status ready">Ready</div>
                    <div class="video-duration">5:42</div>
                    <button class="menu-btn" onclick="toggleMenu(this)">⋮</button>
                    <div class="menu-options">
                        <button>Share</button>
                        <button>Download</button>
                        <button>Delete</button>
                    </div>
                </div>
                <div class="video-details">
                    <div class="video-title">Product Demo Video</div>
                    <div class="video-meta">
                        <span>👁 1.2K views</span>
                        <span>📅 1/15/2024</span>
                        <span>💾 245 MB</span>
                    </div>
                </div>
            </div>

            <div class="video-card">
                <div class="video-thumbnail">
                    <div class="status ready">Ready</div>
                    <div class="video-duration">5:42</div>
                    <button class="menu-btn" onclick="toggleMenu(this)">⋮</button>
                    <div class="menu-options">
                        <button>Share</button>
                        <button>Download</button>
                        <button>Delete</button>
                    </div>
                </div>
                <div class="video-details">
                    <div class="video-title">Product Demo Video</div>
                    <div class="video-meta">
                        <span>👁 1.2K views</span>
                        <span>📅 1/15/2024</span>
                        <span>💾 245 MB</span>
                    </div>
                </div>
            </div>

            <div class="video-card">
                <div class="video-thumbnail">
                    <div class="status ready">Ready</div>
                    <div class="video-duration">5:42</div>
                    <button class="menu-btn" onclick="toggleMenu(this)">⋮</button>
                    <div class="menu-options">
                        <button>Share</button>
                        <button>Download</button>
                        <button>Delete</button>
                    </div>
                </div>
                <div class="video-details">
                    <div class="video-title">Product Demo Video</div>
                    <div class="video-meta">
                        <span>👁 1.2K views</span>
                        <span>📅 1/15/2024</span>
                        <span>💾 245 MB</span>
                    </div>
                </div>
            </div>

            <div class="video-card">
                <div class="video-thumbnail">
                    <div class="status ready">Ready</div>
                    <div class="video-duration">5:42</div>
                    <button class="menu-btn" onclick="toggleMenu(this)">⋮</button>
                    <div class="menu-options">
                        <button>Share</button>
                        <button>Download</button>
                        <button>Delete</button>
                    </div>
                </div>
                <div class="video-details">
                    <div class="video-title">Product Demo Video</div>
                    <div class="video-meta">
                        <span>👁 1.2K views</span>
                        <span>📅 1/15/2024</span>
                        <span>💾 245 MB</span>
                    </div>
                </div>
            </div>

            <!-- More video cards can be copied here... -->
        </div>
    </section>

    <!-- Upload Section -->
    <section class="section-tabs" id="upload">
        <h2 class="section-title">Upload Video</h2>
        <div class="upload-area" id="upload-area">
            <p>Drag & drop your video here</p>
            <input type="file" id="file-input" accept="video/*" />
            <label for="file-input">Browse Files</label>
        </div>
    </section>
    @endsection
    @push('scripts')
        <script>
            // Tab Switching
            function switchTab(tab) {
                document
                    .querySelectorAll(".tab")
                    .forEach((el) => el.classList.remove("active"));
                document
                    .querySelectorAll(".section-tabs")
                    .forEach((el) => el.classList.remove("active"));
                document
                    .querySelector(`.tab[onclick="switchTab('${tab}')"]`)
                    .classList.add("active");
                document.getElementById(tab).classList.add("active");
            }

            // Menu toggle
            function toggleMenu(btn) {
                const menu = btn.nextElementSibling;
                document.querySelectorAll(".menu-options").forEach((m) => {
                    if (m !== menu) m.style.display = "none";
                });
                menu.style.display = menu.style.display === "flex" ? "none" : "flex";
            }

            // Close menus on outside click
            document.addEventListener("click", (e) => {
                if (!e.target.closest(".menu-btn")) {
                    document
                        .querySelectorAll(".menu-options")
                        .forEach((m) => (m.style.display = "none"));
                }
            });

            // Upload drag-drop
            const uploadArea = document.getElementById("upload-area");
            uploadArea.addEventListener("dragover", (e) => {
                e.preventDefault();
                uploadArea.classList.add("dragover");
            });
            uploadArea.addEventListener("dragleave", () => {
                uploadArea.classList.remove("dragover");
            });
            uploadArea.addEventListener("drop", (e) => {
                e.preventDefault();
                uploadArea.classList.remove("dragover");
                alert(`Uploaded file: ${e.dataTransfer.files[0].name}`);
            });

            document.getElementById("file-input").addEventListener("change", (e) => {
                alert(`Uploaded file: ${e.target.files[0].name}`);
            });
        </script>
    @endpush
