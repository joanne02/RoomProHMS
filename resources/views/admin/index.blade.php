@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        {{-- <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
            <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
            <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="printer"></i>
            Print
            </button>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="download-cloud"></i>
            Download Report
            </button>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">New Customers</h6>
                    <div class="dropdown mb-2">
                        <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">3,897</h3>
                        <div class="d-flex align-items-baseline">
                        <p class="text-success">
                            <span>+3.3%</span>
                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                        </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">New Orders</h6>
                    <div class="dropdown mb-2">
                        <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">35,084</h3>
                        <div class="d-flex align-items-baseline">
                        <p class="text-danger">
                            <span>-2.8%</span>
                            <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                        </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Growth</h6>
                    <div class="dropdown mb-2">
                        <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">89.87%</h3>
                        <div class="d-flex align-items-baseline">
                        <p class="text-success">
                            <span>+2.8%</span>
                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                        </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div> <!-- row -->

        <div class="row">
        <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                <h6 class="card-title mb-0">Revenue</h6>
                <div class="dropdown">
                    <a type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                    </div>
                </div>
                </div>
                <div class="row align-items-start">
                <div class="col-md-7">
                    <p class="text-muted tx-13 mb-3 mb-md-0">Revenue is the income that a business has from its normal business activities, usually from the sale of goods and services to customers.</p>
                </div>
                <div class="col-md-5 d-flex justify-content-md-end">
                    <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-primary">Today</button>
                    <button type="button" class="btn btn-outline-primary d-none d-md-block">Week</button>
                    <button type="button" class="btn btn-primary">Month</button>
                    <button type="button" class="btn btn-outline-primary">Year</button>
                    </div>
                </div>
                </div>
                <div id="revenueChart" ></div>
            </div>
            </div>
        </div>
        </div> <!-- row -->

        <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Monthly sales</h6>
                <div class="dropdown mb-2">
                    <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                    </div>
                </div>
                </div>
                <p class="text-muted">Sales are activities related to selling or the number of goods or services sold in a given time period.</p>
                <div id="monthlySalesChart"></div>
            </div> 
            </div>
        </div>
        <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Cloud storage</h6>
                <div class="dropdown mb-2">
                    <a type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                    </div>
                </div>
                </div>
                <div id="storageChart"></div>
                <div class="row mb-3">
                <div class="col-6 d-flex justify-content-end">
                    <div>
                    <label class="d-flex align-items-center justify-content-end tx-10 text-uppercase fw-bolder">Total storage <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
                    <h5 class="fw-bolder mb-0 text-end">8TB</h5>
                    </div>
                </div>
                <div class="col-6">
                    <div>
                    <label class="d-flex align-items-center tx-10 text-uppercase fw-bolder"><span class="p-1 me-1 rounded-circle bg-primary"></span> Used storage</label>
                    <h5 class="fw-bolder mb-0">~5TB</h5>
                    </div>
                </div>
                </div>
                <div class="d-grid">
                <button class="btn btn-primary">Upgrade storage</button>
                </div>
            </div>
            </div>
        </div>
        </div> <!-- row -->

        <div class="row">
        <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Inbox</h6>
                <div class="dropdown mb-2">
                    <a type="button" id="dropdownMenuButton6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                    </div>
                </div>
                </div>
                <div class="d-flex flex-column">
                <a href="javascript:;" class="d-flex align-items-center border-bottom pb-3">
                    <div class="me-3">
                    <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Leonardo Payne</h6>
                        <p class="text-muted tx-12">12.30 PM</p>
                    </div>
                    <p class="text-muted tx-13">Hey! there I'm available...</p>
                    </div>
                </a>
                <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                    <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Carl Henson</h6>
                        <p class="text-muted tx-12">02.14 AM</p>
                    </div>
                    <p class="text-muted tx-13">I've finished it! See you so..</p>
                    </div>
                </a>
                <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                    <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Jensen Combs</h6>
                        <p class="text-muted tx-12">08.22 PM</p>
                    </div>
                    <p class="text-muted tx-13">This template is awesome!</p>
                    </div>
                </a>
                <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                    <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Amiah Burton</h6>
                        <p class="text-muted tx-12">05.49 AM</p>
                    </div>
                    <p class="text-muted tx-13">Nice to meet you</p>
                    </div>
                </a>
                <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                    <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                        <p class="text-muted tx-12">01.19 AM</p>
                    </div>
                    <p class="text-muted tx-13">Hey! there I'm available...</p>
                    </div>
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-7 col-xl-8 stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Projects</h6>
                <div class="dropdown mb-2">
                    <a type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                    </div>
                </div>
                </div>
                <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="pt-0">#</th>
                        <th class="pt-0">Project Name</th>
                        <th class="pt-0">Start Date</th>
                        <th class="pt-0">Due Date</th>
                        <th class="pt-0">Status</th>
                        <th class="pt-0">Assign</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>NobleUI jQuery</td>
                        <td>01/01/2022</td>
                        <td>26/04/2022</td>
                        <td><span class="badge bg-danger">Released</span></td>
                        <td>Leonardo Payne</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>NobleUI Angular</td>
                        <td>01/01/2022</td>
                        <td>26/04/2022</td>
                        <td><span class="badge bg-success">Review</span></td>
                        <td>Carl Henson</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>NobleUI ReactJs</td>
                        <td>01/05/2022</td>
                        <td>10/09/2022</td>
                        <td><span class="badge bg-info">Pending</span></td>
                        <td>Jensen Combs</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>NobleUI VueJs</td>
                        <td>01/01/2022</td>
                        <td>31/11/2022</td>
                        <td><span class="badge bg-warning">Work in Progress</span>
                        </td>
                        <td>Amiah Burton</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>NobleUI Laravel</td>
                        <td>01/01/2022</td>
                        <td>31/12/2022</td>
                        <td><span class="badge bg-danger">Coming soon</span></td>
                        <td>Yaretzi Mayo</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>NobleUI NodeJs</td>
                        <td>01/01/2022</td>
                        <td>31/12/2022</td>
                        <td><span class="badge bg-primary">Coming soon</span></td>
                        <td>Carl Henson</td>
                    </tr>
                    <tr>
                        <td class="border-bottom">3</td>
                        <td class="border-bottom">NobleUI EmberJs</td>
                        <td class="border-bottom">01/05/2022</td>
                        <td class="border-bottom">10/11/2022</td>
                        <td class="border-bottom"><span class="badge bg-info">Pending</span></td>
                        <td class="border-bottom">Jensen Combs</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div> 
            </div>
        </div>
        </div> <!-- row --> --}}

    {{-- <div class="container my-4"> --}}
    @php
    $user = Auth::user();
