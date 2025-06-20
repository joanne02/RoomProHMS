@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'User';
@endphp
<div class="page-content">

    {{Breadcrumbs::render('add_user')}}
    
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Create User</h6>
                        <form method="POST" action="{{route('storeuser')}}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" placeholder="Full Name">
                                        @error('user_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email (use siswa email)</label>
                                        <input type="email" class="form-control @error('user_email') is-invalid @enderror" name="user_email" placeholder="Enter email">
                                        @error('user_email')
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
                                        <label class="form-label">User Type</label>
                                        <select class="form-select @error('user_type') is-invalid @enderror" name="user_type" id="usertype">
											<option selected disabled>Select User Type</option>
											<option value="user">User</option>
											<option value="staff">Staff</option>
											<option value="resident">Resident</option>
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
                                        <input type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" placeholder="Enter state">
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
											<option value="active">active</option>
											<option value="inactive">inactive</option>
										</select>
                                        @error('user_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">
                                            Password <small>(Min 8 chars, lowercase, uppercase, special char)</small>
                                        </label>
                                        <div class="input-group">
                                            <input type="password" id="user_password" class="form-control @error('user_password') is-invalid @enderror" name="user_password" placeholder="Password">
                                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                        @error('user_password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div><!-- Row -->
                        <button type="submit" class="btn btn-primary submit">Create User</button>
                        </form> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('user_password');
        const icon = document.getElementById('toggleIcon');

        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>


@endsection