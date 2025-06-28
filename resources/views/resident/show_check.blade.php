@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Resident';
    $currentRoute = Route::currentRouteName();
    $isCheckIn = in_array($currentRoute, ['showcheckin', 'residentcheckin']);
    $pageTitle = $isCheckIn ? 'Check In' : 'Check Out';
    $fieldName = $isCheckIn ? 'resident_check_in' : 'resident_check_out';
    $fieldId = $isCheckIn ? 'residentCheckIn' : 'residentCheckOut';
@endphp

<div class="page-content">

    <div class="row"> 
         @if ($isCheckIn)
            {{ Breadcrumbs::render('resident_check_in', $resident->id) }}
        @else
            {{ Breadcrumbs::render('resident_check_out', $resident->id) }}
        @endif
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">{{ $pageTitle }}</h6>

                    <form method="POST" action="{{ route($isCheckIn ? 'residentcheckin' : 'residentcheckout', $resident->id) }}" class="forms-sample">
                        @csrf
                        <div class="row mb-3">
                            <label for="{{ $fieldId }}" class="col-sm-3 col-form-label">{{ $pageTitle }}</label>
                            <div class="col-sm-9">
                                <input type="datetime-local"
                                    class="form-control @error($fieldName) is-invalid @enderror"
                                    id="{{ $fieldId }}"
                                    name="{{ $fieldName }}">
                                @error($fieldName)
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class='d-flex justify-content-end gap-2'>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('mainresidentresident') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection