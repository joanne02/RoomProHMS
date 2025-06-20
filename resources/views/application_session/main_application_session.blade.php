@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Application';
@endphp
{{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />


<div class="page-content">
    <div class="container">
        <div class="row mb-3">
            <!-- Application Session Filter -->
            <div class="col-sm-8 d-flex align-items-center gap-2">
                <label for="applicationSession" class="form-label mb-0">Application Session:</label>
                <input type="text" class="form-control" id="applicationSession" placeholder="Search Application Session">
            </div>
            <!-- Add Facility Button -->
            @can('create_application_session')
            <div class="col-sm-4 d-flex justify-content-end align-items-end">
                <a href="{{route('addapplicationsession')}}" class="btn btn-inverse-info">Create New Application Session</a>
            </div>
            @endcan
        </div>
        <hr>

        {{ Breadcrumbs::render('application_session')}}

        <div class="row">
            <div class="col-xl-10 main-content ps-xl-4 pe-xl-4">
                <div id="applicationSession_list">
                    @foreach($session_lists->sortByDesc('created_at') as $session_list)
                        <div class="example application_session_card mb-3 {{ $session_list->is_active ? 'border-primary' : 'border-secondary' }}">
                            <div class="d-flex align-items-start">
                                <div class="col-12 p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-2 me-auto">{{ $session_list->session_name }}</h4>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('editapplicationsession', $session_list->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                Edit
                                            </a>
                                            <a href="{{ route('deleteapplicationsession', $session_list->id) }}" class="btn btn-sm btn-danger" id="delete" title="Delete">
                                                Delete
                                            </a>
                                            <a href="{{ route('mainapplication', $session_list->id) }}" class="btn btn-sm btn-info" title="Process">
                                                Process
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <p class="col-auto mb-0 fw-bold">Application Start Date:</p>
                                        <p class="col mb-0 facility-type">
                                            {{ $session_list->application_start_date ?? 'No Date' }}
                                        </p>
                                    </div>
                                    <div class="row mb-2">
                                        <p class="col-auto mb-0 fw-bold">Application End Date:</p>
                                        <p class="col mb-0">
                                            {{ $session_list->application_end_date ?? 'No Date' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($session_lists->isEmpty())
                        <div class="alert alert-warning text-center">
                            No Session Found.
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


<script>
    $(document).ready(function() {
        

        $('#applicationSession').on('keyup', function () {
            const normalizeText = (text) => text.toLowerCase().trim().replace(/\s+/g, ' ');
            const keyword = normalizeText($(this).val());
            console.log('Search keyword:', keyword);

            $('.application_session_card').each(function () {
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
