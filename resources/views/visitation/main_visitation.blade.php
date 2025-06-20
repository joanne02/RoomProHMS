@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Visitation';
@endphp
<div class="page-content">
        <div class="d-flex justify-content-between mb-2">
            <div class="col-sm-4 d-flex justify-content-start align-items-end">
                {{Breadcrumbs::render('main_visitation')}}
            </div>
            <div class="col-sm-8 d-flex justify-content-end align-items-end gap-2">
                <a href="{{ route('viewvisitationqr') }}" class="btn btn-inverse-info">View QR</a>
                <a href="{{ route('addvisitation')}}" class="btn btn-inverse-info">Add New Visitation</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Visitation</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Contact No</th>
                                <th>Purpose</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($visitations as $key => $visitation) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$visitation->name}}</td>
                                <td>{{$visitation->contact_no}}</td>
                                <td>{{ucwords(str_replace('_', ' ', $visitation->purpose))}}</td>
                                <td>{{$visitation->check_in}}</td>
                                <td>{{$visitation->check_out}}</td>
                                <td>
                                    <a href="{{ route('viewvisitation', $visitation->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('editvisitation', $visitation->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('deletevisitation', $visitation->id) }}" class="btn btn-sm btn-danger" id="delete">Delete</a>
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

