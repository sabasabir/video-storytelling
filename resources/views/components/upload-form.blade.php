{{-- resources/views/components/upload-form.blade.php --}}
@props(['uploadUrl' => route('videos.store'), 'maxMb' => 100])

<div class="upload-component">
    <div id="upload-area" class="upload-area">
        <p class="mb-2">Drag & drop your video here or</p>
        <input type="file" id="component-file-input" accept="video/*" style="display:none" />
        <label for="component-file-input" class="btn">Browse Files</label>

        <div id="upload-error" class="text-danger mt-2" style="display:none;"></div>

        <div id="upload-progress-wrap" style="display:none; max-width:480px; margin:auto;">
            <div style="background:#f3f4f6;border-radius:8px;overflow:hidden;height:12px;">
                <div id="upload-progress" style="width:0%;height:12px;border-radius:8px;"></div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;">
                <div id="upload-progress-text" style="font-size:13px;">0%</div>
                <div id="upload-spinner" style="display:none;"><span class="spinner"></span></div>
            </div>
        </div>
    </div>
    {{-- store attributes for JS --}}
    <input type="hidden" id="component-upload-url" value="{{ $uploadUrl }}">
    <input type="hidden" id="component-max-bytes" value="{{ intval($maxMb) * 1024 * 1024 }}">
</div>
