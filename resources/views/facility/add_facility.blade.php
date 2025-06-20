@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Facility';
@endphp
<div class="page-content">

    {{ Breadcrumbs::render('add_facility') }}

    <div class="row">
        
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Add Facility</h6>

                    <form method="POST" action="{{ route('storefacility') }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="facilityName" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('facility_name') is-invalid @enderror" id="facilityName" name="facility_name" placeholder="Name">
                                @error('facility_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="facilityType" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-9">
                                <select class="form-select @error('facility_type') is-invalid @enderror" id="facilityType" name="facility_type">       
                                    <option selected disabled>Facility Type</option>    
                                    @foreach ($facilityTypes as $facilityType)
                                    <option value="{{ $facilityType->id}}">{{$facilityType->name}}</option>
                                    @endforeach
                                </select>
                                @error('facility_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror       
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="facilityDescription" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('facility_description') is-invalid @enderror" id="facilityDescription" rows="3" name="facility_description" placeholder="Description"></textarea>
                            @error('facility_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
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
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="facilityImage">Image upload</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('facility_image') is-invalid @enderror" type="file" id="facilityImage" name="facility_image">
                                @error('facility_image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>    
                        <div class='d-flex justify-content-end gap-2'>     
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('mainfacility') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection