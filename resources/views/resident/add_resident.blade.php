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
    
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">New Resident</h6>
                        <form method="POST" action="{{ route('storeresident') }}" class="forms-sample">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Profile Image</label><br>

                                <div class="profile-container">
                                    <img id="profilePreview"
                                        src="../../../assets/images/others/placeholder.jpg"
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
                                        <select class="form-select @error('resident_user_id') is-invalid @enderror" name="resident_user_id" id="user_id">
                                            <option selected disabled>Select Student</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                    data-name="{{ $user->username }}"
                                                    data-email="{{ $user->email }}">
                                                    {{ $user->user_id }} ({{ $user->username }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('resident_user_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control @error('resident_name') is-invalid @enderror" name="resident_name" id="user_name" placeholder="Name" readonly>
                                        @error('resident_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control @error('resident_email') is-invalid @enderror" name="resident_email" id="user_email" placeholder="Email" readonly>
                                        @error('resident_email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select @error('resident_gender') is-invalid @enderror" name="resident_gender" id="usergender">
											<option selected disabled>Select Gender</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
                                        @error('resident_gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control @error('resident_address') is-invalid @enderror" rows="3" name="resident_address" placeholder="Enter Address"></textarea>
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
                                        <select class="form-select @error('resident_room_id') is-invalid @enderror" name="resident_room_id" id="roomSelect">
                                            <option selected disabled>Select Room</option>
                                            @foreach($rooms as $room)
                                                <option 
                                                    value="{{ $room->id }}" 
                                                    data-gender="{{ $room->gender }}">
                                                    {{ $room->name }} (Block {{ $room->block }}, Floor {{ $room->floor }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('resident_room_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact No</label>
                                        <input type="text" class="form-control @error('resident_contact_no') is-invalid @enderror" name="resident_contact_no" placeholder="Enter Contact No">
                                        @error('resident_contact_no')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Faculty</label>
                                        <select class="form-select @error('resident_faculty') is-invalid @enderror" name="resident_faculty" id="residentfaculty">
											<option selected disabled>Select Faculty</option>
											<option value="FEB">FEB</option>
											<option value="FE">FE</option>
                                            <option value="FACA">FACA</option>
                                            <option value="FCSHD">FCSHD</option>
                                            <option value="FMHS">FMHS</option>
                                            <option value="FSSH">FSSH</option>
                                            <option value="FRST">FRST</option>
                                            <option value="FCSIT">FCSIT</option>
                                            <option value="FLC">FLC</option>
                                            <option value="FBE">FBE</option>
										</select>
                                        @error('resident_faculty')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Program</label>
                                        <input type="text" class="form-control @error('resident_program') is-invalid @enderror" name="resident_program" placeholder="Enter Program">
                                        @error('resident_program')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Year of Study</label>
                                        <input type="text" class="form-control @error('resident_year_of_study') is-invalid @enderror" name="resident_year_of_study" placeholder="Enter Year of Study">
                                        @error('resident_year_of_study')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                {{-- <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact No</label>
                                        <input type="text" class="form-control @error('resident_contact_no') is-invalid @enderror" name="resident_contact_no" placeholder="Enter Contact No">
                                        @error('resident_contact_no')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col --> --}}
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Check In</label>
                                        <input type="datetime-local" class="form-control @error('resident_check_in') is-invalid @enderror" name="resident_check_in">
                                        @error('resident_check_in')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Check Out</label>
                                        <input type="datetime-local" class="form-control @error('resident_check_out') is-invalid @enderror" name="resident_check_out">
                                        @error('resident_check_out')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->

                            {{-- <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="facilityImage" name="resident_image">
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row --> --}}

                           <input type="hidden" name="resident_category_id" value="{{ $id }}">
                           <input type="hidden" name="resident_semester_id" value="{{ $semester->id }}">
                                
                            <div class='d-flex justify-content-end gap-2'>
                                <button type="submit" class="btn btn-primary submit">Create</button>
                                <a href="{{ route('mainresident', ['id' => $id]) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form> 
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('user_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const name = selectedOption.getAttribute('data-name');
        const email = selectedOption.getAttribute('data-email');

        document.getElementById('user_name').value = name || '';
        document.getElementById('user_email').value = email || '';
    });
</script>
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
<script>
    document.getElementById('usergender').addEventListener('change', function () {
        const selectedGender = this.value;
        const roomSelect = document.getElementById('roomSelect');
        const options = roomSelect.options;

        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const roomGender = option.getAttribute('data-gender');

            // Show all rooms that match the selected gender or are unisex
            if (!roomGender || roomGender === selectedGender || roomGender === 'unisex') {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }

        // Reset room selection
        roomSelect.selectedIndex = 0;
    });
</script>

@endpush


@endsection