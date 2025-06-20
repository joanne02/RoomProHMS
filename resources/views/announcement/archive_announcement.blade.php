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
                <label for="announcement_input" class="form-label mb-0">Announcements:</label>
                <input type="text" class="form-control" id="announcement_input" placeholder="Search announcements">
            </div>
            <!-- Add Announcement Button -->     
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
        </div>

        {{ Breadcrumbs::render('archive_announcement') }}
        
        <hr>

        <div class="row">
            <div class="col-xl-12 main-content ps-xl-4 pe-xl-5">
                <div id="announcement_list">
                    @foreach($announcements as $announcement)
                        <div class="example announcement_card mb-3" data-status="{{ $announcement->status }}">
                            <div class="d-flex align-items-start">
                                <div class="col-12 p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-2 me-auto">{{ $announcement->title }}</h4>
                                        {{-- <div>
                                            <a href="{{ route('editannouncement', $announcement->id) }}" class="text-primary me-2">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a href="{{ route('deleteannouncement', $announcement->id) }}" class="text-danger delete-btn" data-id="{{ $announcement->id }}">
                                                <i data-feather="trash"></i>
                                            </a>
                                        </div> --}}
                                        <div class="dropdown">
                                            <button class="btn p-0 border-0 bg-transparent" type="button" id="announcementOptions{{ $announcement->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical"></i> {{-- Three-dot icon --}}
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="announcementOptions{{ $announcement->id }}">
                                                <li>
                                                    <a class="dropdown-item unarchive-btn" href="javascript:void(0);" data-id="{{ $announcement->id }}">
                                                        <i data-feather="archive" class="me-2"></i> Unarchive
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
                                    </div>

                                    <div class="row mb-2">
                                        <p class="col-auto mb-0 fw-bold">Description:</p>
                                        <p class="col-10 mb-0">{{ $announcement->description }}</p>
                                    </div>

                                    @if ($announcement->attachment)
                                        @php
                                            $attachmnets = json_decode($announcement->attachment, true);
                                        @endphp

                                        <div class="row mb-2">
                                            <p class="col-auto mb-0 fw-bold">Attachment:</p>
                                            <div class="col mb-0">
                                                @foreach($attachmnets as $index => $attachment)
                                                    <img
                                                        src="{{ asset('storage/' . $attachment) }}"
                                                        alt="Attachment"
                                                        class="img-fluid"
                                                        style="max-width: 100px; max-height: 100px; margin-top: 5px; cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#imageModal{{ $index }}">

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $index }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-0">
                                                                    <img src="{{ asset('storage/' . $attachment) }}" class="img-fluid w-100" alt="Expanded Image">
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
        </div>

    </div>
</div>

{{-- Include Select2 and jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

{{-- Include Feather Icons --}}
<script src="https://unpkg.com/feather-icons"></script>


<div class="modal fade" id="unarchiveConfirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Unarchive</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to unarchive this announcement?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmUnarchive">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

    let announcementId; // Declare a scoped variable

    // Set the ID when "Unarchive" is clicked
    $(document).on('click', '.unarchive-btn', function() {
        announcementId = $(this).data('id');
        $('#unarchiveConfirmationModal').modal('show');
    });

    // Use the ID when "Confirm" is clicked
    $('#confirmUnarchive').on('click', function() {
        if (!announcementId) {
            alert('No announcement selected.');
            return;
        }

    $.ajax({
        url: "{{ route('updatestatus') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: announcementId,
            status: 'published'  // Set to 'published' or your intended status
        },
        success: function(response) {
            console.log('Unarchive successful:', response);
            location.reload();  // Refresh the list
        },
        error: function(xhr, status, error) {
            console.error('Failed to unarchive:', error);
            alert('Failed to unarchive the announcement.');
        }
    });

    $('#unarchiveConfirmationModal').modal('hide');
    });

    
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

        feather.replace();
    });

</script>
@endsection
