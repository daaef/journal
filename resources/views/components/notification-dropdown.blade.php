<!-- Notification Start -->
<div class="dropdown">
    <button
        class="dropdown-btn shaking-animation text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center notification-bell"
        type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="position-relative">
            <i class="ph ph-bell"></i>
            <span class="alarm-notify position-absolute end-0 notification-badge" style="display: none;"></span>
        </span>
    </button>
    <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
        <div class="card border border-gray-100 rounded-12 box-shadow-custom p-0 overflow-hidden">
            <div class="card-body p-0">
                <div class="py-8 px-24 bg-main-600">
                    <div class="flex-between">
                        <h5 class="text-xl fw-semibold text-white mb-0">Notifications</h5>
                        <div class="flex-align gap-12">
                            <button type="button" id="mark-all-read-btn"
                                class="bg-white rounded-6 text-sm px-8 py-2 hover-text-primary-600">
                                Mark All Read
                            </button>
                            <button type="button"
                                class="close-dropdown hover-scale-1 text-xl text-white"><i
                                    class="ph ph-x"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Notifications Container -->
                <div class="notifications-container max-h-400 overflow-y-auto">
                    <div class="text-center py-20" id="notifications-loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="notifications-list" style="display: none;">
                        <!-- Notifications will be loaded here -->
                    </div>
                    <div id="no-notifications" class="text-center py-20" style="display: none;">
                        <i class="ph ph-bell-slash text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-400 mb-0">No notifications</p>
                    </div>
                </div>

                <a href="{{ 
                    auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer') 
                        ? route('reviewer.notifications.dashboard') 
                        : (auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) 
                            ? route('editor.notifications.dashboard') 
                            : (auth()->user()->hasRole('Admin') 
                                ? route('admin.notifications.dashboard')
                                : route('author.notifications.dashboard')))
                }}"
                    class="py-13 px-24 fw-bold text-center d-block text-primary-600 border-top border-gray-100 hover-text-decoration-underline">
                    View All
                </a>

            </div>
        </div>
    </div>
</div>
<!-- Notification End -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationBell = document.querySelector('.notification-bell');
    const notificationBadge = document.querySelector('.notification-badge');
    const notificationsContainer = document.querySelector('#notifications-list');
    const notificationsLoading = document.querySelector('#notifications-loading');
    const noNotifications = document.querySelector('#no-notifications');
    const markAllReadBtn = document.querySelector('#mark-all-read-btn');

    // Load unread count on page load
    loadUnreadCount();

    // Load notifications when dropdown is opened
    notificationBell.addEventListener('click', function() {
        loadDropdownNotifications();
    });

    // Mark all notifications as read
    markAllReadBtn.addEventListener('click', function() {
        markAllAsRead();
    });

    // Get role-specific route prefix
    function getRoutePrefix() {
        @if(auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer'))
            return '/reviewer';
        @elseif(auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']))
            return '/editor';
        @elseif(auth()->user()->hasRole('Admin'))
            return '/admin';
        @else
            return '/dashboard';
        @endif
    }

    function loadUnreadCount() {
        fetch(`${getRoutePrefix()}/notifications/unread-count`)
            .then(response => response.json())
            .then(data => {
                updateBadge(data.unread_count);
            })
            .catch(error => console.error('Error loading unread count:', error));
    }

    function loadDropdownNotifications() {
        notificationsLoading.style.display = 'block';
        notificationsContainer.style.display = 'none';
        noNotifications.style.display = 'none';

        fetch(`${getRoutePrefix()}/notifications/dropdown`)
            .then(response => response.json())
            .then(data => {
                notificationsLoading.style.display = 'none';

                if (data.notifications.length > 0) {
                    renderNotifications(data.notifications);
                    notificationsContainer.style.display = 'block';
                } else {
                    noNotifications.style.display = 'block';
                }

                updateBadge(data.unread_count);
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                notificationsLoading.style.display = 'none';
                noNotifications.style.display = 'block';
            });
    }

    function renderNotifications(notifications) {
        const html = notifications.map(notification => {
            const readClass = notification.is_read ? 'bg-gray-50' : 'bg-white';
            const unreadIndicator = notification.is_read ? '' : '<span class="w-8 h-8 bg-primary-600 rounded-circle"></span>';

            return `
                <div class="notification-item ${readClass} px-24 py-16 border-bottom border-gray-100 hover-bg-gray-50 cursor-pointer"
                     data-notification-id="${notification.id}" data-action-url="${notification.action_url}">
                    <div class="flex-between gap-8">
                        <div class="flex-align gap-12">
                            <div class="w-40 h-40 rounded-circle bg-${notification.color}-100 flex-center text-${notification.color}-600">
                                <i class="ph ${notification.icon}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-sm fw-semibold mb-4">${notification.title}</h6>
                                <p class="text-xs text-gray-600 mb-0">${notification.message}</p>
                                <span class="text-xs text-gray-400">${notification.created_at}</span>
                            </div>
                        </div>
                        <div class="flex-align gap-8">
                            ${unreadIndicator}
                            <button class="mark-read-btn text-gray-400 hover-text-primary-600" data-notification-id="${notification.id}">
                                <i class="ph ph-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        notificationsContainer.innerHTML = html;

        // Add click event listeners
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (!e.target.closest('.mark-read-btn')) {
                    const actionUrl = this.dataset.actionUrl;
                    const notificationId = this.dataset.notificationId;

                    // Mark as read and navigate
                    markAsRead(notificationId, () => {
                        if (actionUrl && actionUrl !== '#') {
                            window.location.href = actionUrl;
                        }
                    });
                }
            });
        });

        // Add click event listeners for mark read buttons
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const notificationId = this.dataset.notificationId;
                markAsRead(notificationId);
            });
        });
    }

    function markAsRead(notificationId, callback = null) {
        fetch(`${getRoutePrefix()}/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateBadge(data.unread_count);
                loadDropdownNotifications(); // Refresh the dropdown
                if (callback) callback();
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    function markAllAsRead() {
        fetch(`${getRoutePrefix()}/notifications/mark-all-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateBadge(0);
                loadDropdownNotifications(); // Refresh the dropdown
            }
        })
        .catch(error => console.error('Error marking all notifications as read:', error));
    }

    function updateBadge(count) {
        if (count > 0) {
            notificationBadge.style.display = 'block';
            notificationBadge.textContent = count > 99 ? '99+' : count;
        } else {
            notificationBadge.style.display = 'none';
        }
    }

    // Auto-refresh unread count every 30 seconds
    setInterval(loadUnreadCount, 30000);
});
</script>

<style>
.notification-badge {
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    font-size: 10px;
    min-width: 16px;
    height: 16px;
    line-height: 16px;
    text-align: center;
    top: -4px;
    right: -4px;
}

.notifications-container {
    max-height: 400px;
}

.notification-item {
    transition: background-color 0.2s ease;
}

.notification-item:hover {
    background-color: #f8f9fa !important;
}

.max-h-400 {
    max-height: 400px;
}
</style>
