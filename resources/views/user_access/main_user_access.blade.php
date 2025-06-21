@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'User Access';
@endphp

<div class="page-content">
        {{-- <div class="mb-3">
            <div class="row">
                <div class="col-sm-8">
                    <div class="d-flex justify-content-sm-start justify-content-start">
                        <a href="{{ route('addfacilitytype')}}" class="btn btn-inverse-info">Add Facility Type</a>                
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="d-flex justify-content-between align-items-center">
            {{-- <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                </ol>
            </nav> --}}
            {{ Breadcrumbs::render('main_role') }}
            <a href="{{ route('adminroles.create') }}" class="btn btn-inverse-info mb-2">Add New Role</a>
        </div>
        {{-- <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Table</li>
            </ol>
        </nav> --}}

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">User Role</h6>
                
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $key => $role) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$role->title}}</td>
                                {{-- <td><a href="{{route('adminroles.edit',$role->id)}}"><i class="link-icon" data-feather="edit"></i></a> --}}
                                <td>
                                    <a href="{{ route('adminroles.edit', $role->id) }}" class="btn btn-sm btn-primary">Edit Access</a>

                                    <a href="{{ route('adminroles.destroy', $role->id) }}" 
                                    class="btn btn-sm btn-danger" 
                                    id="deleterole" 
                                    data-name="{{ $role->title }}">
                                        Delete Role
                                    </a>
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

<!-- Reusable Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="deleteForm">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong id="deleteItemName">this role</strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#deleterole').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                const url = this.getAttribute('href');
                const name = this.getAttribute('data-name');

                const form = document.getElementById('deleteForm');
                form.setAttribute('action', url);

                document.getElementById('deleteItemName').textContent = name;
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });
    });
</script>

@endsection