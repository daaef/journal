<!-- Notification Dashboard Content -->
<div class="container-fluid">    <!-- Breadcrumb -->
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="{{ 
                auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer') 
                    ? route('reviewer.dashboard') 
                    : (auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) 
                        ? route('editor.dashboard') 
                        : (auth()->user()->hasRole('Admin') 
                            ? route('admin.dashboard')
                            : route('dashboard')))
            }}" class="text-gray-600 fw-normal text-15 hover-text-gray-800">Home</a></li>
            <li><span class="text-gray-400 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-gray-800 fw-normal text-15">Notification Dashboard</span></li>
        </ul>
    </div>

    <!-- Header -->
    <div class="mb-24">
        <h1 class="h2 text-gray-800 mb-8">Notification Dashboard</h1>
        <p class="text-gray-600 text-15">Manage and view your notifications</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-20 mb-24">
        <div class="col-xxl-3 col-sm-6">
            <div class="card border-0 p-20">
                <div class="card-body p-0">
                    <div class="flex-align gap-16">
                        <div class="w-64 h-64 bg-primary-50 text-primary-600 rounded-16 flex-center text-2xl">
                            <i class="ph ph-bell"></i>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm mb-4">Total Notifications</span>
                            <h4 class="text-gray-800 mb-0">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="card border-0 p-20">
                <div class="card-body p-0">
                    <div class="flex-align gap-16">
                        <div class="w-64 h-64 bg-danger-50 text-danger-600 rounded-16 flex-center text-2xl">
                            <i class="ph ph-envelope"></i>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm mb-4">Unread</span>
                            <h4 class="text-gray-800 mb-0">{{ $stats['unread'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="card border-0 p-20">
                <div class="card-body p-0">
                    <div class="flex-align gap-16">
                        <div class="w-64 h-64 bg-success-50 text-success-600 rounded-16 flex-center text-2xl">
                            <i class="ph ph-calendar"></i>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm mb-4">Today</span>
                            <h4 class="text-gray-800 mb-0">{{ $stats['today'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="card border-0 p-20">
                <div class="card-body p-0">
                    <div class="flex-align gap-16">
                        <div class="w-64 h-64 bg-purple-50 text-purple-600 rounded-16 flex-center text-2xl">
                            <i class="ph ph-clock"></i>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm mb-4">This Week</span>
                            <h4 class="text-gray-800 mb-0">{{ $stats['this_week'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- Filters -->
    <div class="card border mb-24">
        <div class="card-header bg-gray-50 border-bottom">
            <h5 class="mb-0 text-gray-800">
                <i class="ph ph-funnel me-12"></i>Filter Notifications
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ 
                auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer') 
                    ? route('reviewer.notifications.dashboard') 
                    : (auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) 
                        ? route('editor.notifications.dashboard') 
                        : (auth()->user()->hasRole('Admin') 
                            ? route('admin.notifications.dashboard')
                            : route('author.notifications.dashboard')))
            }}" class="row g-20">
                <div class="col-md-4">
                    <label for="type" class="form-label text-gray-700 fw-semibold">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="all" {{ request('type', 'all') === 'all' ? 'selected' : '' }}>All Types</option>
                        @foreach($notificationsByType as $type => $count)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }} ({{ $count }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="status" class="form-label text-gray-700 fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="" {{ request('status') === '' ? 'selected' : '' }}>All</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    </select>
                </div>
                
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary px-20">
                        <i class="ph ph-check me-8"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>    <!-- Notifications List -->
    <div class="card border">
        <div class="card-header bg-gray-50 border-bottom">
            <h5 class="mb-0 text-gray-800">
                <i class="ph ph-list me-12"></i>Notifications
            </h5>
        </div>
        
        @if($notifications->count() > 0)
            <div class="card-body p-0">
                @foreach($notifications as $notification)
                    <div class="p-20 border-bottom {{ !$notification['is_read'] ? 'bg-primary-25' : '' }} hover-bg-gray-25 transition-300">
                        <div class="flex-align gap-16">
                            <div class="w-48 h-48 bg-{{ $notification['color'] }}-50 text-{{ $notification['color'] }}-600 rounded-circle flex-center">
                                <i class="{{ $notification['icon'] }} text-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="flex-between align-items-start mb-8">
                                    <div class="flex-align gap-8">
                                        <h6 class="text-gray-800 mb-0">{{ $notification['title'] }}</h6>
                                        @if(!$notification['is_read'])
                                            <span class="badge bg-primary-600 text-white px-8 py-2 text-xs">
                                                New
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-align gap-12">
                                        <span class="text-gray-500 text-sm">{{ $notification['created_at']->diffForHumans() }}</span>
                                        @if(!$notification['is_read'])
                                            <button onclick="markAsRead('{{ $notification['id'] }}')" 
                                                    class="btn btn-sm btn-outline-primary px-12 py-4">
                                                Mark as read
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-gray-600 text-15 mb-12">{{ $notification['message'] }}</p>
                                
                                @if($notification['journal_title'])
                                    <div class="mb-12">
                                        <span class="badge bg-gray-100 text-gray-700 px-12 py-6 text-sm">
                                            Journal: {{ $notification['journal_title'] }}
                                        </span>
                                    </div>
                                @endif
                                
                                @if($notification['action_url'] && $notification['action_url'] !== '#')
                                    <div>
                                        <a href="{{ $notification['action_url'] }}" 
                                           class="text-primary-600 hover-text-primary-700 text-sm fw-medium">
                                            View Details <i class="ph ph-arrow-right ms-4"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="card-footer bg-gray-50 border-top">
                    <div class="d-flex justify-content-center">
                        {{ $notifications->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="card-body text-center py-80">
                <i class="ph ph-bell-slash text-6xl text-gray-400 mb-16"></i>
                <h5 class="text-gray-800 mb-8">No notifications found</h5>
                <p class="text-gray-600">
                    @if(request()->hasAny(['type', 'status']))
                        Try adjusting your filters to see more notifications.
                    @else
                        You're all caught up! New notifications will appear here.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<script>
function markAsRead(notificationId) {
    // Determine the correct route based on user role
    let routePrefix = '';
    @if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
        routePrefix = '/reviewer';
    @elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
        routePrefix = '/editor';
    @elseif(auth()->user()->hasRole('Admin'))
        routePrefix = '/admin';
    @else
        routePrefix = '/dashboard';
    @endif
    
    fetch(`${routePrefix}/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}
</script>
