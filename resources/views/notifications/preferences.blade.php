<x-layouts.layout>
    <x-slot:title>
        Notification Preferences
    </x-slot:title>

<div class="container px-4 py-6 mx-auto">
    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
            <i class="ph-check-circle mr-3 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
            <i class="ph-warning-circle mr-3 text-xl"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="flex items-center text-3xl font-bold text-gray-900 dark:text-white">
                    <i class="mr-3 ph-gear text-primary-600"></i>
                    Notification Preferences
                </h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Customize how you receive notifications
                </p>
            </div>            <a href="{{ 
                auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer') 
                    ? route('reviewer.notifications.dashboard') 
                    : (auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) 
                        ? route('editor.notifications.dashboard') 
                        : (auth()->user()->hasRole('Admin') 
                            ? route('admin.notifications.dashboard')
                            : route('author.notifications.dashboard')))
            }}" class="flex items-center px-4 py-2 text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
                <i class="mr-2 ph-arrow-left"></i>
                Back to Dashboard
            </a></div>
    </div>

    <form action="{{ 
        auth()->user()->hasRole('Associate Editor') || auth()->user()->hasRole('Reviewer') 
            ? route('reviewer.notifications.preferences.update') 
            : (auth()->user()->hasAnyRole(['Editor in Chief', 'Managing Editor']) 
                ? route('editor.notifications.preferences.update') 
                : (auth()->user()->hasRole('Admin') 
                    ? route('admin.notifications.preferences.update')
                    : route('author.notifications.preferences.update')))
    }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Email Notification Settings -->
        <div class="bg-white border border-gray-200 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <i class="mr-3 text-2xl text-blue-500 ph-envelope"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email Notifications</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Control which notifications are sent to your email</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @php
                    $emailPreferences = auth()->user()->notification_preferences['email'] ?? [];
                @endphp
                
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Manuscript Status Changes</label>
                        <p class="text-xs text-gray-500">When your manuscript status is updated</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email[manuscript_status]" value="1" 
                               {{ ($emailPreferences['manuscript_status'] ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Review Assignments</label>
                        <p class="text-xs text-gray-500">When you're assigned as a reviewer</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email[review_assignment]" value="1" 
                               {{ ($emailPreferences['review_assignment'] ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">New Submissions</label>
                        <p class="text-xs text-gray-500">When new manuscripts are submitted (Editors only)</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email[new_submissions]" value="1" 
                               {{ ($emailPreferences['new_submissions'] ?? auth()->user()->hasRole('editor')) ? 'checked' : '' }}
                               class="sr-only peer" {{ !auth()->user()->hasRole('editor') ? 'disabled' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 {{ !auth()->user()->hasRole('editor') ? 'opacity-50' : '' }}"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Weekly Summary</label>
                        <p class="text-xs text-gray-500">Weekly digest of your activity</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email[weekly_summary]" value="1" 
                               {{ ($emailPreferences['weekly_summary'] ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- In-App Notification Settings -->
        <div class="bg-white border border-gray-200 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <i class="mr-3 text-2xl text-green-500 ph-bell"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">In-App Notifications</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Control notifications within the application</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @php
                    $inAppPreferences = auth()->user()->notification_preferences['in_app'] ?? [];
                @endphp

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Real-time Notifications</label>
                        <p class="text-xs text-gray-500">Show live notifications in the browser</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="in_app[realtime]" value="1" 
                               {{ ($inAppPreferences['realtime'] ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Sound Alerts</label>
                        <p class="text-xs text-gray-500">Play sound for important notifications</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="in_app[sound]" value="1" 
                               {{ ($inAppPreferences['sound'] ?? false) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Desktop Notifications</label>
                        <p class="text-xs text-gray-500">Show browser notifications even when tab is not active</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="in_app[desktop]" value="1" 
                               {{ ($inAppPreferences['desktop'] ?? false) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Notification Frequency Settings -->
        <div class="bg-white border border-gray-200 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <i class="mr-3 text-2xl text-purple-500 ph-clock"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notification Frequency</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Control how often you receive notifications</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @php
                    $frequency = auth()->user()->notification_preferences['frequency'] ?? 'immediate';
                @endphp

                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="frequency" value="immediate" 
                               {{ $frequency === 'immediate' ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <span class="ml-3 text-sm text-gray-900 dark:text-white">
                            <strong>Immediate</strong> - Receive notifications as they happen
                        </span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="frequency" value="hourly" 
                               {{ $frequency === 'hourly' ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <span class="ml-3 text-sm text-gray-900 dark:text-white">
                            <strong>Hourly Digest</strong> - Bundle notifications into hourly summaries
                        </span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="frequency" value="daily" 
                               {{ $frequency === 'daily' ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <span class="ml-3 text-sm text-gray-900 dark:text-white">
                            <strong>Daily Summary</strong> - One daily digest with all notifications
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="flex items-center px-6 py-3 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="mr-2 ph-check"></i>
                Save Preferences
            </button>        </div>
    </form>
</div>
</x-layouts.layout>
