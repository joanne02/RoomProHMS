@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Application';
@endphp
<div class="page-content">
    
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">New Application</h6>
                        <form method="POST" action="{{ route('storeapplication') }}" class="forms-sample">
                            <input type="hidden" name="application_session_id" value="{{ $id }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="applicant_name" value="{{auth()->user()->username}}" placeholder="Enter Full Name">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Student ID</label>
                                        <input type="text" class="form-control" name="applicant_student_id" value="{{auth()->user()->user_id}}"placeholder="Enter Student ID">
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="applicant_email" value="{{auth()->user()->email}}" placeholder="Enter Email Address">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" name="applicant_gender" id="usergender">
											<option selected disabled>Select Gender</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Faculty</label>
                                        {{-- <input type="text" class="form-control" name="applicant_faculty" placeholder="Enter Faculty"> --}}
                                        <select class="form-select" name="applicant_faculty" id="userfaculty">
											<option selected disabled>Select Faculty</option>
											<option value="FEB">FEB</option>
											<option value="FE">FE</option>
                                            <option value="FACA">FACA</option>
                                            <option value="FCSHD">FCSHD</option>
                                            <option value="FMHS">FMHS</option>
                                            <option value="FSSH">FSSH</option>
                                            <option value="FRST">FRST</option>
                                            <option value="FCSIT">FCSIT</option>
                                            <option value="FLC">FLC</option>
                                            <option value="FBE">FBE</option>
										</select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Program</label>
                                        <input type="text" class="form-control" name="applicant_program" placeholder="Enter Program">
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Year of Study</label>
                                        <input type="text" class="form-control" name="applicant_year_of_study" placeholder="Enter Year of Study">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact No</label>
                                        <input type="text" class="form-control" name="applicant_contact_no" placeholder="Enter Contact No">
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" rows="3" name="applicant_address" placeholder="Address"></textarea>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Application Reason</label>
                                        <textarea class="form-control" rows="3" name="applicant_reason" placeholder="Application Reason"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Block</label>
                                        <select class="form-select" name="applicant_prefered_block" id="userblock">
                                            <option selected disabled>Select Block</option>
                                            {{-- <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="L">L</option>
                                            <option value="M">M</option>
                                            <option value="N">N</option>
                                            <option value="O">O</option>
                                            <option value="P">P</option>
                                            <option value="Q">Q</option>
                                            <option value="R">R</option>
                                            <option value="S">S</option> --}}
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Floor</label>
                                        <select class="form-select" name="applicant_prefered_floor" id="userfloor">
                                            <option selected disabled>Select Floor</option>
                                            <option value="G">G</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Room Type</label>
                                        <select class="form-select" name="applicant_prefered_room_type" id="userroomtype">
                                            <option selected disabled>Select Room Type</option>
                                            <option value="Single">Single Room</option>
                                            <option value="Double">Double Room</option>
                                            <option value="4-Person">4 Person Room</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class='d-flex justify-content-end gap-2'>
                                <button type="submit" class="btn btn-primary submit">Submit</button>
                                <a href="{{ route('mainresidentapplication', ['id' => $id]) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const availableBlocks = @json($availableBlocks);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const genderSelect = document.getElementById('usergender');
        const blockSelect = document.getElementById('userblock');

        genderSelect.addEventListener('change', function () {
            const selectedGender = this.value;

            // Filter blocks for selected gender
            const filteredBlocks = availableBlocks
                .filter(block => block.gender === selectedGender)
                .map(block => block.block);

            // Clear current options
            blockSelect.innerHTML = '<option selected disabled>Select Block</option>';

            // Add new options
            filteredBlocks.forEach(block => {
                const option = document.createElement('option');
                option.value = block;
                option.textContent = block;
                blockSelect.appendChild(option);
            });

            blockSelect.disabled = filteredBlocks.length === 0;
        });
    });
</script>

@endsection