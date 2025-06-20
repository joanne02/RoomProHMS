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
    @endphp

    <div class="example room_allocation_card mb-3 border-primary">
        <div class="card-body">
            <div class="d-flex align-items-start">
                <div class="col-12 p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-2 me-auto">Batch {{ $chunkNumber }}</h4>
                        <div>
                            @if ($status && $status->is_confirmed)
                                <a href="{{ route('roomallocationbatch', ['session_id' => $session_id->id, 'chunk_index' => $chunkNumber]) }}"
                                   class="btn btn-sm btn-info">
                                    Completed
                                </a>
                            @else
                                <a href="{{ route('roomallocationbatch', ['session_id' => $session_id->id, 'chunk_index' => $chunkNumber]) }}"
                                   class="btn btn-sm btn-info">
                                    Process
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-5 text-secondary">Applications in this batch:</span>
                        <span class="fs-2 fw-bold">{{ $chunk->count() }}</span>
                    </div>
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
