@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'User Access';
@endphp

<div class="page-content">
    {{ Breadcrumbs::render('edit_user_access', $role->id) }}
    
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title">Role: {{ $role->name }}</h1>
        </div>
    </div>

    <form action="{{ route('adminroles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Resident</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_resident', 'read_resident', 'update_resident', 'delete_resident'] as $abilityName)
                            <div class="form-check">
                                {{-- <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if($role->abilities->contains('name', $abilityName)) checked @endif> --}}
                                    <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                        @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Announcement</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_announcement', 'read_announcement', 'update_announcement', 'delete_announcement'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Facility</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_facility', 'read_facility', 'update_facility', 'delete_facility'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Facility Type</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_facility_type', 'read_facility_type', 'update_facility_type', 'delete_facility_type'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Room</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_room', 'read_room', 'update_room', 'delete_room'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Visitation</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_visitation', 'read_visitation', 'update_visitation', 'delete_visitation'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Application</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_application', 'read_application', 'update_application', 'delete_application', 'approve_application', 'accept_application'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Application Session</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_application_session', 'read_application_session', 'update_application_session', 'delete_application_session'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Complaint</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_complaint', 'read_complaint', 'update_complaint', 'delete_complaint'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Role</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_role', 'read_role', 'update_role', 'delete_role'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">User</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_user', 'read_user', 'update_user', 'delete_user'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">User Access</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['create_user_access', 'read_user_access', 'update_user_access', 'delete_user_access'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Room Allocation</h4>
                    </div>
                    <div class="card-body">
                        @foreach(['allocate_room'] as $abilityName)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}" 
                                    @if(in_array($abilityName, $assignedAbilityNames)) checked @endif>
                                <label class="form-check-label">
                                    {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Save Permissions</button>
        </div>

    </form>

    {{-- @php
        $modules = [
            'Resident' => ['create_residents', 'read_residents', 'update_residents', 'delete_residents'],
            'Announcement' => ['create_announcement', 'read_announcement', 'update_announcement', 'delete_announcement'],
            'Facility' => ['create_facility', 'read_facility', 'update_facility', 'delete_facility'],
            'Facility Type' => ['create_facility_type', 'read_facility_type', 'update_facility_type', 'delete_facility_type'],
            'Room' => ['create_room', 'read_room', 'update_room', 'delete_room'],
            'Visitation' => ['create_visitation', 'read_visitation', 'update_visitation', 'delete_visitation'],
            'Application' => ['create_application', 'read_application', 'update_application', 'delete_application'],
            'Application Session' => ['create_application_session', 'read_application_session', 'update_application_session', 'delete_application_session'],
            'Complaint' => ['create_complaint', 'read_complaint', 'update_complaint', 'delete_complaint'],
            'Role' => ['create_role', 'read_role', 'update_role', 'delete_role'],
            'User' => ['create_user', 'read_user', 'update_user', 'delete_user'],
            'User Access' => ['create_user_access', 'read_user_access', 'update_user_access', 'delete_user_access'],
            'Room Allocation' => ['allocate_room'],
        ];
    @endphp --}}

    {{-- <form action="{{ route('adminroles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach($modules as $module => $permissions)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">{{ $module }}</h4>
                        </div>
                        <div class="card-body">
                            @foreach($permissions as $abilityName)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="abilities[]" value="{{ $abilityName }}"
                                        @if($role->abilities->contains('name', $abilityName)) checked @endif>
                                    <label class="form-check-label">
                                        {{ ucfirst(str_replace('_', ' ', $abilityName)) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Update Role</button>
        </div>
    </form> --}}

</div>

@endsection
