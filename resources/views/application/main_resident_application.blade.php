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

        </div>
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
                                <td>{{$application->program}}</td>
                                <td>{{$application->year_of_study}}</td>
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $start = $acceptanceStart ? \Carbon\Carbon::parse($acceptanceStart) : null;
                                @endphp

                                <td>
                                    @if($start && $now->gte($start) && $application->application_status === 'approved')
                                        @if($application->acceptance === 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($application->acceptance === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">Not Yet Available</span>
                                    @endif
                                </td>

                                <td>{{ ucwords(str_replace('_', ' ', $application->acceptance)) }}</td>
                                <td><a href="{{route('viewapplication',$application->id)}}"><i class="link-icon" data-feather="eye"></i></a> 
                                    {{-- <a href="{{route('deleteapplication',$application->id)}}" class="text-primary me-2" id="delete"><i data-feather="trash"></i></a></td> --}}
                                    <a href="#" class="text-primary me-2 delete-btn" data-id="{{ $application->id }}" data-url="{{ route('deleteapplication', $application->id) }}"><i data-feather="trash"></i></a>
                                    <button type="button" class="btn btn-link text-primary delete-btn" data-id="{{ $application->id }}" data-url="{{ route('deleteapplication', $application->id) }}" aria-label="Delete Application"><i data-feather="trash"></i></button>
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

