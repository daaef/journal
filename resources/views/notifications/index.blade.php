<x-layouts.admin_layout title="Notifications">
<x-slot name="slot">
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Notifications</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Notifications</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">All Notifications</h5>
            <div class="d-flex gap-2">
                <button type="button" id="mark-all-read" class="btn btn-primary btn-sm">
                    <i class="ph ph-check"></i> Mark All Read
                </button>
                <button type="button" id="delete-read" class="btn btn-outline-danger btn-sm">
                    <i class="ph ph-trash"></i> Delete Read
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Tabs -->
            <ul class="nav nav-pills mb-4" id="notificationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all-notifications"
                            type="button" role="tab" aria-controls="all-notifications" aria-selected="true">
                        All
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="unread-tab" data-bs-toggle="pill" data-bs-target="#unread-notifications"
                            type="button" role="tab" aria-controls="unread-notifications" aria-selected="false">
                        Unread <span class="badge bg-primary ms-1" id="unread-count">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="read-tab" data-bs-toggle="pill" data-bs-target="#read-notifications"
                            type="button" role="tab" aria-controls="read-notifications" aria-selected="false">
                        Read
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="notificationTabContent">
                <div class="tab-pane fade show active" id="all-notifications" role="tabpanel" aria-labelledby="all-tab">
                    <div id="notifications-container">
                        <div class="text-center py-5" id="loading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>                <div class="tab-pane fade" id="unread-notifications" role="tabpanel" aria-labelledby="unread-tab">
                    <div class="text-center py-5" id="unread-loading" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="unread-notifications-container">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
                <div class="tab-pane fade" id="read-notifications" role="tabpanel" aria-labelledby="read-tab">
                    <div class="text-center py-5" id="read-loading" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="read-notifications-container">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4" id="pagination-container">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let currentFilter = 'all';

    // Load notifications on page load
    loadNotifications();

    // Tab switching
    document.querySelectorAll('#notificationTabs button').forEach(tab => {
        tab.addEventListener('click', function() {
            currentFilter = this.id.replace('-tab', '');
            currentPage = 1;
            loadNotifications();
        });
    });

    // Mark all as read
    document.getElementById('mark-all-read').addEventListener('click', function() {
        markAllAsRead();
    });

    // Delete read notifications
    document.getElementById('delete-read').addEventListener('click', function() {
        deleteReadNotifications();
    });    function loadNotifications(page = 1) {
        currentPage = page;

        // Determine which container to use based on current filter
        let containerId, loadingId;
        if (currentFilter === 'unread') {
            containerId = 'unread-notifications-container';
            loadingId = 'unread-loading';
        } else if (currentFilter === 'read') {
            containerId = 'read-notifications-container';
            loadingId = 'read-loading';
        } else {
            containerId = 'notifications-container';
            loadingId = 'loading';
        }

        const container = document.getElementById(containerId);
        const loading = document.getElementById(loadingId) || document.getElementById('loading');

        // Show loading
        if (page === 1) {
            if (loading) loading.style.display = 'block';
            container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        }

        // Determine the correct route based on user role
        let baseUrl;
        @if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
            baseUrl = '{{ route("reviewer.notifications.index") }}';
        @elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
            baseUrl = '{{ route("editor.notifications.index") }}';
        @elseif(auth()->user()->hasRole('Admin'))
            baseUrl = '{{ route("admin.notifications.index") }}';
        @else
            baseUrl = '{{ route("author.notifications.index") }}';
        @endif
        
        let url = `${baseUrl}?page=${page}`;
        if (currentFilter === 'unread') {
            url += '&unread=1';
        } else if (currentFilter === 'read') {
            url += '&read=1';
        }

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (loading) loading.style.display = 'none';
            renderNotifications(data.notifications, currentFilter);
            updateUnreadCount();
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            if (loading) loading.style.display = 'none';
            container.innerHTML = '<div class="alert alert-danger">Error loading notifications</div>';
        });
    }

    function renderNotifications(notifications, filter) {
        const containerId = filter === 'all' ? 'notifications-container' :
                          filter === 'unread' ? 'unread-notifications-container' : 'read-notifications-container';
        const container = document.getElementById(containerId);

        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="ph ph-bell-slash text-6xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No ${filter} notifications</p>
                </div>
            `;
            return;
        }

        const html = notifications.map(notification => {
            const data = notification.data;
            const isRead = notification.read_at !== null;
            const readClass = isRead ? 'bg-light' : 'bg-white border-start border-primary border-3';

            return `
                <div class="notification-card card mb-3 ${readClass}" data-notification-id="${notification.id}">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start gap-3 flex-grow-1">
                                <div class="notification-icon w-48 h-48 rounded-circle bg-${data.color || 'primary'}-100 d-flex align-items-center justify-content-center text-${data.color || 'primary'}-600">
                                    <i class="ph ${data.icon || 'ph-bell'} text-xl"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-2 fw-semibold">${data.title || 'Notification'}</h6>
                                    <p class="mb-2 text-gray-600">${data.message || ''}</p>
                                    <small class="text-muted">${new Date(notification.created_at).toLocaleString()}</small>
                                    ${!isRead ? '<span class="badge bg-primary ms-2">New</span>' : ''}
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                ${data.action_url && data.action_url !== '#' ?
                                    `<button class="btn btn-sm btn-outline-primary view-btn" data-url="${data.action_url}" data-notification-id="${notification.id}">
                                        <i class="ph ph-eye"></i> View
                                    </button>` : ''
                                }
                                ${!isRead ?
                                    `<button class="btn btn-sm btn-outline-success mark-read-btn" data-notification-id="${notification.id}">
                                        <i class="ph ph-check"></i>
                                    </button>` : ''
                                }
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-notification-id="${notification.id}">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        container.innerHTML = html;

        // Add event listeners
        container.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                markAsRead(this.dataset.notificationId);
            });
        });

        container.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteNotification(this.dataset.notificationId);
            });
        });

        container.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const notificationId = this.dataset.notificationId;
                const url = this.dataset.url;

                markAsRead(notificationId, () => {
                    window.location.href = url;
                });
            });
        });
    }

    function markAsRead(notificationId, callback = null) {
        // Determine the correct route prefix based on user role
        let routePrefix;
        @if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
            routePrefix = '/reviewer';
        @elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
            routePrefix = '/editor';
        @elseif(auth()->user()->hasRole('Admin'))
            routePrefix = '/admin';
        @else
            routePrefix = '/dashboard';
        @endif
        
        fetch(`${routePrefix}/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications(currentPage);
                updateUnreadCount();
                if (callback) callback();
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    function markAllAsRead() {
        // Determine the correct route based on user role
        let markAllUrl;
        @if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
            markAllUrl = '{{ route("reviewer.notifications.mark-all-as-read") }}';
        @elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
            markAllUrl = '{{ route("editor.notifications.mark-all-as-read") }}';
        @elseif(auth()->user()->hasRole('Admin'))
            markAllUrl = '{{ route("admin.notifications.mark-all-as-read") }}';
        @else
            markAllUrl = '{{ route("author.notifications.mark-all-as-read") }}';
        @endif
        
        fetch(markAllUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications(currentPage);
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error marking all notifications as read:', error));
    }

    function deleteNotification(notificationId) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`{{ url('notifications') }}/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications(currentPage);
                    updateUnreadCount();
                }
            })
            .catch(error => console.error('Error deleting notification:', error));
        }
    }

    function deleteReadNotifications() {
        if (confirm('Are you sure you want to delete all read notifications?')) {
            // This would require a new endpoint - for now, we'll skip this functionality
            alert('This feature will be implemented in a future update.');
        }
    }

    function updateUnreadCount() {
        // Determine the correct route based on user role
        let routeUrl;
        @if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
            routeUrl = '{{ route("reviewer.notifications.unread-count") }}';
        @elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
            routeUrl = '{{ route("editor.notifications.unread-count") }}';
        @elseif(auth()->user()->hasRole('Admin'))
            routeUrl = '{{ route("admin.notifications.unread-count") }}';
        @else
            routeUrl = '{{ route("author.notifications.unread-count") }}';
        @endif
        
        fetch(routeUrl)
            .then(response => response.json())
            .then(data => {
                document.getElementById('unread-count').textContent = data.unread_count;
            })
            .catch(error => console.error('Error loading unread count:', error));
    }
});
</script>

<style>
.notification-card {
    transition: all 0.3s ease;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.notification-icon {
    min-width: 48px;
    width: 48px;
    height: 48px;
}

.w-48 {
    width: 48px;
}

.h-48 {
    height: 48px;
}
</style>
</x-slot>
</x-layouts.admin_layout>
