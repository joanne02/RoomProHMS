@extends('admin.admin_dashboard')
@section('admin')
@php
    $pageTitle = 'Announcement';
@endphp
{{-- Include Select2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="page-content">
    <div class="container">
        <div class="row mb-3">
            <!-- Announcement Filter -->
            <div class="col-sm-8 d-flex align-items-center gap-2">
                <label for="announcement_input" class="form-label mb-0">Search:</label>
                <input type="text" class="form-control" id="announcement_input" placeholder="Search by title or description">
            </div>
            <!-- Add Announcement Button -->
            @can('create_announcement')
            <div class="col-sm-4 d-flex justify-content-end align-items-end">
                <div class="dropdown">
                    <button class="btn btn-inverse-info dropdown-toggle" type="button" id="announcementDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Announcement
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="announcementDropdown">
                        <li><a class="dropdown-item" href="{{ route('draftannouncement')}}">Draft</a></li>
                        <li><a class="dropdown-item" href="{{ route('archiveannouncement')}}">Archived</a></li>
                        <li><a class="dropdown-item" href="{{ route('addannouncement') }}">New Announcement</a></li>
                    </ul>
                </div>
            </div>  
            @endcan          
        </div>

        {{ Breadcrumbs::render('announcement') }}

        <hr>

        <div class="row">
            <div class="col-xl-12 main-content ps-xl-4 pe-xl-5">
                <div id="announcement_list">
                    @foreach($announcements as $announcement)
                        <div class="example announcement_card pl-4 pe-4 pt-3 pb-3 mb-3" data-status="{{ $announcement->status }}">
                            <div class="d-flex align-items-start">
                                <div class="col-12 p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-2 me-auto">{{ $announcement->title }}</h4>
                                        @can('update_announcement')
                                        <div class="dropdown">
                                            <button class="btn p-0 border-0 bg-transparent" type="button" id="announcementOptions{{ $announcement->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical"></i> {{-- Three-dot icon --}}
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="announcementOptions{{ $announcement->id }}">
                                                <li>
                                                    <a class="dropdown-item archive-btn" href="javascript:void(0);" data-id="{{ $announcement->id }}">
                                                        <i data-feather="archive" class="me-2"></i> Archive
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('editannouncement', $announcement->id) }}">
                                                        <i data-feather="edit" class="me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger delete-btn" href="{{ route('deleteannouncement', $announcement->id) }}" id="delete" data-id="{{ $announcement->id }}">
                                                        <i data-feather="trash" class="me-2"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>  
                                        @endcan                                      
                                    </div>

                                    <div class="row mb-2">
                                        <p class="col-auto mb-0 fw-bold">Description:</p>
                                        <p class="col-10 mb-0 description-text">{{ $announcement->description }}</p>
                                    </div>

                                    

                                    @if ($announcement->attachment)
                                        @php
                                            $attachments = json_decode($announcement->attachment, true);
                                        @endphp

                                        <div class="row mb-2">
                                            <p class="col-auto mb-0 fw-bold">Attachment:</p>
                                            <div class="col-10 mb-0">
                                                @foreach($attachments as $index => $attachment)
                            @php
                                $modalId = 'imageModal' . $announcement->id . '_' . $index;
                            @endphp
                            <img
                                src="{{ asset('storage/' . $attachment) }}"
                                alt="Attachment"
                                class="img-fluid"
                                style="max-width: 70px; max-height: 70px; margin-top: 5px; cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#{{ $modalId }}">

                            <!-- Modal -->
                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body p-0 text-center">
                                            <img src="{{ asset('storage/' . $attachment) }}" class="img-fluid mx-auto d-block" style="max-width: 500px;" alt="Expanded Image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                                            </div>
                                        </div>
                                    @endif

                                    @if (
                                            $announcement->status === 'scheduled' &&
                                            \Carbon\Carbon::parse($announcement->scheduled_at)->isFuture() &&
                                            (Auth::user()->usertype === 'staff' || Auth::user()->usertype === 'superadmin')
                                        )
                                            <small class="text-warning d-block mt-1">
                                                This announcement is scheduled to be published on:
                                                <strong>{{ \Carbon\Carbon::parse($announcement->scheduled_at)->format('F j, Y g:i A') }}</strong>
                                            </small>
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
        </div>

    </div>
</div>



{{-- Custom Modal --}}
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Archive</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to archive this announcement?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmArchive">Confirm</button>
            </div>
        </div>
    </div>
</div>

{{-- Include Select2 and jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

{{-- Include Feather Icons --}}
<script src="https://unpkg.com/feather-icons"></script>

<script>
    $(document).ready(function() {
        let announcementId = null; // Store the announcement ID temporarily

        // Open the custom modal when "archive" button is clicked
        $(document).on('click', '.archive-btn', function() {
            announcementId = $(this).data('id');  // Get the announcement ID
            $('#confirmationModal').modal('show');  // Show the modal
        });

        // When the user clicks 'Confirm' on the modal
        $('#confirmArchive').on('click', function() {
            $.ajax({
                url: "{{ route('updatestatus') }}",  // Make sure the route is correct
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",  // CSRF token
                    id: announcementId,
                    status: 'archived'  // New status to update
                },
                success: function(response) {
                    console.log('Archive successful:', response);
                    location.reload();  // Reload the page to reflect changes
                },
                error: function(xhr, status, error) {
                    console.error('Failed to archive:', error);
                    alert('Failed to archive the announcement.');
                }
            });

            $('#confirmationModal').modal('hide');  // Close the modal after confirming
        });

        // $('.select2').select2({
        // theme: 'bootstrap-5',
        // placeholder: 'Select Facility Type',
        // allowClear: true
        // });

        $('#announcement_input').on('keyup', function () {
            const normalizeText = (text) => text.toLowerCase().trim().replace(/\s+/g, ' ');
            const keyword = normalizeText($(this).val());
            console.log('Search keyword:', keyword);

            $('.announcement_card').each(function () {
                const title = normalizeText($(this).find('h4').text());
                const description = normalizeText($(this).find('.description-text').text());
                const matches = title.includes(keyword) || description.includes(keyword);
                console.log('Title:', title, '| Description:', description, '| Matches:', matches);
                $(this).toggle(matches);
            });
        });
        
        feather.replace(); // Initialize Feather icons

    });
</script>

@endsection