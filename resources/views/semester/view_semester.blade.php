@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Facility';
@endphp
<div class="page-content">

    <div class="row">
        {{ Breadcrumbs::render('view_semester' ,$semester->id) }}
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
    
                        <h6 class="card-title">Semester Detail</h6>
    
                        {{-- <form method="POST" action="{{ route('updatesemester', $semester->id) }}" class="forms-sample"> --}}
                            {{-- @csrf --}}
                            <div class="row mb-3">
                                <label for="semesterSem" class="col-sm-3 col-form-label">Semester</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="semesterSem" name="semester_sem" value="{{ old('semester_sem', $semester->semester_sem) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="semesterYear" class="col-sm-3 col-form-label">Year</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="semesterYear" name="semester_year" value="{{ old('semester_year', $semester->semester_year) }}" readonly>            
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="semesterDate">Date</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="startDate" name="sem_start_date" value="{{ old('start_date', \Carbon\Carbon::parse($semester->start_date)->format('Y-m-d\TH:i')) }}" readonly>    
                                </div>
                                <label class="col-sm-1 col-form-label" for="semesterTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="endDate" name="sem_end_date" value="{{ old('sem_end_date', \Carbon\Carbon::parse($semester->end_date)->format('Y-m-d\TH:i')) }}" readonly>
                                </div>
                            </div>    
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="activationPeriod">Activation Date</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="activationStartDate" name="activation_start_date" value="{{ old('activation_start_date', \Carbon\Carbon::parse($semester->activated_at)->format('Y-m-d\TH:i')) }}" readonly>    
                                </div>
                                <label class="col-sm-1 col-form-label" for="activationPeriodTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="activationEndDate" name="activation_end_date" value="{{ old('activation_end_date', \Carbon\Carbon::parse($semester->deactivated_at)->format('Y-m-d\TH:i')) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="activationPeriod">Active/Inactive</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="activeSem" name="active_sem"
                                        value="{{ old('active_sem', $semester->is_active ? 'Active' : 'Inactive') }}" readonly>
                                </div>
                            </div>
                            <div class='d-flex justify-content-end gap-2'>
                                <a href="{{route('mainsemester')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection