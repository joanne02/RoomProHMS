@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Facility Type';
@endphp
<div class="page-content">

    {{ Breadcrumbs::render('add_facility_type') }}

    <div class="row">
        
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Add Facility Type</h6>

                    <form method="POST" action="{{ route('storefacilitytype') }}" class="forms-sample">
                        @csrf
                        <div class="row mb-3">
                            <label for="facilityTypeName" class="col-sm-3 col-form-label">Facility Type</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('facility_type_name') is-invalid @enderror" id="facilityName" name="facility_type_name" placeholder="Type">
                                @error('facility_type_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>  
                        <div class='d-flex justify-content-end gap-2'>  
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('mainfacilitytype') }}" class="btn btn-secondary">Back</a>
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