@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'User';
@endphp
<div class="page-content">
        <div class="d-flex justify-content-between align-items-center">
            {{-- <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                </ol>
            </nav> --}}

            {{ Breadcrumbs::render('user') }}

            <a href="{{ route('adduser') }}" class="btn btn-inverse-info mb-2">Create User</a>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">User</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>ID</th>
                                <th>User Type</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key => $user) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->user_id}}</td>
                                <td>{{ucwords(str_replace('_', ' ', $user->usertype))}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{ucwords(str_replace('_',' ', $user->status))}}</td>
                                <td><a href="{{route('edituser',$user->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{route('deleteuser',$user->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a></td>
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