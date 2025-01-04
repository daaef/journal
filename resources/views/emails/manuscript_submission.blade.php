<!DOCTYPE html>
<html>
<head>
    <title>Manuscript Submission</title>
</head>
<body>
    <h1>Hello, {{ $user->fullname }}</h1>
    @if($role == 'Author')
        <p>You have successfully submitted a manuscript titled "{{ $journal->title }}".</p>
        <p>Please <a href="{{ route('user.submissions') }}">click here</a> to view your submissions.</p>
    @else
        <p>A manuscript titled "{{ $journal->title }}" has been submitted.</p>
        <p>Please <a href="{{ route('dashboard') }}">click here</a> to view your dashboard.</p>
    @endif
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
