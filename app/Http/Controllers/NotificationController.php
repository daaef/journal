<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user
     */
    public function index(Request $request)
    {
        $user = Auth::user();
          $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->when($request->has('unread'), function ($query) {
                return $query->whereNull('read_at');
            })
            ->when($request->has('read'), function ($query) {
                return $query->whereNotNull('read_at');
            })
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'notifications' => $notifications->items(),
                'unread_count' => $user->unreadNotifications()->count(),
                'has_more' => $notifications->hasMorePages()
            ]);
        }

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'unread_count' => $user->unreadNotifications()->count()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification not found'
        ], 404);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
            'unread_count' => 0
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted',
                'unread_count' => $user->unreadNotifications()->count()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification not found'
        ], 404);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        return response()->json([
            'unread_count' => $user->unreadNotifications()->count()
        ]);
    }

    /**
     * Get notifications for dropdown (latest 5)
     */
    public function getDropdownNotifications()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                $data = $notification->data;
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $data['title'] ?? 'Notification',
                    'message' => $data['message'] ?? '',
                    'action_url' => $data['action_url'] ?? '#',
                    'icon' => $data['icon'] ?? 'ph-bell',
                    'color' => $data['color'] ?? 'primary',
                    'created_at' => $notification->created_at->diffForHumans(),
                    'read_at' => $notification->read_at,
                    'is_read' => !is_null($notification->read_at)
                ];
            });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotifications()->count()
        ]);
    }

    /**
     * Show comprehensive notification dashboard
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // Get notification statistics
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'today' => $user->notifications()->whereDate('created_at', today())->count(),
            'this_week' => $user->notifications()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count()
        ];
        
        // Group notifications by type
        $notificationsByType = $user->notifications()
            ->get()
            ->groupBy(function ($notification) {
                $data = $notification->data;
                return $data['type'] ?? 'general';
            })
            ->map(function ($notifications) {
                return $notifications->count();
            });
        
        // Get filtered notifications
        $query = $user->notifications()->orderBy('created_at', 'desc');
        
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('data->type', $request->type);
        }
        
        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }
        
        $notifications = $query->paginate(15)->appends($request->query());
        
        // Format notifications for display
        $formattedNotifications = $notifications->getCollection()->map(function ($notification) {
            $data = $notification->data;
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'title' => $data['title'] ?? 'Notification',
                'message' => $data['message'] ?? '',
                'action_url' => $data['action_url'] ?? '#',
                'icon' => $data['icon'] ?? 'ph-bell',
                'color' => $data['color'] ?? 'primary',
                'created_at' => $notification->created_at,
                'read_at' => $notification->read_at,
                'is_read' => !is_null($notification->read_at),
                'journal_title' => $data['journal_title'] ?? null,
                'author_name' => $data['author_name'] ?? null,
                'reviewer_name' => $data['reviewer_name'] ?? null
            ];
        });
        
        $notifications->setCollection($formattedNotifications);
        
        return view('notifications.dashboard', compact('notifications', 'stats', 'notificationsByType'));
    }

    /**
     * Get detailed notification counts for dashboard
     */
    public function getDetailedCounts()
    {
        $user = Auth::user();
        
        return response()->json([
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'today' => $user->notifications()->whereDate('created_at', today())->count(),
            'this_week' => $user->notifications()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'high_priority' => $user->notifications()->where('data->priority', 'high')->count()
        ]);
    }

    /**
     * Show notification preferences page
     */
    public function preferences()
    {
        return view('notifications.preferences');
    }

    /**
     * Update notification preferences
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        
        // Get form data using array notation (email[], in_app[])
        $emailPrefs = $request->input('email', []);
        $inAppPrefs = $request->input('in_app', []);
        
        $preferences = [
            'email' => [
                'manuscript_status' => isset($emailPrefs['manuscript_status']),
                'review_assignment' => isset($emailPrefs['review_assignment']),
                'new_submissions' => isset($emailPrefs['new_submissions']),
                'weekly_summary' => isset($emailPrefs['weekly_summary']),
            ],
            'in_app' => [
                'realtime' => isset($inAppPrefs['realtime']),
                'sound' => isset($inAppPrefs['sound']),
                'desktop' => isset($inAppPrefs['desktop']),
            ],
            'frequency' => $request->input('frequency', 'immediate')
        ];
        
        $user->update([
            'notification_preferences' => $preferences
        ]);
        
        // Determine the correct route based on user role
        $redirectRoute = 'author.notifications.preferences';
        if ($user->hasRole('Associate Editor') || $user->hasRole('Reviewer')) {
            $redirectRoute = 'reviewer.notifications.preferences';
        } elseif ($user->hasAnyRole(['Editor in Chief', 'Managing Editor'])) {
            $redirectRoute = 'editor.notifications.preferences';
        } elseif ($user->hasRole('Admin')) {
            $redirectRoute = 'admin.notifications.preferences';
        }
        
        return redirect()->route($redirectRoute)
            ->with('success', 'Notification preferences updated successfully!');
    }

    /**
     * Get real-time notification counts for AJAX
     */
    public function getRealTimeStats()
    {
        $user = Auth::user();
        
        return response()->json([
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'today' => $user->notifications()->whereDate('created_at', today())->count(),
            'this_week' => $user->notifications()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'high_priority' => $user->notifications()->where('data->priority', 'high')->count()
        ]);
    }

    /**
     * Export notifications to CSV
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->notifications()->orderBy('created_at', 'desc');
        
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('data->type', $request->type);
        }
        
        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }
        
        $notifications = $query->get();
        
        $filename = 'notifications_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        return response()->stream(function() use ($notifications) {
            $handle = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($handle, ['Date', 'Type', 'Title', 'Message', 'Status', 'Priority']);
            
            foreach ($notifications as $notification) {
                $data = $notification->data;
                fputcsv($handle, [
                    $notification->created_at->format('Y-m-d H:i:s'),
                    $data['type'] ?? 'general',
                    $data['title'] ?? 'Notification',
                    $data['message'] ?? '',
                    $notification->read_at ? 'Read' : 'Unread',
                    $data['priority'] ?? 'normal'
                ]);
            }
            
            fclose($handle);
        }, 200, $headers);
    }
}
