@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Resident';
@endphp

<div class="page-content">
        <div class="d-flex justify-content-between align-items-center">
            {{Breadcrumbs::render('main_resident', $semester->id)}}
            <a href="{{ route('addresident', $semester->id) }}" class="btn btn-inverse-info mb-2">Add New Resident</a>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Resident {{$semester->name}}</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Room</th>
                                <th>Faculty</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($residents as $key => $resident) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$resident->name}}</td>
                                <td>{{$resident->student_id}}</td>
                                <td>{{$resident->room->name}}</td>
                                <td>{{$resident->faculty}}</td>
                                <td>{{$resident->check_in}}</td>
                                <td>{{$resident->check_out}}</td>
                                <td>
                                    {{-- <a href="{{ route('editresident', ['resident' => $resident->id, 'semester' => $semester->id]) }}">
                                    <i class="link-icon" data-feather="edit"></i></a>
                                    <a href="{{route('viewresident', $resident->id)}}"><i class="link-icon" data-feather="eye"></i></a>
                                    <a href="{{route('deleteresident',$resident->id)}}" class="text-primary me-2" id="delete"><i data-feather="trash"></i></a> --}}
                                    <a href="{{ route('viewresident', $resident->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('editresident', ['resident' => $resident->id, 'semester' => $semester->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('deleteresident',$resident->id) }}" class="btn btn-sm btn-danger" id="delete">Delete</a></td>
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

