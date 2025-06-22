@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Complaint';
@endphp
<div class="page-content">
        <div class="d-flex justify-content-between align-items-center">
            {{-- <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                </ol>
            </nav> --}}
            {{ Breadcrumbs::render('index_complaint') }}

            <a href="{{ route('addcomplaint')}}" class="btn btn-inverse-info mb-2">Add New Complaint</a>
        </div>

        @can('update_complaint')
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <a href="{{route('maincomplaint', ['status'=>'pending'])}}" class="text-decoration-none w-100">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                                Pending
                        </h6>
                        <h3 class="fw-bold text-primary">
                            {{ $complaints->where('status','pending')->count()}} 
                        </h3>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-4 grid-margin stretch-card">
                <a href="{{route('maincomplaint', ['status'=>'in_progress'])}}" class="text-decoration-none w-100">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                                In Progress
                        </h6>
                        <h3 class="fw-bold text-primary">
                            {{ $complaints->where('status','in_progress')->count()}} 
                        </h3>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-4 grid-margin stretch-card">
                <a href="{{route('maincomplaint', ['status'=>'completed'])}}" class="text-decoration-none w-100">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                                Completed
                        </h6>
                        <h3 class="fw-bold text-primary">
                            {{ $complaints->where('status','completed')->count()}} 
                        </h3>
                    </div>
                </div>
                </a>
            </div>
        </div>
        @endcan 

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Complaint</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                {{-- <th>Name</th> --}}
                                <th>ID</th>
                                <th>Name</th>
                                <th>User Type</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($complaints as $key => $complaint) 
                            <tr>
                                <td>{{$key+1}}</td>
                                {{-- <td>{{$complaint->name}}</td> --}}
                                <td>{{$complaint->identify_number}}</td>
                                <td>{{$complaint->name}}</td>
                                <td>{{ucwords(str_replace('_', ' ', $complaint->user->usertype))}}</td>
                                <td>{{ucwords(str_replace('_', '/', $complaint->category))}}</td>
                                <td>{{ucwords(str_replace('_', ' ', $complaint->type))}}</td>
                                <td>{{ucwords(str_replace('_', ' ',$complaint->status))}}</td>
                                <td><a href="{{route('viewcomplaint',$complaint->id)}}" class="btn btn-sm btn-info">View</a> 
                                    @can('update_complaint')
                                    <a href="{{route('editcomplaint',$complaint->id)}}" class="btn btn-sm btn-primary">Response</a>
                                    @endcan
                                    <a href="{{route('downloadcomplaintform',$complaint->id)}}" class="btn btn-sm btn-secondary">Download</a>
                                    <a href="{{route('deletecomplaint',$complaint->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a></td>
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

