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

        .video-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* crop to fill without distortion */
            display: block;
        }

        .play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border: none;
            font-size: 36px;
            border-radius: 50%;
            width: 64px;
            height: 64px;
            cursor: pointer;
        }

        .video-thumbnail-wrapper {
            position: relative;
            cursor: pointer;
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            overflow: hidden;
        }

        .d-none {
            display: none !important;
        }


        /* --- Upload Area --- */
        .upload-area {
            border: 2px dashed #ccc;
            padding: 24px;
            text-align: center;
            border-radius: 12px;
            background: #fafafa;
            transition: border-color .3s, background .3s;
            cursor: pointer;
        }

        .upload-area.dragover {
            border-color: #4f46e5;
            /* Indigo glow on drag */
            background: #eef2ff;
        }

        /* --- Error Message --- */
        .upload-error {
            margin-top: 12px;
            font-size: 14px;
            color: #dc2626;
            /* red-600 */
            background: #fee2e2;
            padding: 8px 12px;
            border-radius: 8px;
            display: none;
            /* JS toggles it */
            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* --- Progress Bar --- */
        .progress-wrap {
            margin-top: 16px;
            display: none;
            /* JS toggles it */
        }

        .progress-bar-bg {
            background: #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            height: 14px;
        }

        .progress-bar-fill {
            background: linear-gradient(90deg, #6366f1, #4f46e5);
            width: 0%;
            height: 100%;
            transition: width .3s ease;
        }

        .progress-text {
            font-size: 13px;
            margin-top: 6px;
            text-align: right;
            color: #374151;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-3px);
            }

            50% {
                transform: translateX(3px);
            }

            75% {
                transform: translateX(-3px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .shake {
            animation: shake 0.3s;
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
            if(tab=='videos'){
                loadVideos()
            }
        }
    </script>
@endpush
