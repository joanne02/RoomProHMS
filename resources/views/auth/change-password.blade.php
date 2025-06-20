@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

    {{-- {{ Breadcrumbs::render('add_facility') }} --}}

    <div class="row">
        
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Validation Failed</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <h6 class="card-title">Change Password</h6>

                    <form method="POST" action="{{ route('changepasswordupdate') }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="currentPassword" class="col-sm-3 col-form-label">Current Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="currentPassword" name="current_password">
                                @if ($errors->has('current_password'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('current_password') }}</span>
                                @endif

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="newPassword" class="col-sm-3 col-form-label">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPassword" name="new_password">
                                @error('new_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="confirmPassword" name="new_password_confirmation">
                                @error('new_password_confirmation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label for="facilityStatus" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select @error('facility_status') is-invalid @enderror" id="facilityStatus" name="facility_status">
                                    <option selected disabled>Status</option>
                                    <option>Good</option>
                                    <option>Under Maintenance</option>
                                    <option>Closed</option>
                                </select>
                                @error('facility_status')
                                    <span class="invalid-feedback">{{ $message}}</span>
                                @enderror
                            </div>
                        </div> --}}
                        {{-- <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="profileImage">Profile Image</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('profile_image') is-invalid @enderror" type="file" id="profileImage" name="profile_image">
                                @error('profile_image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>    
                        <div class="row mb-3">
                            @php
                                $profileImage = auth()->user()->image 
                                    ? asset('storage/' . auth()->user()->image)
                                    : 'https://via.placeholder.com/100x100';
                            @endphp
                            <img id="previewImage" class="wd-150 ht-150 rounded-circle" src="{{ $profileImage }}" alt="Profile Image">
                        </div> --}}

                        <div class='d-flex justify-content-end gap-2'>     
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection