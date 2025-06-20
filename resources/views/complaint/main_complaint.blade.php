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
            @if ($status == 'pending')
                {{ Breadcrumbs::render('pending_complaint') }}
            @elseif ($status == 'in_progress')
                {{ Breadcrumbs::render('in_progress_complaint') }}
            @else
                {{ Breadcrumbs::render('completed_complaint') }}
            @endif
            <a href="{{ route('addcomplaint')}}" class="btn btn-inverse-info mb-2">Add New Complaint</a>
        </div>

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
                                {{-- <th>Room ID</th> --}}
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
                                <td>{{$complaint->user_id}}</td>
                                {{-- <td>{{$complaint->room_id}}</td> --}}
                                <td>{{$complaint->type}}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</td>
                                <td><a href="{{route('editcomplaint',$complaint->id)}}" class="btn btn-sm btn-primary">Edit</i></a> 
                                    {{-- <a href="{{route('editapplication',$room->id)}}"><i class="link-icon" data-feather="edit"></i></a> --}}
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

