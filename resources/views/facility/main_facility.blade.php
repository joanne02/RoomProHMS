@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Facility';
@endphp
{{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="page-content">
    <div class="container">
        <div class="row mb-3">
            <!-- Facility Type Filter -->
            <div class="col-sm-8 d-flex align-items-center gap-2">
                <label for="facilityTypeFilter" class="form-label mb-0">Filter by Facility Type:</label>
                <select id="facilityTypeFilter" class="form-select" style="width: 250px;">
                    <option value="all">All</option>
                    @foreach($facility_types as $facility_type)
                        <option value="{{ strtolower($facility_type->name) }}">{{ $facility_type->name }}</option>
                    @endforeach
                    <option value="no-type-assigned">No Type Assigned</option>
                </select>
            </div>

            <!-- Add Facility Button -->
            
            <div class="col-sm-4 d-flex justify-content-end align-items-end">
                <a href="{{ route('addfacility')}}" class="btn btn-inverse-info">Add Facility</a>
            </div>
        </div>

        {{ Breadcrumbs::render('facility') }}

        <div class="row">
            <div class="col-xl-12 main-content ps-xl-4 pe-xl-5">
                <div id="facility_list">
                    @foreach($facilities as $facility)
                        <div class="example facility_card mb-3">
                            <div class="d-flex align-items-start">
                                {{-- Placeholder or actual image --}}
                                {{-- <img src="../../../assets/images/others/placeholder.jpg" class="wd-100 wd-sm-200 me-3" alt="..."> --}}
                                <img src="{{ asset('storage/' . $facility->image) }}" alt="Facility Image" class="wd-100 wd-sm-200 me-3" onerror="this.onerror=null; this.src='{{ asset('assets/images/others/placeholder.jpg') }}';">

                                {{-- Facility content --}}
                                <div class="col p-2">
                                    {{-- Header: Title + Icons --}}
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h4 class="mb-0">{{ $facility->name }}</h4>
                                        {{-- <div>
                                            <a href="{{ route('editfacility', $facility->id) }}" class="text-primary me-2">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a href="{{ route('deletefacility', $facility->id) }}" class="text-danger" id="delete">
                                                <i data-feather="trash"></i>
                                            </a>
                                        </div> --}}
                                        <div class="col-sm-4 d-flex justify-content-end align-items-end">
                                            <div  class="dropdown">
                                                <button class="btn p-0 border-0 bg-transparent" type="button" id="facilityOptions{{ $facility->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i data-feather="more-vertical"></i> {{-- Three-dot icon --}}
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="facilityOptions{{ $facility->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('editfacility', $facility->id) }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger delete-btn" href="{{ route('deletefacility', $facility->id) }}" id="delete" data-id="{{ $facility->id }}">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>  
                                    </div>
                                    {{-- Facility details --}}
                                    <div class="mb-2 d-flex">
                                        <p class="fw-bold mb-0 me-2">Type:</p>
                                        <p class="mb-0 facility-type">{{ $facility->facilityType ? $facility->facilityType->name: 'No Type Assigned' }}</p>
                                    </div>

                                    <div class="mb-2 d-flex">
                                        <p class="fw-bold mb-0 me-2">Description:</p>
                                        <p class="mb-0">{{ $facility->description }}</p>
                                    </div>

                                    <div class="mb-2 d-flex">
                                        <p class="fw-bold mb-0 me-2">Status:</p>
                                        <p class="mb-0">{{ $facility->status }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($facilities->isEmpty())
                        <div class="alert alert-warning text-center">
                            No Facility Found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0">
        <img id="modalImage" src="" class="img-fluid w-100" alt="Facility Image">
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script>
$(document).ready(function () {
    // $('.select2').select2({
    //     placeholder: 'Select Facility Type',
    //     allowClear: true
    // });

    // Image click to show modal
    $('.facility_card img').on('click', function () {
        const src = $(this).attr('src');
        $('#modalImage').attr('src', src);
        $('#imageModal').modal('show');
    });


    $('#facilityTypeFilter').on('change', function () {
        const selectedType = $(this).val();

        $('.facility_card').each(function () {
            const $card = $(this);
            const typeText = $card.find('.facility-type').text().toLowerCase().trim();

            const matches =
                selectedType === 'all' ||
                (selectedType === 'no-type-assigned' && typeText === 'no type assigned') ||
                typeText === selectedType;

            $card.toggle(matches);
        });
    });

});
</script>
@endsection
