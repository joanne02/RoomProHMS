@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Application';
@endphp
<div class="page-content">
{{Breadcrumbs::render('edit_application_session', $application_session->id)}}
    <div class="row">
        
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
    
                        <h6 class="card-title">Edit Application Session</h6>
    
                        <form method="POST" action="{{ route('updateapplicationsession', $application_session->id) }}" class="forms-sample">
                            @csrf
                            {{-- <div class="row mb-3">
                                <label for="applicationSem" class="col-sm-3 col-form-label">Semester</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('application_session_semester') is-invalid @enderror" id="semester" name="application_session_semester" value="{{ old('application_session_semester', $application_session->semester) }}">            
                                @error('application_session_semester')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div> --}}
                            <div class="row mb-3">
                                <label for="semesterSession" class="col-sm-3 col-form-label">Semester Session</label>
                                <div class="col-sm-9">
                                    <select class="form-select @error('application_semester') is-invalid @enderror" id="semesterSession" name="application_semester">       
                                        <option selected disabled {{ is_null(old('application_semester', $semester->semester_id ?? null)) ? 'selected' : ''}}>Semester Session</option>    
                                        @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id}}"
                                            {{old('application_semester', $application_session->semester_id ?? null) == $semester->id ? 'selected' : ''}}>{{$semester->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('application_semester')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror       
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="applicationBatch" class="col-sm-3 col-form-label">Application Batch</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="batch" name="application_session_batch" value="{{ old('application_session_batch', $application_session->application_batch) }}">            
                                @error('application_session_batch')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            {{-- <div class="row mb-3">
                                <label for="year" class="col-sm-3 col-form-label">Select Year:</label>
                                <div class="col-sm-9">
                                    <select name="application_session_year" id="application_year" class="form-control" required>
                                        <option value="">-- Select Year --</option>
                                        @for ($i = date('Y') + 5; $i >= 2020; $i--)
                                            <option value="{{ $i }}" {{old('application_session_year', $application_session->year ?? '') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="applicationDate">Date</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="startDate" name="semester_start_date" value="{{ old('semester_start_date', \Carbon\Carbon::parse($application_session->start_date)->format('Y-m-d\TH:i')) }}">
                                @error('semester_start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                                <label class="col-sm-1 col-form-label" for="applicationTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="endDate" name="semester_end_date" value="{{ old('semester_end_date', \Carbon\Carbon::parse($application_session->end_date)->format('Y-m-d\TH:i')) }}">
                                @error('semester_end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>     --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="applicationPeriod">Application Period</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="applicationStartDate" name="application_start_date" value="{{ old('application_start_date', \Carbon\Carbon::parse($application_session->application_start_date)->format('Y-m-d\TH:i')) }}">
                                @error('application_start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                                <label class="col-sm-1 col-form-label" for="applicationPeriodTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="applicationEndDate" name="application_end_date" value="{{ old('application_end_date', \Carbon\Carbon::parse($application_session->application_end_date)->format('Y-m-d\TH:i')) }}">
                                @error('application_end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
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
                            </div>

                            <div class="row mb-3">
                                <label for="applicationSession" class="col-sm-3 col-form-label">Session</label>
                                <div class="col-sm-9">
                                    <select class="form-select @error('application_session_active') is-invalid @enderror" id="applicationSession" name="application_session_active">
                                        <option value="1" {{ old('application_session_active', $application_session->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('application_session_active', $application_session->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('application_session_active')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    {{-- <small class="form-text text-muted">
                                        * To activate, current date ({{ now()->format('d M Y') }}) must be between 
                                        {{ \Carbon\Carbon::parse($application_session->application_start_date)->format('d M Y') }}
                                        and 
                                        {{ \Carbon\Carbon::parse($application_session->acceptance_end_date)->format('d M Y') }}.
                                    </small> --}}
                                    <small class="form-text text-muted">
                                        * To activate or inactive, please update the date.
                                    </small>
                                </div>
                            </div>

                            
                            <div class='d-flex justify-content-end gap-2'>     
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{route('mainapplicationsession')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
    
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection