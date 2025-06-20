<!DOCTYPE html>
<html>
<head>
    <title>Complaint Details</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
        .image { margin-right: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <h2>Complaint Details</h2>

    <div class="section">
        <p><span class="label">User ID:</span> {{ $complaint->user->user_id ?? '' }}</p>
        <p><span class="label">Room:</span> {{ $complaint->user->room_id ?? '' }}</p>
        <p><span class="label">Complaint Type:</span> {{ ucwords(str_replace('_', ' ', $complaint->type)) }}</p>
        <p><span class="label">Submitted At:</span> {{ $complaint->created_at->format('d M Y, h:i A') }}</p>
        <p><span class="label">Status:</span> {{ ucwords(str_replace('_', ' ', $complaint->status)) }}</p>
    </div>

    <div class="section">
        <p><span class="label">Description:</span></p>
        <p>{{ $complaint->description }}</p>
    </div>

    @php
        $appendixPaths = json_decode($complaint->appendix, true);
    @endphp

    @if(!empty($appendixPaths))
        <div class="section">
            <p><span class="label">Images:</span></p>
            @foreach($appendixPaths as $filePath)
                <img src="{{ public_path('storage/' . $filePath) }}" width="150" class="image">
            @endforeach
        </div>
    @endif

    <div class="section">
        <h4>Response Timeline</h4>
        <ul>
            <li><strong>{{ $complaint->created_at->format('d M Y, h:i A') }}:</strong> Complaint Submitted – {{ $complaint->description }}</li>

            @php
                $feedbackList = is_array($complaint->feedback)
                    ? $complaint->feedback
                    : (json_decode($complaint->feedback, true) ?? []);
            @endphp

            @foreach($feedbackList as $feedback)
                <li>
                    <strong>{{ \Carbon\Carbon::parse($feedback['time'])->format('d M Y, h:i A') }}:</strong>
                    {{ $feedback['feedback'] }}
                    @if(!empty($feedback['message']))
                        – {{ $feedback['message'] }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>
