@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Facility Type';
@endphp
<div class="page-content">
    {{ Breadcrumbs::render('edit_facility_type', $facility_type->id) }}

    <div class="row">
        
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Add Facility Type</h6>

                    <form method="POST" action="{{ route('updatefacilitytype', $facility_type->id) }}" class="forms-sample">
                        @csrf
                        <div class="row mb-3">
                            <label for="facilityTypeName" class="col-sm-3 col-form-label">Facility Type</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('facility_type_name') is-invalid @enderror" id="facilityName" name="facility_type_name" placeholder="Type" value="{{old('facility_type_name', $facility_type->name)}}">
                                @error('facility_type_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>  
                        <div class='d-flex justify-content-end gap-2'>  
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('mainfacilitytype') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection