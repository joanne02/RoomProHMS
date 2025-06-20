@extends('admin.admin_dashboard')
@section('admin')

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@php
    $pageTitle = 'Resident'
@endphp
<div class="page-content">
    <div class="container">

        <div class="row mb-3">
            <!-- Add Announcement Button -->
            <div class="col-sm-12 d-flex justify-content-between align-items-end">
                {{Breadcrumbs::render('main_housemate_resident')}}
                <div class="dropdown">
                    <button class="btn btn-inverse-info dropdown-toggle" type="button" id="announcementDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        CheckIn/CheckOut
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="announcementDropdown">
                        <li><a class="dropdown-item" href="{{ route('showcheckin', $userResident->id)}}">Check In</a></li>
                        <li><a class="dropdown-item" href="{{ route('showcheckout', $userResident->id)}}">Check Out</a></li>
                    </ul>
                </div>
            </div>            
        </div>
        {{-- User Resident Card (Larger) --}}
        <div class="example facility_card mb-4 p-4 border-primary border rounded shadow-sm">
            <div class="d-flex align-items-center flex-wrap">
                <img 
                        src="{{ $userResident->image ? asset('storage/' . $userResident->image) : asset('assets/images/others/placeholder.jpg') }}" 
                        class="wd-150 wd-sm-200 me-4 mb-3 mb-sm-0 rounded" 
                        alt="Resident Photo">
                    
                <div class="flex-grow-1">
                    <h4 class="mb-2">
                        {{ $userResident->name ?? 'Resident Name' }} 
                        <span class="text-muted">({{ $userResident->student_id ?? 'N/A' }})</span>
                    </h4>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Room Name:</strong> {{ $userResident->room->name ?? 'N/A' }}</p>
                            <p><strong>Sem/Year:</strong> {{ $userResident->semester->name ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $userResident->email ?? 'N/A' }}</p>
                            <p><strong>Contact No:</strong> {{ $userResident->contact_no ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Faculty:</strong> {{ $userResident->faculty ?? 'N/A' }}</p>
                            <p><strong>Program:</strong> {{ $userResident->program ?? 'N/A' }}</p>
                            <p><strong>Year of Study:</strong> {{ $userResident->year_of_study ?? 'N/A' }}</p>
                            <p><strong>Check In:</strong> {{ $userResident->check_in ?? 'N/A' }}</p>
                            <p><strong>Check Out:</strong> {{ $userResident->check_out ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        {{-- Housemates List --}}
        <h4 class="mb-3">Housemates</h4>

        <div id="facility_list">
            @foreach($residents as $resident)
                @if($resident->id !== $userResident->id)
                <div class="example facility_card mb-4 p-4 border-info border rounded shadow-sm">
                    <div class="d-flex align-items-center flex-wrap">
                        <img 
                        src="{{ $resident->image ? asset('storage/' . $resident->image) : asset('assets/images/others/placeholder.jpg') }}" 
                        class="wd-150 wd-sm-200 me-4 mb-3 mb-sm-0 rounded" 
                        alt="Resident Photo">
                            
                        <div class="flex-grow-1">
                            <h4 class="mb-2">
                                {{ $resident->name ?? 'Resident Name' }} 
                                <span class="text-muted">({{ $resident->student_id ?? 'N/A' }})</span>
                            </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Room Name:</strong> {{ $resident->room->name ?? 'N/A' }}</p>
                                    <p><strong>Sem/Year:</strong> {{ $resident->semester->name ?? 'N/A' }}</p>
                                    <p><strong>Email:</strong> {{ $resident->email ?? 'N/A' }}</p>
                                    <p><strong>Contact No:</strong> {{ $resident->contact_no ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Faculty:</strong> {{ $resident->faculty ?? 'N/A' }}</p>
                                    <p><strong>Program:</strong> {{ $resident->program ?? 'N/A' }}</p>
                                    <p><strong>Year of Study:</strong> {{ $resident->year_of_study ?? 'N/A' }}</p>
                                    <p><strong>Check In:</strong> {{ $resident->check_in ?? 'N/A' }}</p>
                                    <p><strong>Check Out:</strong> {{ $resident->check_out ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif
            @endforeach
        </div>

    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

@endsection
