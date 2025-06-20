@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Facility Type';
@endphp
<div class="page-content">
        <div class="d-flex justify-content-between align-items-center">
            {{ Breadcrumbs::render('facility_type') }}
            <a href="{{ route('addfacilitytype') }}" class="btn btn-inverse-info mb-2">Add Facility Type</a>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Type of Facility</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($facility_types as $key => $facility_type) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$facility_type->name}}</td>
                                <td><a href="{{route('editfacilitytype',$facility_type->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{route('deletefacilitytype',$facility_type->id)}}" class="btn btn-sm btn-danger" id="delete">Delete</a></td>
                                    {{-- <button type="button" class="btn btn-link p-0 text-danger delete-btn" data-id="{{ $facility_type->id }}" data-url="{{ route('deletefacilitytype', $facility_type->id) }}" aria-label="Delete Facility Type"><i data-feather="trash"></i></button> --}}
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