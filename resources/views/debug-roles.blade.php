{{-- Debug User Roles --}}
<div style="background: #f8f9fa; padding: 20px; margin: 20px; border: 1px solid #ddd;">
    <h3>Debug Info</h3>
    <p><strong>User ID:</strong> {{ auth()->user()->uuid ?? 'Not logged in' }}</p>
    <p><strong>User Name:</strong> {{ auth()->user()->fullname ?? 'N/A' }}</p>
    <p><strong>All Roles:</strong> 
        @if(auth()->user() && auth()->user()->roles)
            {{ auth()->user()->roles->pluck('name')->join(', ') }}
        @else
            No roles found
        @endif
    </p>
    <p><strong>hasRole('Reviewer'):</strong> {{ auth()->user()->hasRole('Reviewer') ? 'TRUE' : 'FALSE' }}</p>
    <p><strong>hasRole('Associate Editor'):</strong> {{ auth()->user()->hasRole('Associate Editor') ? 'TRUE' : 'FALSE' }}</p>
    <p><strong>Combined Check:</strong> 
        {{ (auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer')) ? 'TRUE' : 'FALSE' }}
    </p>
    <p><strong>Layout Decision:</strong>
        @if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
            Should use reviewer_layout
        @elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
            Should use editor_layout
        @elseif(auth()->user()->hasRole('Admin'))
            Should use admin_layout
        @else
            Should use general layout
        @endif
    </p>
</div>
