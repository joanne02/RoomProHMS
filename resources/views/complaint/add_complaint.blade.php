@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Complaint';
@endphp
<div class="page-content">
    {{Breadcrumbs::render('add_complaint')}}
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">New Complaint</h6>
                    <form method="POST" action="{{ route('storecomplaint') }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">ID</label>
                                    <input type="text" class="form-control @error('complaint_identify_number') is-invalid @enderror" name="complaint_identify_number" placeholder="Enter ID" value="{{ Auth::user()->user_id }}">
                                    @error('complaint_identify_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('complaint_username') is-invalid @enderror" name="complaint_username" placeholder="Enter Name" value="{{ Auth::user()->username }}"> 
                                    @error('complaint_username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-3 col-form-label">House/Room Related?</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input type="hidden" name="complaint_category" value="other">
                                    {{-- <input class="form-check-input" type="checkbox" id="typeCheckbox" name="complaint_category" value="house_room"> --}}
                                    <input class="form-check-input" type="checkbox" id="typeCheckbox" name="complaint_category" value="house_room"
                                    {{ old('complaint_category') === 'house_room' || $errors->has('complaint_room_name') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="typeCheckbox">
                                        Yes
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="complaintRoomAtField" class="row mb-3 {{ $errors->has('complaint_room_name') ? '' : 'd-none' }}">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="complaintRoom" class="form-label">House/Room (House:AG/01 Room:AG/01/A)</label>
                                    {{-- <select class="form-select" id="complaintRoom" name="complaint_room_id">
                                        <option value="">-- Select Room --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name ?? $room->room_code }}</option>
                                        @endforeach
                                    </select> --}}
                                    <input type="text" class="form-control @error('complaint_room_name') is-invalid @enderror" id="complaintRoom" name="complaint_room_name" placeholder="Eg:AG/01/A">
                                    @error('complaint_room_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Complaint Type</label>
                                    <select class="form-select @error('complaint_type') is-invalid @enderror" name="complaint_type" id="complainttype">
                                        <option selected disabled>Select Type</option>
                                        <option value="electrical">Electrical</option>
                                        <option value="water_supply">Water Supply</option>
                                        <option value="civil">Civil</option>
                                        <option value="security">Security</option>
                                        <option value="furniture">Furniture</option>
                                        <option value="cleanliness">Cleanliness</option>
                                        <option value="internet">Internet</option>
                                        <option value="other_type">Other</option>
                                    </select>
                                    @error('complaint_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('complaint_description') is-invalid @enderror" name="complaint_description" rows="4" placeholder="Enter Description"></textarea>
                                    @error('complaint_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" id="complaintAppendix" name="complaint_appendix[]" placeholder="Upload Image" multiple accept="image/*">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        
                        <div class="row">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary submit">Submit</button>
                                <a href="{{ route('indexcomplaint') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scheduleCheckbox = document.getElementById('typeCheckbox');
        const scheduledAtField = document.getElementById('complaintRoomAtField');
        const scheduledAtInput = document.getElementById('complaintRoom');

        // Toggle datetime input visibility
        scheduleCheckbox.addEventListener('change', function () {
            scheduledAtField.classList.toggle('d-none', !scheduleCheckbox.checked);
        });
    });
</script>