@endphp

<div class="card shadow">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12 main-content ps-xl-4 pe-xl-4">
                {{-- Announcements: visible to both admin and resident --}}
                {{-- @can('read_announcement') --}}
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4>Announcements</h4>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center" id="announcement_list">
                        @foreach($announcements as $announcement)
                                <div class="example announcement_card pl-4 pe-4 pt-2 pb-2 mb-2 w-100" style="max-width: 700px;" data-status="{{ $announcement->status }}">
                                    <div class="d-flex align-items-start">
                                        <div class="col-12 p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="{{ route('mainannouncement') }}" class="text-white text-decoration-none">
                                                <h4 class="mb-2 me-auto">{{ $announcement->title }}</h4></a>
                                            </div>

                                            <div class="row mb-2">
                                                <p class="col-auto mb-0 fw-bold">Description:</p>
                                                <p class="col mb-0 description-text">{{ $announcement->description }}</p>
                                            </div>

                                            @if ($announcement->status === 'scheduled')
                                                @if (\Carbon\Carbon::parse($announcement->scheduled_at)->isFuture())
                                                    @if (Auth::user()->usertype === 'admin')
                                                        <p class="text-warning fw-bold">
                                                            This announcement will be visible to others on: 
                                                            {{ \Carbon\Carbon::parse($announcement->scheduled_at)->format('F j, Y g:i A') }}
                                                        </p>
                                                    @endif
                                                @endif
                                            @endif

                                            @if ($announcement->attachment)
                                                @php
                                                    $attachments = json_decode($announcement->attachment, true);
                                                @endphp

                                                <div class="row mb-2">
                                                    <p class="col-auto mb-0 fw-bold">Attachment:</p>
                                                    <div class="col mb-0 d-flex flex-wrap gap-2">
                                                        @foreach($attachments as $index => $attachment)
                                                            <img src="{{ asset('storage/' . $attachment) }}"
                                                                class="img-fluid"
                                                                style="max-width: 15%; height: auto; object-fit: contain;"
                                                                alt="Expanded Image"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#imageModal{{ $announcement->id }}_{{ $index }}">

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="imageModal{{ $announcement->id }}_{{ $index }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $announcement->id }}_{{ $index }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body p-0">
                                                                            <img src="{{ asset('storage/' . $attachment) }}" class="img-fluid mx-auto d-block" style="max-width: 500px;" alt="Expanded Image">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($announcements->isEmpty())
                                <div class="alert alert-warning text-center">
                                    No Announcement Found.
                                </div>
                            @endif

                    </div>
                </div>
                {{-- @endcan --}}

                {{-- Conditional content for admin --}}
                @if($user->usertype === 'staff' || $user->usertype === 'superadmin')
                    <div class="row g-3 mt-4 mb-3">
                        {{-- Summary Cards --}}
                        {{-- Applications --}}
                        <div class="col-12 col-md-6">
                            <a href="{{ route('indexapplication') }}" class="text-decoration-none">
                                <div class="card bg-success text-white text-center shadow-sm hover-shadow" style="cursor: pointer;">
                                    <div class="card-body">
                                        <h5 class="card-title">Applications</h5>
                                        <h2>{{ $applicationCount }}</h2>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Complaints --}}
                        <div class="col-12 col-md-6 mb-3">
                            <a href="{{ route('indexcomplaint') }}" class="text-decoration-none">
                                <div class="card bg-danger text-white text-center shadow-sm hover-shadow" style="cursor: pointer;">
                                    <div class="card-body">
                                        <h5 class="card-title">New Complaints</h5>
                                        <h2>{{ $complaintCount }}</h2>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Available Rooms --}}
                        <div class="col-12 col-md-4 mt-3 mt-md-0">
                            <a href="{{ route('mainroom') }}" class="text-decoration-none">
                                <div class="card bg-primary text-white text-center shadow-sm hover-shadow" style="cursor: pointer;">
                                    <div class="card-body">
                                        <h5 class="card-title">Available Rooms</h5>
                                        <h2>{{ $availableRoomCount }}</h2>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Today Visitation --}}
                        <div class="col-12 col-md-4 mt-3 mt-md-0">
                            <a href="{{ route('mainvisitation') }}" class="text-decoration-none">
                                <div class="card bg-info text-white text-center shadow-sm hover-shadow" style="cursor: pointer;">
                                    <div class="card-body">
                                        <h5 class="card-title">Today Visitation</h5>
                                        <h2>{{ $visitationCount }}</h2>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Residents --}}
                        <div class="col-12 col-md-4 mt-3 mt-md-0">
                            <a href="{{ route('indexresident') }}" class="text-decoration-none">
                                <div class="card bg-warning text-white text-center shadow-sm hover-shadow" style="cursor: pointer;">
                                    <div class="card-body">
                                        <h5 class="card-title">Residents</h5>
                                        <h2>{{ $residentCount }}</h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @elseif($user->usertype === 'resident')
                    {{-- Add any resident-specific info you want to show here --}}
                    <div class="mt-4">
                        <div class="card shadow">
                            <div class="card-header bg-secondary text-white">
                                <h4><a href="{{ route('mainresidentresident') }}" class="text-white text-decoration-none">
                                    Your Info
                                </a></h4>
                            </div>
                            <div class="card-body">
                                {{-- Example: show resident name, room, semester --}}
                                @php
                                    $resident = $user->resident;
                                @endphp

                                @if($resident)
                                    <p><strong>Name:</strong> {{ $user->username }} ({{ $user->student_id ?? 'N/A'}})</p>
                                    <p><strong>Room:</strong> {{ $resident->room->name ?? 'N/A' }}</p>
                                    <p><strong>Semester:</strong> {{ $resident->semester->name ?? 'N/A' }}</p>
                                @else
                                    <p>No resident record found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                

            </div>
        </div>
    </div>
</div>

    {{-- </div> --}}
</div>


@endsection

                        