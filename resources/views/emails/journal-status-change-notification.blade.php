<!DOCTYPE html>
<html>
<head>
    <title>Journal Status Change</title>
</head>
<body>
    <h1>Journal Status Change Notification</h1>
    <p>Dear {{ $user->name }},</p>
    <p>{{ $messageBody }}</p>
    <p>Journal Title: {{ $journal->title }}</p>
    <p>Thank you.</p>
</body>
</html>
