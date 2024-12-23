{{-- Invite reviewer --}}

# Hi {{ $user->fullname }},
{{ $messageBody }}



{{-- <a href="{{route('reviewer.accept', ['token' => 'token'])}}">
    Accept
</a>


<a href="{{route('reviewer.decline', ['token' => 'token'])}}">
    Decline
</a> --}}



Thanks,<br>
{{ config('app.name') }}


