@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Complaint';
@endphp

<div class="page-content">
    {{ Breadcrumbs::render('response_complaint', $complaint->id) }}
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Complaint Details</h6>

                    {{-- Complaint Info --}}
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">User ID</label>
                            <input type="text" class="form-control" value="{{ $complaint->user->user_id ?? ''}}" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Room</label>
                            <input type="text" class="form-control" value="{{ $complaint->user->room_id ?? ''}}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Complaint Type</label>
                            <input type="text" class="form-control" value="{{ ucwords(str_replace('_', ' ', $complaint->type)) }}" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Submitted At</label>
                            <input type="text" class="form-control" value="{{ $complaint->created_at->format('d M Y, h:i A') }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4" readonly>{{ $complaint->description }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" value="{{ ucwords(str_replace('_',' ', $complaint->status)) }}" readonly>
                        </div>
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4" readonly>{{ $complaint->description }}</textarea>
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label">Images</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $appendixPaths = json_decode($complaint->appendix, true); // Decode the JSON into an array
                            @endphp
                            @foreach($appendixPaths ?? [] as $index => $filePath)
                                <img src="{{ asset('storage/' . $filePath) }}" 
                                    width="120" 
                                    class="rounded border cursor-pointer" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#imageModal{{ $index }}" 
                                    alt="Complaint Image">

                                <!-- Modal for Image Preview -->
                                <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <img src="{{ asset('storage/' . $filePath) }}" class="img-fluid w-100" alt="Full Image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body">
                <h6 class="card-title">Response Timeline</h6>
                <ul class="timeline">
                    <li class="event" data-date="{{ $complaint->created_at->format('d M Y, h:i A') }}">
                        <h3 class="title">Complaint Submitted</h3>
                        <p>{{ $complaint->description }}</p>
                    </li>

                    @php
                        $feedbackList = is_array($complaint->feedback)
                            ? $complaint->feedback
                            : (json_decode($complaint->feedback, true) ?? []);
                    @endphp

                    @foreach($feedbackList as $feedback)
                        <li class="event" data-date="{{ \Carbon\Carbon::parse($feedback['time'])->format('d M Y, h:i A') }}">
                            <h3 class="title">{{ $feedback['feedback'] }}</h3>
                            @if(!empty($feedback['message']))
                                <p>{{ $feedback['message'] }}</p>
                            @endif
                        </li>
                    @endforeach

                </ul>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
