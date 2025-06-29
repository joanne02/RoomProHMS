<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Visitation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-4">New Visitation</h3>

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops! Something went wrong:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Display success message -->
                @if (session('message'))
                    <div class="alert alert-{{ session('alert-type', 'info') }}">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('storevisitationpublicform') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- <input type="hidden" name="visitation_token" value="{{ $visitationToken }}"> --}}
                    

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="visitor_name"
                                   value="{{ old('visitor_name', $existing->name ?? '') }}" placeholder="Enter Full Name">
                                   @error('visitor_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Contact No</label>
                            <input type="text" name="visitor_contact_no" class="form-control"
                            value="{{ old('visitor_contact_no', $contactNo ?? ($existing->contact_no ?? '')) }}" required>
                        @error('visitor_contact_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purpose</label>
                        <select class="form-select" name="visit_purpose" id="visitpurpose">
                            <option selected disabled>Select Purpose</option>
                            <option value="visitation" {{ old('visit_purpose', $existing->purpose ?? '') == 'visitation' ? 'selected' : '' }}>Visitation</option>
                            <option value="maintenance" {{ old('visit_purpose', $existing->purpose ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="official_business" {{ old('visit_purpose', $existing->purpose ?? '') == 'official_business' ? 'selected' : '' }}>Official Business</option>
                            <option value="other" {{ !in_array($existing->purpose ?? '', ['visitation','maintenance','official_business']) && isset($existing) ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('visit_purpose')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3" id="otherPurposeField" style="display: none;">
                        <label class="form-label">Please specify your purpose</label>
                        <input type="text" name="other_visit_purpose" class="form-control"
                               value="{{ old('other_visit_purpose', (!in_array($existing->purpose ?? '', ['visitation','maintenance','official_business']) && isset($existing)) ? $existing->purpose : '') }}"
                               placeholder="Specify the purpose">
                    @error('other_visit_purpose')
            <small class="text-danger">{{ $message }}</small>
        @enderror
                            </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="visit_description" rows="3"
                                  placeholder="Enter Description of visitation">{{ old('visit_description', $existing->description ?? '') }}</textarea>
                                  @error('visit_description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Check In</label>
                            <input type="datetime-local" class="form-control" name="visit_check_in"
                                   value="{{ old('visit_check_in', isset($existing->check_in) ? \Carbon\Carbon::parse($existing->check_in)->format('Y-m-d\TH:i') : '') }}">
                        @error('visit_check_in')
    <small class="text-danger">{{ $message }}</small>
@enderror
                                </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Check Out</label>
                            <input type="datetime-local" class="form-control" name="visit_check_out"
                                   value="{{ old('visit_check_out', isset($existing->check_out) ? \Carbon\Carbon::parse($existing->check_out)->format('Y-m-d\TH:i') : '') }}">
                                   @error('visit_check_out')
    <small class="text-danger">{{ $message }}</small>
@enderror
                                </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Appendix</label>
                        <input type="file" class="form-control" name="visit_appendix[]" multiple>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ isset($existing) ? 'Update Check-out' : 'Submit' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toggle other purpose field -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const purposeSelect = document.getElementById('visitpurpose');
            const otherField = document.getElementById('otherPurposeField');

            function toggleOtherField() {
                otherField.style.display = (purposeSelect.value === 'other') ? 'block' : 'none';
            }
            purposeSelect.addEventListener('change', toggleOtherField);
            toggleOtherField(); // trigger on page load if "other" is pre-selected
        });
    </script>

</body>
</html>
