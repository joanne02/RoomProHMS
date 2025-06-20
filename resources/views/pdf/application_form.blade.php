<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h2>Application Details</h2>
    <table>
        <tr><th>Name</th><td>{{ $application->name }}</td></tr>
        <tr><th>Student ID</th><td>{{ $application->student_id }}</td></tr>
        <tr><th>Email</th><td>{{ $application->email }}</td></tr>
        <tr><th>Gender</th><td>{{ ucfirst($application->gender) }}</td></tr>
        <tr><th>Faculty</th><td>{{ $application->faculty }}</td></tr>
        <tr><th>Program</th><td>{{ $application->program }}</td></tr>
        <tr><th>Year of Study</th><td>{{ $application->year_of_study }}</td></tr>
        <tr><th>Contact No</th><td>{{ $application->contact_no }}</td></tr>
        <tr><th>Address</th><td>{{ $application->address }}</td></tr>
        <tr><th>Room</th><td>{{ $application->room->name ?? 'Not Assigned' }}</td></tr>
        <tr><th>Application Status</th><td>{{ ucfirst($application->status ?? 'Pending') }}</td></tr>
        <tr><th>Acceptance Status</th><td>{{ ucfirst($application->acceptance_status ?? 'Not Reviewed') }}</td></tr>
    </table>

    @php
        $roomData = json_decode($application->preferred_room_feature, true);
    @endphp

    <h3 style="margin-top: 20px;">Preferred Room Feature</h3>
    <table>
        <tr><th>Block</th><td>{{ $roomData['block'] ?? '-' }}</td></tr>
        <tr><th>Floor</th><td>{{ $roomData['floor'] ?? '-' }}</td></tr>
        <tr><th>Room Type</th><td>{{ $roomData['room_type'] ?? '-' }}</td></tr>
    </table>
</body>
</html>
