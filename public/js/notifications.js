// Real-time Notification System
class NotificationSystem {
    constructor() {
        this.unreadCount = 0;
        this.isConnected = false;
        this.connectionRetries = 0;
        this.maxRetries = 5;
        this.retryDelay = 5000; // 5 seconds
        this.soundEnabled = false;
        this.desktopEnabled = false;
        
        this.init();
    }

    init() {
        this.setupElements();
        this.loadUserPreferences();
        this.setupEventListeners();
        this.connectToWebSocket();
        this.requestNotificationPermission();
        this.startPeriodicUpdates();
    }

    setupElements() {
        this.bellIcon = document.querySelector('.notification-bell');
        this.badge = document.querySelector('.notification-badge');
        this.dropdown = document.querySelector('#notifications-list');
        this.unreadCountElements = document.querySelectorAll('[data-unread-count]');
        this.statusIndicator = document.querySelector('#realtime-status');
    }

    loadUserPreferences() {
        // Load from server or localStorage
        const prefs = JSON.parse(localStorage.getItem('notificationPreferences')) || {};
        this.soundEnabled = prefs.sound || false;
        this.desktopEnabled = prefs.desktop || false;
    }

    setupEventListeners() {
        // Mark all as read
        document.getElementById('mark-all-read-btn')?.addEventListener('click', () => {
            this.markAllAsRead();
        });

        // Individual notification actions
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-notification-id]')) {
                const notificationId = e.target.closest('[data-notification-id]').dataset.notificationId;
                
