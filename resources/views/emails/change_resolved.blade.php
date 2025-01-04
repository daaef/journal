<!DOCTYPE html>
<html>
<head>
    <title>Journal Change Resolved</title>
</head>
<body>
    <h1>Journal Change Resolved Notification</h1>
    <p>Hello {{ $journal->editor->name }},</p>
    <p>The author of "{{ $journal->title }}" has addressed the requested changes:</p>
    <ul>
        @foreach($changes as $change)
            @if($change['status'] === 'resolved')
                <li>
                    <strong>{{ ucfirst($change['field']) }}</strong>: Updated as requested.
                </li>
            @endif
        @endforeach
    </ul>
    <p>Thank you for your review.</p>
</body>
</html>
