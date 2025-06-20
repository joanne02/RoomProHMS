@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Announcement';
@endphp
<div class="page-content">

    {{-- <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Forms</a></li>
            <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
        </ol>
    </nav> --}}

    {{Breadcrumbs::render('add_announcement')}}

    <div class="row">
        
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Add Announcement</h6>

                    <form method="POST" action="{{ route('storeannouncement') }}" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        <div class="row mb-3">
                            <label for="announcementTitle" class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('announcement_title') is-invalid @enderror" id="announcementTitle" name="announcement_title" placeholder="Title">
                                @error('announcement_title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="announcementDescription" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('announcement_description') is-invalid @enderror" id="announcementDescription" rows="3" name="announcement_description" placeholder="Description"></textarea>
                                @error('announcement_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Schedule Checkbox -->
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-3 col-form-label">Schedule</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="scheduleCheckbox">
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
                                <input type="datetime-local" class="form-control" id="scheduledAt" name="scheduled_at">
                            </div>
                        </div>

                        <!-- Hidden input for announcement_status -->
                        <input type="hidden" name="announcement_status" id="announcementStatus" value="published">

                        
                        <!-- Hidden time settings field initially -->
                        
                            {{-- <div id="scheduledAtField" class="row mb-3 d-none">
                                <label for="scheduledAt" class="col-sm-3 col-form-label">Scheduled Time</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" class="form-control" id="scheduledAt" name="scheduled_at">
                                </div>
                            </div> --}}
                        

                        <div class="row mb-3">
                            <label for="announcementAttachment" class="col-sm-3 col-form-label">Attachment</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" id="announcementAttachment" name="announcement_attachment[]" multiple accept="image/*">
                            </div>
                        </div>    
                        <div class='d-flex justify-content-end gap-2'>
                            <button type="button" class="btn btn-light" id="saveDraftBtn">Save as Draft</button>
                            <button type="submit" class="btn btn-primary">Publish</button>
                            <a href="{{ route('mainannouncement') }}" class="btn btn-secondary">Cancel</a>
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
</script>

@endsection
