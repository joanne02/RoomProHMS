@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Application';
@endphp
<div class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            {{-- <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('main_application')}}">Application</a></li>
                    <li class="breadcrumb-item active" aria-current="page"></li>
                </ol>
            </nav> --}}
            @if(auth()->user()->usertype === 'superadmin' || auth()->user()->usertype === 'staff')
                {{-- Show breadcrumbs only if the user is superadmin or staff --}}
                {{ Breadcrumbs::render('application', $session_id->id) }}
            @else
                {{ Breadcrumbs::render('main_application') }}
            @endif
            {{-- @php
                $hasApplied = $applications->where('user_id', auth()->id())->where('session_id', $session_id->id)->count() > 0;
            @endphp --}}
            
            {{-- <a href="{{ route('addapplication',['id' => $session_id->id]) }}" class="btn btn-inverse-info">Add New Application</a> --}}

        </div>

        @php
            use Illuminate\Support\Carbon;

            $now = Carbon::now();
            $isClosed = false;

            if ($active_session_id) {
                $endDate = Carbon::parse($active_session_id->application_end_date);
                $isClosed = $now->gt($endDate);
            }
        @endphp
        
            @if ($active_session_id)
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="card-title fw-bold fs-3 mb-2">
                                            {{ $active_session_id->session_name }}
                                        </h5>
                                        <p class="mb-0 text-muted">
                                            The hostel application is now open from
                                            <strong>{{ $active_session_id->application_start_date }}</strong> to
                                            <strong>{{ $active_session_id->application_end_date }}</strong>. Apply Now.
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-md-start mt-3 mt-md-0">
                                        @if ($hasApplied)
                                            <span class="text-success fw-semibold">You have already applied. Please wait for the response.</span>
                                        @elseif ($isClosed)
                                            <span class="text-danger fw-semibold">The application period is over.</span>
                                        @elseif ($hasAcceptOffer)
                                            <span class="text-success fw-semibold">
                                                You have already accepted the offer.
                                            </span>
                                        @else
                                        {{-- @can('create_application') --}}
                                        <div class="d-flex justify-content-md-end">
                                            {{-- Show "Add New Application" button only if the application session is not closed --}}
                                            <a href="{{ route('addapplication', ['id' => $active_session_id->id]) }}" class="btn btn-inverse-info">
                                                Add New Application
                                            </a>
                                        </div>
                                        {{-- @endcan --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    There is currently no active application session.
                </div>
            @endif
        

        
        {{-- <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-3">
                            Application Status
                        </h3>
                        @php
                            $application = null;
                            $status = 'Not Applied';
                            if ($session_id) {
                                $application = $applications->where('user_id', auth()->id())
                                                            ->where('session_id', $session_id->id)
                                                            ->first();

                                $status = ucwords($application->application_status ?? 'Not Applied');
                            }
                        @endphp

                        @if ($application)
                            <div class="row mb-3">
                                <label for="applicationStatus" class="col-sm-4 col-form-label">Your Application Status</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control border-success" value="{{ $status }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="acceptanceStatus" class="col-sm-4 col-form-label">Accept the Offer?</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control border-success" value="{{ ucwords(str_replace('_', ' ', $application->acceptance)) }}" readonly>
                                </div>

                                @if (empty($application->acceptance) || $application->acceptance === 'pending')
                                    <div class="col-sm-2 d-flex justify-content-end mt-2 mt-sm-0">
                                        <a href="{{ route('viewapplication', $application->id) }}" class="btn btn-primary">
                                            Accept Offer
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <p class="text-danger">You did not apply for the latest session.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}

        @can('allocate_room')
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <a href="{{ isset($session_id) ? route('roomallocation', ['id' => $session_id->id]) : '#' }}"
                class="text-decoration-none w-100 {{ isset($session_id) ? '' : 'disabled' }}">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            Total Number Of Approved Application
                        </h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold text-primary mb-0">
                                {{ $applications->where('application_status', 'approved')->count() }}
                            </h3>
                            @if (!empty($matchPercentages))
                                <div class="text-end ms-3">
                                    @foreach ($matchPercentages as $chunk => $percent)
                                        <div class="text-muted small">Chunk {{ $chunk }}: {{ $percent }}%</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                </a>
            </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                        Total Available Seat
                                </h6>
                                <h3 class="fw-bold text-primary">
                                    {{ $totalAvailableSeat ?? 0}} 
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Application</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Faculty</th>
                                <th>Program</th>
                                <th>Year</th>
                                <th>Application Status</th>
                                <th>Acceptance</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applications as $key => $application) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$application->name}}</td>
                                <td>{{$application->student_id}}</td>
                                <td>{{$application->faculty}}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $application->program)) }}</td>
                                <td>{{$application->year_of_study}}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $application->application_status)) }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $application->acceptance)) }}</td>
                                <td>
                                    {{-- <a href="{{route('viewapplication',$application->id)}}"><i class="link-icon" data-feather="eye"></i></a> 
                                    <a href="{{route('deleteapplication',$application->id)}}" class="text-primary me-2" id="delete"><i data-feather="trash"></i></a> --}}
                                {{-- If acceptance is empty or pending, show "Accept Offer" button --}}
                                    @if($application->application_status === 'pending')
                                        <!-- Approval still pending: show View -->
                                        <a href="{{ route('viewapplication', $application->id) }}" class="btn btn-sm btn-primary">
                                            View Status
                                        </a>
                                    @elseif($application->application_status === 'approved' && $application->acceptance === 'pending')
                                        <!-- Approval approved and acceptance pending: show Accept Offer -->
                                        <a href="{{ route('viewapplication', $application->id) }}" class="btn btn-sm btn-primary">
                                            Accept Offer
                                        </a>
                                    @else
                                        <!-- Acceptance is not pending (approved/accepted/rejected/whatever): show View -->
                                        <a href="{{ route('viewapplication', $application->id) }}" class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    @endif

                                    @can('delete_application')
                                    {{-- Optionally keep delete icon if you want --}}
                                    <a href="{{route('downloadapplicationpdf' ,$application->id)}}" class="btn btn-sm btn-secondary">Dowbload</a>
                                    <a href="{{route('deleteapplication',$application->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a>
                                    @endcan
                                </td>
                                    
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>
@endsection

