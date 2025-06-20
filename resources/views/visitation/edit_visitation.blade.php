@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Visitation';
@endphp
<div class="page-content">
    <div class="row">
        {{ Breadcrumbs::render('edit_visitation', $visitation->id) }}
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Visitation</h6>
                    <form method="POST" action="{{ route('updatevisitation', $visitation->id) }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('visitor_name') is-invalid @enderror" name="visitor_name" placeholder="Enter Full Name" value="{{ old('visitor_name', $visitation->name) }}">
                                    @error('visitor_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Contact No</label>
                                    <input type="text" class="form-control @error('visitor_contact_no') is-invalid @enderror" name="visitor_contact_no" placeholder="Enter Contact No" value="{{ old('visitor_contact_no', $visitation->contact_no) }}">
                                    @error('visitor_contact_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Purpose</label>
                                    <select class="form-select @error('visit_purpose') is-invalid @enderror" name="visit_purpose" id="visitpurpose">
                                        <option selected disabled>Select Purpose</option>
                                        <option value="visitation" {{ old('visit_purpose', $visitation->purpose) == 'visitation' ? 'selected' : '' }}>Visitation</option>
                                        <option value="maintenance" {{ old('visit_purpose', $visitation->purpose) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="official_business" {{ old('visit_purpose', $visitation->purpose) == 'official_business' ? 'selected' : '' }}>Official Business</option>
                                        <option value="other" {{ old('visit_purpose', $visitation->purpose) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('visit_purpose')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            @if($visitation->other_purpose)
                                <div class="col-sm-12" id="otherPurposeField" style="display: {{ old('visit_purpose') == 'other' ? 'block' : 'none' }};">
                                    <div class="mb-3">
                                        <label class="form-label">Please specify your purpose</label>
                                        <input type="text" name="other_visit_purpose" class="form-control" placeholder="Specify the purpose" value="{{ old('other_visit_purpose', $visitation->other_purpose) }}">
                                        @error('other_visit_purpose')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            @endif
                        </div><!-- Row -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    {{-- <input type="text" class="form-control @error('visit_remark') is-invalid @enderror" name="visit_remark" placeholder="Enter Remark" value="{{ old('visit_remark') }}"> --}}
                                    <textarea class="form-control @error('visit_description') is-invalid @enderror" id="visitDescription" rows="3" name="visit_description" placeholder="Enter Description of visitation">{{ old('visit_description', $visitation->description) }}</textarea>
                                    @error('visit_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Check In</label>
                                    <input type="datetime-local" class="form-control @error('visit_check_in') is-invalid @enderror" id="checkIn" name="visit_check_in" value="{{ old('visit_check_in', $visitation->check_in) }}">
                                    @error('visit_check_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Check Out</label>
                                    <input type="datetime-local" class="form-control @error('visit_check_out') is-invalid @enderror" id="checkOut" name="visit_check_out" value="{{ old('visit_check_out', $visitation->check_out) }}">
                                    @error('visit_check_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Appendix</label>
                                    @if(!empty($visitation->appendix))
                                        <div class="mb-3">
                                            <label class="form-label">Previously Uploaded Appendix</label>
                                            <ul>
                                                
                                                        @foreach(json_decode($visitation->appendix, true) as $file)
                                                            <div class="row align-items-center mb-2">
                                                                <div class="col-8">
                                                                    <a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" name="delete_appendix[]" value="{{ $file }}" id="delete_{{ $loop->index }}">
                                                                        <label class="form-check-label text-danger" for="delete_{{ $loop->index }}">Remove</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <input type="file" class="form-control" id="visitAppendix" name="visit_appendix[]" multiple>
                                    @error('visit_appendix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div><!-- Row -->

                        <div class="row">
                            {{-- <div class="col-sm-6">
                                <a href="{{ route('viewqr') }}" class="btn btn-secondary">
                                    Download QR Code
                                </a>                                                              
                            </div> --}}
                            <div class="col-sm-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary submit">Update</button>
                                <a href="{{ route('mainvisitation') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const purposeSelect = document.getElementById('visitpurpose');
        const otherField = document.getElementById('otherPurposeField');
        
        purposeSelect.addEventListener('change', function () {
            if (this.value === 'other') {
                otherField.style.display = 'block';
            } else {
                otherField.style.display = 'none';
            }
        });

        // Trigger the change event if the value is already 'other'
        if (purposeSelect.value === 'other') {
            otherField.style.display = 'block';
        }
    });
</script>
@endsection
