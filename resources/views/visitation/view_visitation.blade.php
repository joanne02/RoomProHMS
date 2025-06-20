@extends('admin.admin_dashboard')
@section('admin')

<style>
    /* Apply when in dark mode */
    .dark-disabled:disabled {
        background-color: #2b2b2b !important;
        color: #ffffff !important;
        border: 1px solid #444 !important;
        opacity: 1 !important; /* Override default faded look */
    }
</style>

@php
    $pageTitle = 'Visitation';
@endphp

<div class="page-content">
    <div class="row">
        {{ Breadcrumbs::render('view_visitation', $visitation->id) }}
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">New Visitation</h6>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="visitor_name" placeholder="Enter Full Name" value="{{ old('visitor_name', $visitation->name) }}" readonly>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Contact No</label>
                                    <input type="text" class="form-control" name="visitor_contact_no" placeholder="Enter Contact No" value="{{ old('visitor_contact_no', $visitation->contact_no) }}" readonly>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Purpose</label>
                                    <select class="form-select dark-disabled" disabled>
                                        <option value="visitation" {{ old('visit_purpose') == 'visitation' ? 'selected' : '' }}>Visitation</option>
                                        <option value="maintenance" {{ old('visit_purpose') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="official_business" {{ old('visit_purpose') == 'official_business' ? 'selected' : '' }}>Official Business</option>
                                        <option value="other" {{ old('visit_purpose') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-12" id="otherPurposeField" style="display: {{ $visitation->other_purpose ? 'block' : 'none' }};">
                                <div class="mb-3">
                                    <label class="form-label">Please specify your purpose</label>
                                    <input type="text" name="other_visit_purpose" class="form-control" placeholder="Specify the purpose" value="{{ $visitation->other_purpose }}" readonly>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    {{-- <input type="text" class="form-control @error('visit_remark') is-invalid @enderror" name="visit_remark" placeholder="Enter Remark" value="{{ old('visit_remark') }}"> --}}
                                    <textarea class="form-control" id="visitDescription" rows="3" name="visit_description" placeholder="Enter Description of visitation">{{ old('visit_remark', $visitation->description) }}</textarea>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Check In</label>
                                    <input type="datetime-local" class="form-control" id="checkIn" name="visit_check_in" value="{{ old('visit_check_in', $visitation->check_in) }}" readonly>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Check Out</label>
                                    <input type="datetime-local" class="form-control" id="checkOut" name="visit_check_out" value="{{ old('visit_check_out', $visitation->check_out) }}" readonly>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->

                        @php
                            $appendixFiles = !empty($visitation->appendix) ? json_decode($visitation->appendix, true) : [];
                        @endphp

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Appendix</label>

                                    @if (!empty($appendixFiles))
                                        <ul>
                                            @foreach ($appendixFiles as $file)
                                                <li>
                                                    <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                                        {{ $file }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No appendix available.</p>
                                    @endif

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('mainvisitation') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
