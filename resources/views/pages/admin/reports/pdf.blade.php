<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SLAS System Report</title>
    <style>
        body { color: #172033; font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { margin-bottom: 4px; }
        .muted { color: #667085; }
        table { border-collapse: collapse; margin-top: 24px; width: 100%; }
        th, td { border: 1px solid #d0d5dd; padding: 10px 12px; text-align: left; }
        th { background: #f2f4f7; }
    </style>
</head>
<body>
    <h1>SLAS System Report</h1>
    <p class="muted">Generated {{ $generatedAt }}</p>
    <table>
        <thead><tr><th>Record type</th><th>Count</th></tr></thead>
        <tbody>
            @foreach($reportRows as [$label, $count])
                <tr><td>{{ $label }}</td><td>{{ number_format($count) }}</td></tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>