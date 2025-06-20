@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Announcement';
@endphp
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="page-content">

    {{-- <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Forms</a></li>
            <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
        </ol>
    </nav> --}}

    {{Breadcrumbs::render('edit_announcement', $announcement->id)}}

    <div class="row">
        
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Edit Announcement</h6>

                    <form method="POST" action="{{ route('updateannouncement', $announcement->id) }}" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        <div class="row mb-3">
                            <label for="announcementTitle" class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('announcement_title') is-invalid @enderror" id="announcementTitle" name="announcement_title" placeholder="Title" value="{{ old('announcement_title', $announcement->title)}}">
                                @error('announcement_title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="announcementDescription" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('announcement_description') is-invalid @enderror" id="announcementDescription" rows="3" name="announcement_description" placeholder="Description">{{ old('announcement_description', $announcement->description ?? '')}}</textarea>
                                @error('announcement_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        @php
                            $status = old('announcement_status', $announcement->status ?? null);
                        @endphp

                        {{-- <div class="row mb-3">
                            <label for="announcementStatus" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="announcementStatus" name="announcement_status">
                                    <option disabled {{ $status ? '' : 'selected' }}>Status</option>
                                    <option value= "draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $status == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="scheduled" {{ $status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="archived" {{ $status == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                        </div> --}}

                        
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-3 col-form-label">Schedule</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <!-- Check if there's a scheduled time in the previous data -->
                                    <input class="form-check-input" type="checkbox" id="scheduleCheckbox" {{ $announcement->scheduled_at ? 'checked' : '' }}>
                                    <label class="form-check-label" for="scheduleCheckbox">
                                        Schedule this announcement
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Scheduled Time -->
                        <div id="scheduledAtField" class="row mb-3 d-none">
                            <label for="scheduledAt" class="col-sm-3 col-form-label">Scheduled Time</label>
                            <div class="col-sm-9">
                                <!-- If there's a scheduled time, pre-fill the input field -->
                                <input type="datetime-local" class="form-control" id="scheduledAt" name="scheduled_at" value="{{ $announcement->scheduled_at ? \Carbon\Carbon::parse($announcement->scheduled_at)->format('Y-m-d\TH:i') : '' }}">
                            </div>
                        </div>
                        
                                                <!-- Hidden input for announcement_status -->
                                                <input type="hidden" name="announcement_status" id="announcementStatus" value="published">
                        
                            
                                <!-- Attachments input -->
                                <div class="row mb-3">
                                    <label for="announcementAttachment" class="col-sm-3 col-form-label">New Attachment</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" id="announcementAttachment" name="announcement_attachment[]" multiple accept="image/*">
                                    </div>
                                </div>
                            
                                @if ($announcement->attachment)
                                    @php
                                        $attachments = json_decode($announcement->attachment, true);
                                    @endphp
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label">Attachments</label>
                                        <div class="col-sm-9">
                                            <div class="d-flex flex-wrap gap-3">
                                                @foreach($attachments as $index => $attachment)
                                                    <div class="position-relative border rounded p-2 shadow-sm" style="width: 120px;">
                                                        <!-- Dropdown icon -->
                                                        <div class="position-absolute top-0 end-0 m-1 dropdown">
                                                            <a class="text-light" href="#" role="button" id="dropdownMenu{{ $index }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i> <!-- Bootstrap Icons required -->
                                                            </a>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $index }}">
                                                                <li>
                                                                    <label class="dropdown-item m-0">
                                                                        <input type="checkbox" name="remove_attachments[]" value="{{ $attachment }}" class="form-check-input me-2">
                                                                        Remove
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <!-- Image -->
                                                        <img src="{{ asset('storage/' . $attachment) }}" alt="Attachment"
                                                            class="img-thumbnail mb-2"
                                                            style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;"
                                                            data-bs-toggle="modal" data-bs-target="#imageModal{{ $index }}">
                                                    </div>

                                                    <!-- Modal for enlarged view -->
                                                    <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1"
                                                        aria-labelledby="imageModalLabel{{ $index }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-0">
                                                                    <img src="{{ asset('storage/' . $attachment) }}" class="img-fluid w-100" alt="Expanded Image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                 
                                <div class='d-flex justify-content-end gap-2'>
                                    @if ($announcement->status !== 'published' && $announcement->status !== 'archived')
                                        <button type="button" class="btn btn-secondary" id="saveDraftBtn">Save as Draft</button>
                                    @endif
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('mainannouncement') }}" class="btn btn-light">Cancel</a>
                                </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scheduleCheckbox = document.getElementById('scheduleCheckbox');
        const scheduledAtField = document.getElementById('scheduledAtField');
        const scheduledAtInput = document.getElementById('scheduledAt');
        const statusInput = document.getElementById('announcementStatus');
        const saveDraftBtn = document.getElementById('saveDraftBtn');
        const form = document.querySelector('.forms-sample');

        // Toggle datetime input visibility
        scheduleCheckbox.addEventListener('change', function () {
            scheduledAtField.classList.toggle('d-none', !scheduleCheckbox.checked);
        });

        // Handle Save as Draft
        saveDraftBtn.addEventListener('click', function () {
            statusInput.value = 'draft';
            form.submit();
        });

        // Handle normal submit (set status based on checkbox and datetime)
        form.addEventListener('submit', function (e) {
            if (statusInput.value !== 'draft') {
                if (scheduleCheckbox.checked && scheduledAtInput.value) {
                    statusInput.value = 'scheduled';
                } else {
                    statusInput.value = 'published';
                }
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
    const scheduleCheckbox = document.getElementById('scheduleCheckbox');
    const scheduledAtField = document.getElementById('scheduledAtField');
    const scheduledAtInput = document.getElementById('scheduledAt');

    // If checkbox was checked previously, show the scheduled time input field
    if (scheduleCheckbox.checked) {
        scheduledAtField.classList.remove('d-none');
    }

    // Toggle datetime input visibility
    scheduleCheckbox.addEventListener('change', function () {
        scheduledAtField.classList.toggle('d-none', !scheduleCheckbox.checked);
    });
    });

</script>
@endsection
