@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Room'
@endphp

<div class="page-content">
        <div class="d-flex justify-content-between align-items-center">
            {{-- <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                </ol>
            </nav> --}}
            {{ Breadcrumbs::render('room') }}
            <a href="{{ route('addroom') }}" class="btn btn-inverse-info mb-2">Add New Room</a>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Rooms</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Block</th>
                                <th>Floor</th>
                                <th>House</th>
                                <th>House Name</th>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Gender</th>
                                <th>Occupy</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rooms as $key => $room) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$room->name}}</td>
                                <td>{{$room->block}}</td>
                                <td>{{$room->floor}}</td>
                                <td>{{$room->house}}</td>
                                <td>{{$room->house_name}}</td>
                                <td>{{$room->room}}</td>
                                <td>{{$room->type}}</td>
                                <td>{{$room->capacity}}</td>
                                <td>{{ucwords(str_replace('_', ' ', $room->gender))}}</td>
                                <td>{{$room->occupy}}</td>
                                <td>{{ucwords(str_replace('_', ' ', $room->status ))}}</td>
                                <td>{{$room->remark}}</td>
                                <td><a href="{{route('editroom',$room->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{route('deleteroom',$room->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a></td>
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

