<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Teacher Class Report</title>
    <style>
        body { color: #202a36; font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h1 { margin: 0 0 6px; font-size: 22px; }
        .muted { color: #667085; }
        .meta { margin-bottom: 22px; }
        .summary { margin-bottom: 22px; width: 100%; }
        .summary td { border: 1px solid #d9e0e7; padding: 10px; width: 25%; }
        .summary-label { color: #667085; display: block; font-size: 9px; }
        .summary-value { display: block; font-size: 16px; font-weight: bold; margin-top: 4px; }
        table.report { border-collapse: collapse; width: 100%; }
        .report th, .report td { border: 1px solid #d9e0e7; padding: 8px; text-align: left; }
        .report th { background: #edf3f8; }
        .empty { border: 1px solid #d9e0e7; color: #667085; padding: 18px; text-align: center; }
    </style>
</head>
<body>
    <h1>Teacher Class Report</h1>
    <div class="meta muted">{{ $teacherName }} · Generated {{ $generatedAt }}</div>

    <table class="summary">
        <tr>
            @foreach($reportStats as [$label, $value])
                <td><span class="summary-label">{{ $label }}</span><span class="summary-value">{{ $value }}</span></td>
            @endforeach
        </tr>
    </table>

    <h2>Assigned class summary</h2>
    @if($reportRows->isEmpty())
        <div class="empty">No classes have been assigned to you yet.</div>
    @else
        <table class="report">
            <thead><tr><th>Class</th><th>Code</th><th>Enrolled students</th><th>Attendance rate</th><th>Present or late</th><th>Absent</th><th>Assignments</th></tr></thead>
            <tbody>
                @foreach($reportRows as $row)
                    <tr>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ $row['code'] }}</td>
                        <td>{{ $row['enrolled'] }}</td>
                        <td>{{ $row['attendance_rate'] }}</td>
                        <td>{{ $row['attended'] }}</td>
                        <td>{{ $row['absent'] }}</td>
                        <td>{{ $row['assignments'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <p class="muted">Attendance rate counts present and late marks; excused marks are excluded.</p>
</body>
</html>