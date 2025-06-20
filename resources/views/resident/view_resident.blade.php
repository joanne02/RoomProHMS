@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Resident';
@endphp
<style>
.profile-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto; /* Centers the container horizontally */
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #ccc;
    background-color: #f5f5f5; /* Optional background color */
}


.edit-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background-color: #fff;
    border-radius: 50%;
    width: 32px;       /* Equal width and height */
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: 1px solid #ccc;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
}

.edit-icon i {
    font-size: 14px;
    color: #333;
}

input[type="file"]#residentImage {
    display: none;
}
</style>

<div class="page-content">
    <div class="row">
        {{Breadcrumbs::render('view_resident', $resident->semester_id)}}
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Resident Detail</h6>

                    <div class="mb-3">
                        <label class="form-label">Profile Image</label><br>

                        <div class="profile-container">
                            <img id="profilePreview"
                                src="{{ $resident->image ? asset('storage/' . $resident->image) : asset('assets/images/others/placeholder.jpg') }}"
                                alt="Resident Image"
                                class="profile-image">
                            <input type="file" id="residentImage" name="resident_image" accept="image/*">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ $resident->name }}" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Student ID</label>
                            <input type="text" class="form-control" 
                                value="{{ $resident->student_id}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ $resident->email }}" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Gender</label>
                            <input type="text" class="form-control" value="{{ ucfirst($resident->gender) ??  '' }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="3" readonly>{{ $resident->address }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Room</label>
                            <input type="text" class="form-control"
                                value="{{ $resident->room->name ?? '' }} (Block {{ $resident->room->block ?? '' }}, Floor {{ $resident->room->floor ?? '' }})"
                                readonly>
                        </div>
                        {{-- <div class="col-sm-6 mb-3">
                            <label class="form-label">Semester/Year</label>
                            <input type="text" class="form-control" value="{{ $resident->semester->name ?? '' }}" readonly>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Faculty</label>
                            <input type="text" class="form-control" value="{{ $resident->faculty }}" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Program</label>
                            <input type="text" class="form-control" value="{{ $resident->program }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Year of Study</label>
                            <input type="text" class="form-control" value="{{ $resident->year_of_study }}" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Contact No</label>
                            <input type="text" class="form-control" value="{{ $resident->contact_no }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Check In</label>
                            <input type="text" class="form-control" value="{{ $resident->check_in }}" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Check Out</label>
                            <input type="text" class="form-control" value="{{ $resident->check_out }}" readonly>
                        </div>
                    </div>

                    {{-- @if($resident->image)
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label><br>
                        <img src="{{ asset('storage/' . $resident->image) }}" alt="Resident Image" width="150" class="img-thumbnail">
                    </div>
                    @endif --}}

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('mainresident', ['id' => $resident->semester_id]) }}" class="btn btn-secondary">Back</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('residentImage').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush

@endsection
