@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Facility';
@endphp
<div class="page-content">

    {{ Breadcrumbs::render('edit_facility', $facility->id) }}

    <div class="row"> 
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Edit Facility</h6>

                    <form method="POST" action="{{ route('updatefacility', $facility->id) }}" class="forms-sample">
                        @csrf
                        <input type="hidden" name="id" value={{$facility->id}}>
                        <div class="row mb-3">
                            <label for="facilityName" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('facility_name') is-invalid @enderror" id="facilityName" name="facility_name" placeholder="Name" value="{{ old('facility_name', $facility->name) }}">
                                @error('facility_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="facilityType" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="facilityType" name="facility_type">       
                                    <option disabled {{ is_null(old('facility_type', $facility->facility_type_id ?? null)) ? 'selected' : '' }}>Facility Type</option>    
                                    @foreach ($facilityTypes as $facilityType)
                                        <option value="{{ $facilityType->id }}"
                                            {{ old('facility_type', $facility->facility_type_id ?? null) == $facilityType->id ? 'selected' : '' }}>
                                            {{ $facilityType->name }}
                                        </option>
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
                                <textarea class="form-control @error('facility_description') is-invalid @enderror" id="facilityDescription" rows="3" name="facility_description" placeholder="Description">{{ old('facility_description', $facility->description)}}</textarea>
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
                                    <option value="Good" {{ $facility->status =='Good'?'selected':''}}>Good</option>
                                    <option value="Under Maintenance" {{ $facility->status =='Under Maintenance'?'selected':''}}>Under Maintenance</option>
                                    <option value="Closed" {{ $facility->status =='Closed'?'selected':''}}>Closed</option>
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
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="{{ route('mainfacility') }}" class="btn btn-secondary me-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection