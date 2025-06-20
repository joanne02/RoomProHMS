@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Application';
@endphp
<div class="page-content">
    {{ Breadcrumbs::render('application_details', $application->session_id) }}
    
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Application Details</h6>
                        <form method="POST" action="{{ route('updateapplicationstatus', $application->id) }}" class="forms-sample">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="applicant_name" value="{{$application->name}}" readonly>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Student ID</label>
                                        <input type="text" class="form-control" name="applicant_student_id" value="{{$application->student_id}}" readonly>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="applicant_email" value="{{$application->email}}" readonly>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" name="applicant_gender" id="usergender">
											<option selected disabled>Select Gender</option>
											<option value="male" {{ $application->gender =='male'?'selected':''}}>Male</option>
											<option value="female" {{ $application->gender =='female'?'selected':''}}>Female</option>
										</select>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Faculty</label>
                                        <input type="text" class="form-control" name="applicant_faculty" value="{{$application->faculty}}" readonly>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Program</label>
                                        <input type="text" class="form-control" name="applicant_program" value="{{$application->program}}" readonly>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Year of Study</label>
                                        <input type="text" class="form-control" name="applicant_year_of_study" value="{{$application->year_of_study}}" readonly>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact No</label>
                                        <input type="text" class="form-control" name="applicant_contact_no" value="{{$application->contact_no}}" readonly>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" rows="3" name="applicant_address" placeholder="Address">{{$application->address}}</textarea>
                                        {{-- <input type="text" class="form-control" name="user_name" placeholder="Full Name"> --}}
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Application Reason</label>
                                        <textarea class="form-control" rows="3" name="application_reason" placeholder="Apply Reason">{{$application->application_reason}}</textarea>
                                        {{-- <input type="text" class="form-control" name="user_name" placeholder="Full Name"> --}}
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            @php
                                $roomData = json_decode($application->preferred_room_feature, true);
                            @endphp
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Block</label>
                                        <input type="text" class="form-control" name="applicant_prefered_block" value="{{ $roomData['block'] ?? '' }}" readonly>
                                        {{-- <select class="form-select" name="applicant_prefered_block" id="userblock">
                                            @php
                                                $roomFeature = json_decode($application->preferred_room_feature);
                                            @endphp
                                            <option selected disabled>Select Block</option>
                                            <option value="A" {{ isset($roomFeature->block) && $roomFeature->block =='A'?'selected':''}}>A</option>
                                            <option value="B" {{ isset($roomFeature->block) && $roomFeature->block =='B'?'selected':''}}>B</option>
                                            <option value="C" {{ isset($roomFeature->block) && $roomFeature->block =='C'?'selected':''}}>C</option>
                                            <option value="D" {{ isset($roomFeature->block) && $roomFeature->block =='D'?'selected':''}}>D</option>
                                            <option value="E" {{ isset($roomFeature->block) && $roomFeature->block =='E'?'selected':''}}>E</option>
                                            <option value="F" {{ isset($roomFeature->block) && $roomFeature->block =='F'?'selected':''}}>F</option>
                                            <option value="G" {{ isset($roomFeature->block) && $roomFeature->block =='G'?'selected':''}}>G</option>
                                            <option value="H" {{ isset($roomFeature->block) && $roomFeature->block =='H'?'selected':''}}>H</option>
                                            <option value="I" {{ isset($roomFeature->block) && $roomFeature->block =='I'?'selected':''}}>I</option>
                                            <option value="J" {{ isset($roomFeature->block) && $roomFeature->block =='J'?'selected':''}}>J</option>
                                            <option value="K" {{ isset($roomFeature->block) && $roomFeature->block =='K'?'selected':''}}>K</option>
                                            <option value="L" {{ isset($roomFeature->block) && $roomFeature->block =='L'?'selected':''}}>L</option>
                                            <option value="M" {{ isset($roomFeature->block) && $roomFeature->block =='M'?'selected':''}}>M</option>
                                            <option value="N" {{ isset($roomFeature->block) && $roomFeature->block =='N'?'selected':''}}>N</option>
                                            <option value="O" {{ isset($roomFeature->block) && $roomFeature->block =='O'?'selected':''}}>O</option>
                                            <option value="P" {{ isset($roomFeature->block) && $roomFeature->block =='P'?'selected':''}}>P</option>
                                            <option value="Q" {{ isset($roomFeature->block) && $roomFeature->block =='Q'?'selected':''}}>Q</option>
                                            <option value="R" {{ isset($roomFeature->block) && $roomFeature->block =='R'?'selected':''}}>R</option>
                                            <option value="S" {{ isset($roomFeature->block) && $roomFeature->block =='S'?'selected':''}}>S</option>
                                        </select> --}}
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Floor</label>
                                        <input type="text" class="form-control" name="applicant_prefered_floor" value="{{ $roomData['floor'] ?? '' }}" readonly>
                                        {{-- <select class="form-select" name="applicant_prefered_floor" id="userfloor">
                                            <option selected disabled>Select Floor</option>
                                            <option value="G" {{ isset($roomFeature->floor) && $roomFeature->floor =='G'?'selected':''}}>G</option>
                                            <option value="1" {{ isset($roomFeature->floor) && $roomFeature->floor =='1'?'selected':''}}>1</option>
                                            <option value="2" {{ isset($roomFeature->floor) && $roomFeature->floor =='2'?'selected':''}}>2</option>
                                        </select> --}}
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Room Type</label>
                                        <input type="text" class="form-control" name="applicant_prefered_room_type" value="{{ $roomData['room_type'] ?? '' }}" readonly>
                                        {{-- <select class="form-select" name="applicant_prefered_room_type" id="userroomtype">
                                            <option selected disabled>Select Room Type</option>
                                            <option value="single" {{ isset($roomFeature->room_type) && $roomFeature->room_type =='single'?'selected':''}}>Single Room</option>
                                            <option value="double" {{ isset($roomFeature->room_type) && $roomFeature->room_type =='double'?'selected':''}}>Double Room</option>
                                            <option value="shared" {{ isset($roomFeature->room_type) && $roomFeature->room_type =='shared'?'selected':''}}>Shared Room</option>
                                        </select> --}}
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            @can('approve_application')
                                @if (!in_array($application->application_status, ['approved', 'rejected']))
                                    <div class='d-flex justify-content-end gap-2'>
                                        <!-- Trigger button for Approve modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approveModal">
                                            Approve
                                        </button>

                                        <!-- Reject button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                            Reject
                                        </button>
                                    </div>

                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('updateapplicationstatus', $application->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="approveModalLabel">Confirm Approval</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to approve this application?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Yes, Approve</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endcan

                        </form> 

                        <!-- Rejection Modal -->
                        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('updateapplicationstatus', $application->id) }}"
                                        class="forms-sample"
                                        onsubmit="return confirm('Are you sure you want to reject this application?')">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <input type="hidden" name="id" value="{{ $application->id }}">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejection_reason" class="form-label">Reason for rejection</label>
                                                <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="4" required></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Submit Rejection</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>

    @php

        use Carbon\Carbon;

        $now = now();
        $acceptanceStart = isset($acceptance_start_date) ? Carbon::parse($acceptance_start_date) : null;

        $userType = auth()->user()->usertype ?? 'user';

        $status = 'pending';

        if (in_array($userType, ['staff', 'superadmin']) || ($acceptanceStart && $now->gte($acceptanceStart))) {
            $status = $application->application_status;
        }

    @endphp

    <div class="row mt-3 mb-3">
        <div class="col-md-12">
            <div class="card border 
                @if($status === 'rejected') border-danger 
                @elseif($status === 'approved') border-success 
                @else border-secondary 
                @endif">
                <div class="card-body">
                    <h6 class="card-title">Approval Status</h6>

                    <div class="row mb-2">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <input type="text" id="status" class="form-control" 
                                value="@if($status === 'approved') Approved 
                                    @elseif($status === 'rejected') Rejected 
                                    @else Pending @endif" 
                                readonly>
                        </div>
                    </div>

                    @if($status === 'approved')
                        <div class="row mb-2">
                            <label for="room_allocated" class="col-sm-2 col-form-label">Room Allocated</label>
                            <div class="col-sm-10">
                                <input type="text" id="room_allocated" class="form-control" 
                                    value="{{ $application->room->name ?? 'Not Assigned' }}" 
                                    readonly>
                            </div>
                        </div>
                    @endif

                    @if($status === 'rejected' && $application->rejection_reason)
                        <div class="row mb-2">
                            <label for="rejection_reason" class="col-sm-2 col-form-label">Reason</label>
                            <div class="col-sm-10">
                                <input type="text" id="rejection_reason" class="form-control" 
                                    value="{{ $application->rejection_reason }}" 
                                    readonly>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- @if($acceptanceStart && $now->gte(Carbon::parse($acceptanceStart)) && $application->application_status !== 'rejected') --}}
        <!-- Acceptance Status Card -->
    @if($acceptanceStart && $now->gte(Carbon::parse($acceptanceStart)) && $application->application_status === 'approved')
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="POST" action="{{ route('updateacceptancestatus', $application->id) }}" class="forms-sample">
                    @csrf
                    <input type="hidden" name="acceptance_status" value="accepted">
                    <div class="card border 
                        @if($application->acceptance === 'rejected') border-danger 
                        @elseif($application->acceptance === 'accepted') border-success 
                        @else border-secondary 
                        @endif">
                        <div class="card-body">
                            <h6 class="card-title">Acceptance Status</h6>

                            <div class="row mb-2">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <input type="text" id="status" class="form-control" 
                                        value="@if($application->acceptance === 'accepted') Accepted 
                                                @elseif($application->acceptance === 'rejected') Rejected 
                                                @else Pending @endif" 
                                        readonly>
                                </div>
                            </div>

                            @if($application->acceptance === 'rejected' && $application->acceptance_reject_reason)
                            <div class="row mb-2">
                                <label for="status" class="col-sm-2 col-form-label">Reason</label>
                                <div class="col-sm-10">
                                    <input type="text" id="status" class="form-control" 
                                        value="{{ $application->acceptance_reject_reason }}" 
                                        readonly>
                                    </div>
                                </div>
                            @endif

                            @php
                                $isSessionExpired = $application->session && $application->session->acceptance_end_date < $now;
                            @endphp

                            @can('accept_application')
                            @if($application->acceptance === 'pending' && !$isSessionExpired)
                                <div class='d-flex justify-content-end gap-2'>
                                    <button type="submit" class="btn btn-primary submit">Accept</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectAcceptanceModal">Reject</button>
                                </div>
                            @endif
                            @endcan

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rejection Modal -->
        <div class="modal fade" id="rejectAcceptanceModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('updateacceptancestatus', $application->id) }}" class="forms-sample">
                        @csrf
                        <input type="hidden" name="acceptance_status" value="rejected">
                        <input type="hidden" name="id" value="{{ $application->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Reject Application Offer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">Reason for rejection</label>
                                <textarea class="form-control" name="acceptance_rejection_reason" id="rejection_reason" rows="4" required></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Submit Rejection</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
</div>

@endsection