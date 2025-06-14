@if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
<x-layouts.reviewer_layout>
    <x-slot:title>
        Notification Dashboard
    </x-slot:title>
    
    @include('notifications.dashboard-content')
    
</x-layouts.reviewer_layout>

@elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
<x-layouts.editor_layout>
    <x-slot:title>
        Notification Dashboard
    </x-slot:title>
    
    @include('notifications.dashboard-content')
    
</x-layouts.editor_layout>

@else
<x-layouts.layout>
    <x-slot:title>
        Notification Dashboard
    </x-slot:title>
    
    @include('notifications.dashboard-content')
    
</x-layouts.layout>
@endif
