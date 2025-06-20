@extends('admin.admin_dashboard')
@section('admin')
 
@php
    $pageTitle = 'Visitation';
@endphp
<div class="page-content">
    {{ Breadcrumbs::render('view_visitation_qr') }}
    <div class="container d-flex justify-content-center">
        <div class="card shadow p-4 mt-4" style="max-width: 500px; width: 100%;">
            <div class="card-body text-center">
                <h5 class="card-title mb-3">Visitation QR Code</h5>

                <div class="mb-4">
                    {!! $qrSvg !!}
                </div>

                <div class="mb-2">
                    <strong>Form Link:</strong><br>
                    <a href="{{ $qrUrl }}" target="_blank">{{ $qrUrl }}</a>
                </div>

                {{-- <a href="{{ route('visitationpublicform', [], true) }}">URL: {{ route('visitationpublicform', [], true) }}</a> --}}

                <a href="{{ route('downloadqr') }}" class="btn btn-primary">
                    Download QR Code
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
