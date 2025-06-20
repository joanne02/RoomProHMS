@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Application';
@endphp
<div class="page-content">
    {{Breadcrumbs::render('add_application_session')}}
    <div class="row">
        
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h6 class="card-title">Add Application Session</h6>
    
                        <form method="POST" action="{{ route('storeapplicationsession') }}" class="forms-sample">
                            @csrf
                            {{-- <div class="row mb-3">
                                <label for="applicationSem" class="col-sm-3 col-form-label">Semester</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="semester" name="application_session_semester">              
                                </div>
                            </div> --}}
                            <div class="row mb-3">
                                <label for="semesterSession" class="col-sm-3 col-form-label">Semester Session</label>
                                <div class="col-sm-9">
                                    <select class="form-select @error('application_semester') is-invalid @enderror" id="semesterSession" name="application_semester">       
                                        <option selected disabled>Semester Session</option>    
                                        @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id}}">{{$semester->name}}</option>
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
                                    <input type="number" class="form-control @error('application_session_batch') is-invalid @enderror" id="batch" name="application_session_batch">
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
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div> --}}
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="applicationDate">Date</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control"id="startDate" name="semester_start_date"readonly>
                                </div>
                                <label class="col-sm-1 col-form-label" for="applicationTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control" id="endDate" name="semester_end_date" readonly>
                                </div>
                            </div>    
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="applicationPeriod">Application Period</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('application_start_date') is-invalid @enderror" id="applicationStartDate" name="application_start_date">
                                    @error('application_start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-1 col-form-label" for="applicationPeriodTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('application_end_date') is-invalid @enderror" id="applicationEtartDate" name="application_end_date">
                                    @error('application_end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>  
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="acceptancePeriod">Acceptance Period</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('acceptance_start_date') is-invalid @enderror" id="acceptanceStartDate" name="acceptance_start_date">
                                    @error('acceptance_start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-1 col-form-label" for="acceptancePeriodTo">To</label>
                                <div class="col-sm-3">
                                    <input type="datetime-local" class="form-control @error('acceptance_end_date') is-invalid @enderror" id="acceptanceEtartDate" name="acceptance_end_date">
                                    @error('acceptance_end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> 

                            <div class='d-flex justify-content-end gap-2'>     
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{route('mainapplicationsession')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
    
                    </div>
                </div>
            </div>
    </div>
</div>

@push('scripts')
<script>
    // Pass semesters from PHP to JS
    const semesters = @json($semesters->mapWithKeys(fn($s) => [
        $s->id => [
            'start_date' => \Carbon\Carbon::parse($s->start_date)->format('Y-m-d\TH:i'),
            'end_date' => \Carbon\Carbon::parse($s->end_date)->format('Y-m-d\TH:i'),
        ]
    ]));
    
    document.getElementById('semesterSession').addEventListener('change', function () {
        const selectedId = this.value;

        if (semesters[selectedId]) {
            document.getElementById('startDate').value = semesters[selectedId].start_date;
            document.getElementById('endDate').value = semesters[selectedId].end_date;
        }
    });
</script>

@endpush

@endsection