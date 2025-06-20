@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'User Access';
@endphp

<div class="page-content">

    {{-- <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Forms</a></li>
            <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
        </ol>
    </nav> --}}

    {{ Breadcrumbs::render('create_role') }}

    <div class="row">
        
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Add User Role</h6>

                    <form method="POST" action="{{ route('adminroles.store') }}" class="forms-sample">
                        @csrf
                        <div class="row mb-3">
                            <label for="userRoleTitle" class="col-sm-3 col-form-label">User Role</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('user_role_name') is-invalid @enderror" id="userRole" name="user_role_name" placeholder="Type">
                                @error('user_role_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  
                        <div class='d-flex justify-content-end gap-2'>  
                            <button type="submit" class="btn btn-primary me-2">Save</button>
                            <a href="{{route('adminroles.index')}}" class="btn btn-secondary">Back</a>
                            {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
                        </div>
                    </form>

                    {{-- <form method="POST" action="{{ route('storefacilitytype') }}" class="forms-sample">
                        @csrf
                        <div class="mb-3">
                            <label for="facilityTypeName" class="form-label">Type</label>
                            <input type="text" class="form-control" id="facilityTypeName" name="facility_type_name" placeholder="Type">
                        </div>
            
                        <div class='d-flex justify-content-end gap-2'>  
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form> --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection