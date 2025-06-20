@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Resident'
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
        border-radius: 50%; /* Makes the image circular */
        border: 2px solid #ccc;
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

    {{ Breadcrumbs::render('edit_resident', $semester->id, $resident->id) }}
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Resident</h6>

                    <form method="POST" action="{{ route('updateresident', $resident->id) }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label><br>
                            <div class="profile-container">
                                <img id="profilePreview"
                                    src="{{ $resident->image ? asset('storage/'.$resident->image) : asset('assets/images/others/placeholder.jpg') }}"
                                    alt="Resident Image"
                                    class="profile-image">
                                <label for="residentImage" class="edit-icon">
                                    <i class="fas fa-pen"></i>
                                </label>
                                <input type="file" id="residentImage" name="resident_image" accept="image/*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Student ID</label>
                                    <select class="form-select" name="resident_user_id" id="user_id" disabled>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $resident->user_id == $user->id ? 'selected' : '' }}
                                                data-name="{{ $user->username }}"
                                                data-email="{{ $user->email }}">
                                                {{ $user->user_id }} ({{ $user->username }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="resident_name" id="user_name" value="{{ $resident->name }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="resident_email" id="user_email" value="{{ $resident->email }}" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select @error('resident_gender') is-invalid @enderror" name="resident_gender">
                                        <option selected disabled>Select Gender</option>
                                        <option value="male" {{ $resident->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $resident->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('resident_gender')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control @error('resident_address') is-invalid @enderror" rows="3" name="resident_address">{{ $resident->address }}</textarea>
                                    @error('resident_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Room</label>
                                    <select class="form-select @error('resident_room_id') is-invalid @enderror" name="resident_room_id">
                                        <option selected disabled>Select Room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ $resident->room_id == $room->id ? 'selected' : '' }}>
                                                {{ $room->name }} (Block {{ $room->block }}, Floor {{ $room->floor }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('resident_oom_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Semester/Year</label>
                                    <select class="form-select" name="resident_semester_id">
                                        <option selected disabled>Select Semester</option>
                                        @foreach($semesters as $semester)
                                            <option value="{{ $semester->id }}" {{ $resident->semester_id == $semester->id ? 'selected' : '' }}>
                                                {{ $semester->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Faculty</label>
                                    <select class="form-select @error('resident_faculity') is-invalid @enderror" name="resident_faculty">
                                        <option selected disabled>Select Faculty</option>
                                        @foreach(['FEB','FE','FACA','FCSHD','FMHS','FSSH','FRST','FCSIT','FLC','FBE'] as $faculty)
                                            <option value="{{ $faculty }}" {{ $resident->faculty == $faculty ? 'selected' : '' }}>{{ $faculty }}</option>
                                        @endforeach
                                    </select>
                                    @error('resident_faculty')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Program</label>
                                    <input type="text" class="form-control @error('resident_program') is-invalid @enderror" name="resident_program" value="{{ old('resident_program', $resident->program) }}">
                                    @error('resident_program')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Year of Study</label>
                                    <input type="text" class="form-control @error('resident_year_of_study') is-invalid @enderror" name="resident_year_of_study" value="{{ old('resident_year_of_study', $resident->year_of_study) }}">
                                    @error('resident_year_of_study')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Contact No</label>
                                    <input type="text" class="form-control @error('resident_contact_no') is-invalid @enderror" name="resident_contact_no" value="{{ old('resident_contact_no', $resident->contact_no) }}">
                                    @error('resident_contact_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Check In</label>
                                    <input type="datetime-local" class="form-control @error('resident_check_in') is-invalid @enderror" name="resident_check_in"
                                        value="{{ $resident->check_in ? \Carbon\Carbon::parse($resident->check_in)->format('Y-m-d\TH:i') : '' }}">
                                    @error('resident_check_in')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Check Out</label>
                                    <input type="datetime-local" class="form-control @error('resident_check_out') is-invalid @enderror" name="resident_check_out"
                                        value="{{ $resident->check_out ? \Carbon\Carbon::parse($resident->check_out)->format('Y-m-d\TH:i') : '' }}">
                                    @error('resident_check_out')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="resident_semester_id" value="{{ $semester->id }}">

                        <div class='d-flex justify-content-end gap-2'>
                            <button type="submit" class="btn btn-primary submit">Update</button>
                            <a href="{{ route('mainresident', ['id' => $semester->id]) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

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