                if (e.target.classList.contains('mark-read-btn')) {
                    this.markAsRead(notificationId);
                } else if (e.target.classList.contains('delete-btn')) {
                    this.deleteNotification(notificationId);
                }
            }
        });

        // Refresh button
        document.getElementById('refresh-notifications')?.addEventListener('click', () => {
            this.refreshNotifications();
        });
    }

    connectToWebSocket() {
        if (typeof window.Echo === 'undefined') {
            console.warn('Laravel Echo not available, falling back to polling');
            return;
        }

        try {
            // Listen for private notifications
            window.Echo.private(`notifications.${window.userId}`)
                .listen('.notification.sent', (data) => {
                    this.handleNewNotification(data);
                })
                .error((error) => {
                    console.error('WebSocket connection error:', error);
                    this.handleConnectionError();
                });

            this.isConnected = true;
            this.connectionRetries = 0;
            this.updateConnectionStatus(true);
        } catch (error) {
            console.error('Failed to establish WebSocket connection:', error);
            this.handleConnectionError();
        }
    }

    handleConnectionError() {
        this.isConnected = false;
        this.updateConnectionStatus(false);
        
        if (this.connectionRetries < this.maxRetries) {
            this.connectionRetries++;
            setTimeout(() => {
                this.connectToWebSocket();
            }, this.retryDelay * this.connectionRetries);
        }
    }

    updateConnectionStatus(connected) {
        if (this.statusIndicator) {
            if (connected) {
                this.statusIndicator.innerHTML = '<span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>Live';
                this.statusIndicator.className = 'ml-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
            } else {
                this.statusIndicator.innerHTML = '<span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>Offline';
                this.statusIndicator.className = 'ml-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
            }
        }
    }

    handleNewNotification(data) {
        // Add notification to UI
        this.addNotificationToUI(data);
        
        // Update counters
        this.updateUnreadCount(this.unreadCount + 1);
        
        // Show desktop notification if enabled
        if (this.desktopEnabled && 'Notification' in window && Notification.permission === 'granted') {
            this.showDesktopNotification(data);
        }
        
        // Play sound if enabled
        if (this.soundEnabled) {
            this.playNotificationSound();
        }
        
        // Animate bell icon
        this.animateBellIcon();
        
        // Show toast notification
        this.showToastNotification(data);
    }

    addNotificationToUI(data) {
        const notificationHtml = this.createNotificationHTML(data);
        
        if (this.dropdown) {
            this.dropdown.insertAdjacentHTML('afterbegin', notificationHtml);
            
            // Remove oldest notification if more than 5
            const notifications = this.dropdown.querySelectorAll('.notification-item');
            if (notifications.length > 5) {
                notifications[notifications.length - 1].remove();
            }
        }
    }

    createNotificationHTML(data) {
        const priorityClass = data.priority === 'high' ? 'notification-priority-high' : 
                             data.priority === 'medium' ? 'notification-priority-medium' : 
                             'notification-priority-low';
        
        return `
            <div class="notification-item notification-new unread ${priorityClass} p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-all" 
                 data-notification-id="${data.id}">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-${data.color}-100 flex items-center justify-center">
                            <i class="${data.icon} text-${data.color}-600"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">${data.title}</p>
                            <div class="flex items-center space-x-1">
                                <button class="mark-read-btn text-xs text-blue-600 hover:text-blue-800">Mark read</button>
                                <button class="delete-btn text-xs text-red-600 hover:text-red-800">Delete</button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2">${data.message}</p>
                        <p class="text-xs text-gray-400 mt-1">${data.formatted_time}</p>
                    </div>
                </div>
            </div>
        `;
    }

    showDesktopNotification(data) {
        const notification = new Notification(data.title, {
            body: data.message,
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            tag: data.id,
            requireInteraction: data.priority === 'high'
        });

        notification.onclick = () => {
            window.focus();
            if (data.action_url && data.action_url !== '#') {
                window.location.href = data.action_url;
            }
            notification.close();
        };

        // Auto close after 5 seconds
        setTimeout(() => {
            notification.close();
        }, 5000);
    }

    playNotificationSound() {
        // Create audio context for notification sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    }

    animateBellIcon() {
        if (this.bellIcon) {
            this.bellIcon.classList.add('shaking-animation');
            setTimeout(() => {
                this.bellIcon.classList.remove('shaking-animation');
            }, 1000);
        }
    }

    showToastNotification(data) {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 bg-white shadow-lg rounded-lg p-4 border-l-4 border-${data.color}-500 max-w-sm z-50 transform translate-x-full transition-transform duration-300`;
        toast.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="${data.icon} text-${data.color}-600 text-xl"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">${data.title}</p>
                    <p class="text-sm text-gray-600 mt-1">${data.message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                    <i class="ph-x"></i>
                </button>
            </div>
        `;

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }

    updateUnreadCount(count) {
        this.unreadCount = count;
        
        // Update badge
        if (this.badge) {
            if (count > 0) {
                this.badge.style.display = 'block';
                this.badge.textContent = count > 99 ? '99+' : count;
            } else {
                this.badge.style.display = 'none';
            }
        }
        
        // Update all unread count elements
        this.unreadCountElements.forEach(element => {
            element.textContent = count;
        });
        
        // Update page title
        if (count > 0) {
            document.title = `(${count}) ${document.title.replace(/^\(\d+\)\s/, '')}`;
        } else {
            document.title = document.title.replace(/^\(\d+\)\s/, '');
        }
    }

    markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.classList.remove('unread');
                    notificationElement.classList.add('read');
                }
                
                this.updateUnreadCount(data.unread_count);
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    markAllAsRead() {
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    item.classList.add('read');
                });
                
                this.updateUnreadCount(0);
            }
        })
        .catch(error => {
            console.error('Error marking all notifications as read:', error);
        });
    }

    deleteNotification(notificationId) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove from UI
                const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.remove();
                }
                
                this.updateUnreadCount(data.unread_count);
            }
        })
        .catch(error => {
            console.error('Error deleting notification:', error);
        });
    }

    refreshNotifications() {
        // Refresh notification list and stats
        Promise.all([
            fetch('/notifications/dropdown').then(res => res.json()),
            fetch('/notifications/stats').then(res => res.json())
        ])
        .then(([notifications, stats]) => {
            // Update dropdown
            if (this.dropdown) {
                this.dropdown.innerHTML = '';
                notifications.notifications.forEach(notification => {
                    this.dropdown.insertAdjacentHTML('beforeend', this.createNotificationHTML(notification));
                });
            }
            
            // Update stats
            this.updateStats(stats);
            this.updateUnreadCount(notifications.unread_count);
        })
        .catch(error => {
            console.error('Error refreshing notifications:', error);
        });
    }

    updateStats(stats) {
        // Update dashboard stats if present
        document.getElementById('total-count')?.textContent = stats.total;
        document.getElementById('unread-count')?.textContent = stats.unread;
        document.getElementById('today-count')?.textContent = stats.today;
        document.getElementById('week-count')?.textContent = stats.this_week;
        document.getElementById('priority-count')?.textContent = stats.high_priority;
    }

    requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    console.log('Notification permission granted');
                }
            });
        }
    }

    startPeriodicUpdates() {
        // Fallback for when WebSocket is not available
        if (!this.isConnected) {
            setInterval(() => {
                this.refreshNotifications();
            }, 30000); // Every 30 seconds
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.notificationSystem = new NotificationSystem();
});

// Export for use in other scripts
window.NotificationSystem = NotificationSystem;
