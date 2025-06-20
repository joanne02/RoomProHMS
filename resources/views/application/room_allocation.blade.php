@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Room Allocation Batch';
@endphp
@php
    use App\Models\AllocationStatus;
    $status = AllocationStatus::where('session_id', $session->id)
              ->where('chunk_number', $chunkNumber)
              ->first();
@endphp


<div class="page-content">
    <div class="d-flex justify-content-between align-items-center">
        {{-- {{ Breadcrumbs::render('room_allocation', $session->id) }} --}}
        {{ Breadcrumbs::render('room_allocation_batch', $session->id, $chunkNumber) }}
    </div>

    {{-- Match percentage alert --}}
    @if ($status && $status->overall_match_percentage !== null)
        <div class="alert alert-info mt-3 col-md-6">
            Latest Allocation Match: {{ $status->overall_match_percentage }}%
        </div>
    @endif

    {{-- ===================== Button Row ====================== --}}
    <div class="d-flex justify-content-between flex-wrap gap-2 mb-2 align-items-start">

        {{-- Back Button (Always visible, aligned with any action button) --}}
        <a href="{{ route('roomallocation', $session->id) }}" class="btn btn-secondary">
            Back to All Batches
        </a>

        {{-- Action Buttons --}}
        <div class="d-flex gap-2 flex-wrap justify-content-end">

            @if (!$status || ($status && !$status->is_confirmed && !$status->is_running && $status->overall_match_percentage === null))
                <button type="button"
                    class="btn btn-inverse-info"
                    data-session-id="{{ $session->id }}"
                    data-chunk-number="{{ $chunkNumber }}"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmAllocationModal">
                    Run Room Allocation
                </button>
            @endif

            @if ($status && $status->is_running)
                <button type="button" class="btn btn-secondary d-flex align-items-center gap-2" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Running...
                </button>

                <button type="button"
                    class="btn btn-danger"
                    data-session-id="{{ $session->id }}"
                    data-chunk-number="{{ $chunkNumber }}"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmTerminateModal">
                    Terminate Allocation
                </button>
            @endif

            @if ($status && !$status->is_confirmed && !$status->is_running && $status->overall_match_percentage !== null)
                <button type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmUseAllocationModal"
                    data-chunk-number="{{ $chunkNumber }}">
                    Use This Allocation
                </button>

                <button type="button"
                    class="btn btn-inverse-info"
                    data-session-id="{{ $session->id }}"
                    data-chunk-number="{{ $chunkNumber }}"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmReallocationModal">
                    Re-Allocate This Chunk
                </button>
            @endif

        </div>
    </div>


    {{-- ===================== Modals ====================== --}}

    {{-- Confirm Allocation Modal --}}
    <div class="modal fade" id="confirmAllocationModal" tabindex="-1" aria-labelledby="confirmAllocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('runRoomAllocation') }}">
                @csrf
                <input type="hidden" name="session_id" id="modal-session-id">
                <input type="hidden" name="chunk_number" id="modal-chunk-number"> {{-- ✅ NEW --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Room Allocation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to run the room allocation process?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes, Run Allocation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Confirm Reallocation Modal --}}
    <div class="modal fade" id="confirmReallocationModal" tabindex="-1" aria-labelledby="confirmReallocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('runRoomAllocation') }}">
                @csrf
                <input type="hidden" name="session_id" id="modal-reallocation-session-id">
                <input type="hidden" name="chunk_number" id="modal-reallocation-chunk-number"> {{-- ✅ NEW --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Warning: Re-Allocation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Re-allocating will override the current room assignments. Are you sure?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Re-Allocate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Confirm Use Allocation Modal --}}
    <div class="modal fade" id="confirmUseAllocationModal" tabindex="-1" aria-labelledby="confirmUseAllocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('confirmallocation') }}">
                @csrf
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="chunk_number" id="modal-chunk-number">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Allocation Use</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to confirm and use this room allocation?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes, Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Confirm Terminate Modal --}}
    <div class="modal fade" id="confirmTerminateModal" tabindex="-1" aria-labelledby="confirmTerminateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('terminate-allocation') }}">
                @csrf
                <input type="hidden" name="session_id" id="modal-terminate-session-id" value="{{ $session->id }}">
                <input type="hidden" name="chunk_number" id="modal-terminate-chunk-number">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmTerminateModalLabel">Confirm Termination</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to stop the room allocation process?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Terminate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== Table ====================== --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id='dataTableExample' class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Preferred Room Feature</th>
                            <th>Allocated Room</th>
                            <th>Match %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batchApplications as $app)
                            @php $pref = json_decode($app->preferred_room_feature, true); @endphp
                            <tr>
                                <td>{{ $app->name }}</td>
                                <td>
                                    @if ($pref)
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($pref as $key => $value)
                                                <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $app->room->name ?? '-' }}</td>
                                <td>{{ $app->allocation_match_percentage !== null ? $app->allocation_match_percentage . '%' : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <div class="mt-3">
                <a href="{{ route('roomallocation', $session->id) }}" class="btn btn-secondary">
                    Back to All Batches
                </a>
            </div> --}}
        </div>
    </div>
</div>

{{-- ===================== JavaScript ====================== --}}

<script>
    const allocationModal = document.getElementById('confirmAllocationModal');
    allocationModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const sessionId = button.getAttribute('data-session-id');
        const chunkNumber = button.getAttribute('data-chunk-number'); // ✅
        document.getElementById('modal-session-id').value = sessionId;
        document.getElementById('modal-chunk-number').value = chunkNumber; // ✅
    });

    const reallocationModal = document.getElementById('confirmReallocationModal');
    reallocationModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const sessionId = button.getAttribute('data-session-id');
        const chunkNumber = button.getAttribute('data-chunk-number'); // ✅
        document.getElementById('modal-reallocation-session-id').value = sessionId;
        document.getElementById('modal-reallocation-chunk-number').value = chunkNumber; // ✅
    });

    const useAllocationModal = document.getElementById('confirmUseAllocationModal');
    useAllocationModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const chunkNumber = button.getAttribute('data-chunk-number');
        document.querySelector('#confirmUseAllocationModal input[name="chunk_number"]').value = chunkNumber;
    });

    const terminateModal = document.getElementById('confirmTerminateModal');
    terminateModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const sessionId = button.getAttribute('data-session-id');
        const chunkNumber = button.getAttribute('data-chunk-number');

        document.getElementById('modal-terminate-session-id').value = sessionId;
        document.getElementById('modal-terminate-chunk-number').value = chunkNumber;
    });

</script>


@endsection
