@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'User';
@endphp
<div class="page-content">
    {{Breadcrumbs::render('edit_user',$user->id)}}
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit User</h6>
                        <form method="POST" action="{{route('updateuser', $user->id)}}" class="form-sample">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{old('user_name', $user->username)}}">
                                        @error('user_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control @error('user_email') is-invalid @enderror" name="user_email" value="{{old('user_email',$user->email)}}" readonly>
                                        {{-- @error('user_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">User Type</label>
                                        <select class="form-select @error('user_type') is-invalid @enderror" name="user_type" id="usertype">
											<option selected disabled>Select User Type</option>
											<option value="user" {{$user->usertype == 'user'?'selected':''}}>User</option>
											<option value="admin"{{$user->usertype == 'admin'?'selected':''}}>Admin</option>
											<option value="resident"{{$user->usertype == 'resident'?'selected':''}}>Resident</option>
										</select>
                                        @error('user_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID</label>
                                        <input type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{old('user_id',$user->user_id)}}">
                                        @error('user_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select @error('user_status') is-invalid @enderror" name="user_status" id="userstatus">
											<option selected disabled>Select Status</option>
											<option value="active"{{$user->status == 'active'?'selected':''}}>Active</option>
											<option value="inactive"{{$user->status == 'inactive'?'selected':''}}>Inactive</option>
										</select>
                                        @error('user_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                        <button type="submit" class="btn btn-primary submit">Update User</button>
                        </form> 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection