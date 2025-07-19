@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Semester';
@endphp
<div class="page-content">
        <div class="d-flex justify-content-between align-items-center">
            {{ Breadcrumbs::render('main_semester') }}
            <a href="{{ route('addsemester') }}" class="btn btn-inverse-info mb-2">Create Semester</a>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Semester</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Semester</th>
                                <th>Active Semester</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($semesters as $key => $semester) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$semester->name}}</td>
                                <td>{{ $semester->is_active ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <a href="{{ route('viewsemester', $semester->id) }}" class="btn btn-sm btn-info">View
                                    </a>

                                    <a href="{{ route('editsemester', $semester->id) }}" class="btn btn-sm btn-primary">Edit
                                    </a>

                                    <a href="{{ route('deletesemester', $semester->id) }}" class="btn btn-sm btn-danger" id="delete">Delete
                                    </a>
                                </td>

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