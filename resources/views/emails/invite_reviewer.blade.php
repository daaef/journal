{{-- Invite reviewer --}}

# Hi {{ $user->fullname }},
You have been invited to review a manuscript titled **{{ $journal->title }}**. Please click the button below to accept or decline the invitation.



<a href="{{route('reviewer.accept', ['token' => 'token'])}}">
    Accept
</a>


<a href="{{route('reviewer.decline', ['token' => 'token'])}}">
    Decline
</a>



Thanks,<br>
{{ config('app.name') }}


