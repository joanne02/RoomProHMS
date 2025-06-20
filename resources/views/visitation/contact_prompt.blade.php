<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter Contact Number</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h4 class="mb-3">Enter Your Contact Number</h4>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('visitation.checkContact') }}">
                @csrf
                {{-- <input type="hidden" name="visitation_token" value="{{ $visitationToken }}"> --}}

                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="visitor_contact_no" class="form-control" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
