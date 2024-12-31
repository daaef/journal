<!DOCTYPE html>
<html>
<head>
    <title>Journal Change Requested</title>
</head>
<body>
    <h1>Journal Change Requested Notification</h1>
    <p>Hello {{ $journal->author->name }},</p>
    <p>Editor {{ $journal->editor->name }} has requested changes to your journal "{{ $journal->title }}".</p>
    <ul>
        @foreach($changes as $change)
            <li>
                <strong>{{ ucfirst($change['field']) }}</strong>: {{ $change['comment'] }}
            </li>
        @endforeach
    </ul>
    <p>Please review the requested changes and submit an update.</p>
</body>
</html>
