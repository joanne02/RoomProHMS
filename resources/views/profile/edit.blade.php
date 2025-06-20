{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

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

    input[type="file"]#profileImage {
        display: none;
    }
</style>

<div class="page-content">

    {{-- {{ Breadcrumbs::render('add_facility') }} --}}

    <div class="row">
        
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Validation Failed</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h6 class="card-title">Edit Profile</h6>

                    <form method="POST" action="{{ route('profile.update') }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label><br>
                            <div class="profile-container">
                                <img id="profilePreview"
                                    src="{{ auth()->user()->image ? asset('storage/'.auth()->user()->image) : asset('assets/images/others/placeholder.jpg') }}"
                                    alt="Resident Image"
                                    class="profile-image">
                                <label for="profileImage" class="edit-icon">
                                    <i class="fas fa-pen"></i>
                                </label>
                                <input type="file" id="profileImage" name="profile_image" accept="image/*">
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
                                <input type="text" class="form-control @error('profile_name') is-invalid @enderror" id="profileName" name="profile_name" value="{{ old('profile_name', auth()->user()->username)}}" placeholder="Name">
                                @error('profile_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profileID" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('profile_id') is-invalid @enderror" id="profileID" name="profile_id" value="{{ old('profile_id', auth()->user()->user_id)}}" placeholder="ID">
                                @error('profile_id')
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

@push('scripts')
<script>
    document.getElementById('profileImage').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection



