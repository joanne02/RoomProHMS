@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Semester';
@endphp
<div class="page-content">

    <div class="row">
        {{ Breadcrumbs::render('add_semester') }}
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
    
                        <h6 class="card-title">Add Semester</h6>
    
                        <form method="POST" action="{{ route('storesemester') }}" class="forms-sample">
                            @csrf
                            <div class="row mb-3">
                                <label for="semesterSem" class="col-sm-3 col-form-label">Semester</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('semester_sem') is-invalid @enderror" id="semesterSem" name="semester_sem">
                                    @error('semester_sem')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="semesterYear" class="col-sm-3 col-form-label">Year</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('semester_year') is-invalid @enderror" id="semesterYear" name="semester_year">            
                                    @error('semester_year')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="semesterDate">Date</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('sem_start_date') is-invalid @enderror" id="startDate" name="sem_start_date">
                                    @error('sem_start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-1 col-form-label" for="semesterTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('sem_end_date') is-invalid @enderror" id="endDate" name="sem_end_date">
                                    @error('sem_end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>    
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="activationPeriod">Activation Date</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('activation_start_date') is-invalid @enderror" id="activationStartDate" name="activation_start_date">
                                    @error('activation_start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-1 col-form-label" for="activationPeriodTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('activation_end_date') is-invalid @enderror" id="activationEndDate" name="activation_end_date">
                                    @error('activation_end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="acceptancePeriod">Acceptance Period</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="acceptanceStartDate" name="acceptance_start_date" value="{{ old('acceptance_start_date', \Carbon\Carbon::parse($application_session->acceptance_start_date)->format('Y-m-d\TH:i')) }}">
                                @error('acceptance_start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                                <label class="col-sm-1 col-form-label" for="acceptancePeriodTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="acceptanceEndDate" name="acceptance_end_date" value="{{ old('acceptance_end_date', \Carbon\Carbon::parse($application_session->acceptance_end_date)->format('Y-m-d\TH:i')) }}">
                                @error('acceptance_end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="row mb-3">
                                <label for="applicationSession" class="col-sm-3 col-form-label">Session</label>
                                <div class="col-sm-9">
                                    <select class="form-select @error('application_session_active') is-invalid @enderror" id="applicationSession" name="application_session_active" disabled>
                                        <option value="1" {{ old('application_session_active', $application_session->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('application_session_active', $application_session->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('application_session_active')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class='d-flex justify-content-end gap-2'>     
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{route('mainsemester')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
    
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection