@extends('admin.admin_dashboard')
@section('admin')

{{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

@php
    $pageTitle = 'Resident'
@endphp
<div class="page-content">
    <div class="container">
        <div class="row mb-3">

            
            <div class="col-sm-8 d-flex align-items-center gap-2">
                <label for="resident_semester_input" class="form-label mb-0">Search:</label>
                <input type="text" class="form-control" id="resident_semester_input" placeholder="Search by semester">
            </div>
            <!-- Add Facility Button -->
            {{-- <div class="col-sm-4 d-flex justify-content-end align-items-end">
                <a href="{{route('addapplicationsession')}}" class="btn btn-inverse-info">Create New Application Session</a>
            </div> --}}
        </div>
        <hr>
        {{Breadcrumbs::render('index_resident')}}
        <div class="row">
            <div class="col-xl-8 main-content ps-xl-4 pe-xl-5">
                <div id="residentSemester_list">
                    @foreach($semesters as $semester) 
                        @php
                            $residentCount = $residents->where('semester_id', $semester->id)->count();
                        @endphp
                        <div class="example resident_semester_card mb-3 {{$semester->is_active ? 'border-primary' : 'border-secondary'}}">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="col-12 p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4 class="mb-2 me-auto">Resident {{ $semester->name }}</h4>
                                            <div>
                                                <a href="{{ route('mainresident', $semester->id) }}" class="btn btn-sm btn-info">
                                                    Process
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fs-5 text-secondary">Total Residents:</span>
                                            <span class="fs-2 fw-bold">{{ $residentCount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($semesters->isEmpty())
                        <div class="alert alert-warning text-center">
                            No Semester Found.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- Feather Icons JS (make sure you have this included somewhere in your layout) -->
<script>
    feather.replace();
</script>

<script>
    $(document).ready(function() {
        $('#resident_semester_input').on('keyup', function () {
            const normalizeText = (text) => text.toLowerCase().trim().replace(/\s+/g, ' ');
            const keyword = normalizeText($(this).val());
            console.log('Search keyword:', keyword);

            $('.resident_semester_card').each(function () {
                const title = normalizeText($(this).find('h4').text());
                const description = normalizeText($(this).find('.description-text').text());
                const matches = title.includes(keyword) || description.includes(keyword);
                console.log('Title:', title, '| Description:', description, '| Matches:', matches);
                $(this).toggle(matches);
            });
        });
        
        feather.replace(); // Initialize Feather icons

    });
</script>

@endsection
