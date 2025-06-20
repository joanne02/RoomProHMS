@extends('admin.admin_dashboard')
@section('admin')

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

                    <h6 class="card-title">Personal Profile</h6>

                    
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label><br>
                            <div class="profile-container">
                                <img id="profilePreview"
                                    src="{{ auth()->user()->image ? asset('storage/'.auth()->user()->image) : asset('assets/images/others/placeholder.jpg') }}"
                                    alt="Resident Image"
                                    class="profile-image">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="profileEmail" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="profileEmail" name="profile_email" value="{{ old('profile_email', auth()->user()->email) }}" placeholder="Email" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profileName" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="profileName" name="profile_name" value="{{ old('profile_name', auth()->user()->username)}}" placeholder="Name" readonly>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profileID" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="profileID" name="profile_id" value="{{ old('profile_id', auth()->user()->user_id)}}" placeholder="ID" readonly>
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profileUserType" class="col-sm-3 col-form-label">User Type</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="profileUserType" name="profile_usertype" value="{{ ucwords(str_replace('_', ' ',old('profile_usertype', auth()->user()->usertype)))}}" placeholder="User Type" readonly>
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profileJoin" class="col-sm-3 col-form-label">Join</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="profileJoin" name="profile_join" value="{{ old('profile_join', auth()->user()->created_at)}}" placeholder="Join At" readonly>
                                
                            </div>
                        </div>
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
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection