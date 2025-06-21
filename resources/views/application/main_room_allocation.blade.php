@extends('admin.admin_dashboard')
@section('admin')

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

@php
    $pageTitle = 'Room Allocation';
@endphp

<div class="page-content">
    <div class="container">
        {{-- Search Bar --}}
        <div class="row mb-3">
            <div class="col-sm-8 d-flex align-items-center gap-2">
                <label for="room_allocation_input" class="form-label mb-0">Search:</label>
                <input type="text" class="form-control" id="room_allocation_input" placeholder="Search by batch or application count">
            </div>
        </div>

        <hr>
        {{-- Breadcrumb (optional) --}}
        {{ Breadcrumbs::render('room_allocation', $session_id->id) }}

        {{-- Session Information --}}

        {{-- Batch Cards --}}
        @foreach($chunks as $index => $chunk)
            @php
                $chunkNumber = $index + 1;
                $status = $statuses[$chunkNumber] ?? null;
                $matchPercentage = $matchPercentages->get($chunkNumber, null);
            @endphp

            <div class="col-md-12 mb-3">
                <div class="card border shadow-sm h-100 room_allocation_card">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Batch {{ $chunkNumber }}</h5>
                                @if ($status)
                                    @if ($status->is_confirmed)
                                        <span class="badge bg-success">Completed</span>
                                    @elseif ($status->is_running)
                                        <span class="badge bg-primary">Running</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">No Status</span>
                                @endif

                            </div>
                            <p class="mb-2 text-muted fs-5">
                                Applications in this batch:
                                <span class="fw-bold text-info fs-3">{{ $chunk->count() }}</span>
                            </p>

                            {{-- Show status if available --}}      

                            {{-- Show percentage if available --}}
                            @if (!is_null($matchPercentage))
                                        <div class="mb-2">
                                            <p class="mb-1 fs-5">Match Percentage:</p>
                                            <div class="progress" style="height: 24px;">
                                                <div class="progress-bar 
                                                            @if($matchPercentage >= 80)
                                                                bg-success
                                                            @elseif($matchPercentage >= 50)
                                                                bg-info
                                                            @elseif($matchPercentage >= 30)
                                                                bg-warning
                                                            @else
                                                                bg-danger
                                                            @endif"
                                                    role="progressbar"
                                                    style="width: {{ $matchPercentage }}%; font-size: 1rem;"
                                                    aria-valuenow="{{ $matchPercentage }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $matchPercentage }}%
                                                </div>
                                            </div>
                                        </div>
                            @else
                                <p class="text-muted fst-italic fs-5">Match percentage not available</p>
                            @endif
                        </div>

                        <div class="mt-auto text-end">
                            <a href="{{ route('roomallocationbatch', ['session_id' => $session_id->id, 'chunk_index' => $chunkNumber]) }}"
                            class="btn btn-sm btn-outline-primary">
                                {{ $status && $status->is_confirmed ? 'View Details' : 'Start Allocation' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    feather.replace(); // Initialize Feather icons

    $(document).ready(function() {
        $('#room_allocation_input').on('keyup', function () {
            const normalizeText = (text) => text.toLowerCase().trim().replace(/\s+/g, ' ');
            const keyword = normalizeText($(this).val());

            $('.room_allocation_card').each(function () {
                const title = normalizeText($(this).find('h4').text());
                const appCount = normalizeText($(this).find('.fw-bold').text());
                const matches = title.includes(keyword) || appCount.includes(keyword);
                $(this).toggle(matches);
            });
        });
    });
</script>

@endsection
