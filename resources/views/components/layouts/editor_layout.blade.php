<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $title ?? 'JAPR Website | Dashboard' }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/file-upload.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/full-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/editor-quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap-2.0.5.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/main.scss', 'resources/sass/style.scss'])
    
    <!-- Custom Form Styling -->
    <style>
        /* Custom Form Styling - Updated UI */
        .form-control {
            border-radius: 8px;
            font-weight: 400;
            outline: none;
            width: 100%;
            padding: 13px 16px;
            background-color: #ffffff !important;
            border: 1px solid #e5e7eb;
            color: #374151;
            line-height: 1.5;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .form-control:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        .form-control.is-invalid:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        /* Multiple Select Styling */
        select[multiple].form-control {
            min-height: 120px;
            padding: 12px 16px;
            background-image: none;
        }
        
        select[multiple].form-control option {
            padding: 8px 12px;
            margin: 2px 0;
            border-radius: 4px;
            background-color: #ffffff;
            color: #374151;
            transition: all 0.2s ease-in-out;
        }
        
        select[multiple].form-control option:hover {
            background-color: #f3f4f6;
        }
        
        select[multiple].form-control option:checked {
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 500;
        }
        
        select[multiple].form-control option:checked:hover {
            background-color: #2563eb;
        }
        
        /* Optgroup styling */
        select[multiple].form-control optgroup {
            font-weight: 600;
            color: #6b7280;
            background-color: #f9fafb;
            padding: 4px 8px;
            margin: 4px 0;
            border-radius: 4px;
        }
        
        select[multiple].form-control optgroup option {
            margin-left: 8px;
            padding-left: 16px;
        }
        
        /* Custom Multiselect Dropdown Styling */
        .custom-multiselect {
            position: relative;
            width: 100%;
        }
        
        .multiselect-trigger {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }
        
        .multiselect-trigger .dropdown-arrow {
            transition: transform 0.2s ease-in-out;
            color: #6b7280;
        }
        
        .multiselect-trigger.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        .multiselect-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .multiselect-dropdown.show {
            display: block;
        }
        
        .option-item {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .option-item:last-child {
            border-bottom: none;
        }
        
        .option-item:hover {
            background-color: #f9fafb;
        }
        
        .option-item input[type="checkbox"] {
            display: none;
        }
        
        .checkmark {
            width: 16px;
            height: 16px;
            border: 2px solid #d1d5db;
            border-radius: 3px;
            margin-right: 12px;
            position: relative;
            transition: all 0.2s ease-in-out;
        }
        
        .option-item input[type="checkbox"]:checked + .checkmark {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .option-item input[type="checkbox"]:checked + .checkmark::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .option-text {
            flex: 1;
            color: #374151;
            font-size: 14px;
        }
        
        .option-group {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .option-group:last-child {
            border-bottom: none;
        }
        
        .group-header {
            padding: 8px 16px;
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .selected-text {
            color: #374151;
        }
        
        .selected-text.has-selections {
            color: #3b82f6;
            font-weight: 500;
        }
        
        /* Table Actions Column Width - Comprehensive */
        .table th:last-child,
        .table td:last-child,
        .table-striped th:last-child,
        .table-striped td:last-child,
        .table-hover th:last-child,
        .table-hover td:last-child,
        .style-two th:last-child,
        .style-two td:last-child {
            min-width: 200px;
            width: 200px;
        }
        
        /* For tables with many columns, give actions more space */
        .table th:nth-last-child(1),
        .table td:nth-last-child(1),
        .table-striped th:nth-last-child(1),
        .table-striped td:nth-last-child(1),
        .table-hover th:nth-last-child(1),
        .table-hover td:nth-last-child(1),
        .style-two th:nth-last-child(1),
        .style-two td:nth-last-child(1) {
            min-width: 180px;
            width: 180px;
        }
        
        /* Ensure action buttons have proper spacing */
        .table td:last-child .btn,
        .table td:last-child a,
        .table-striped td:last-child .btn,
        .table-striped td:last-child a,
        .table-hover td:last-child .btn,
        .table-hover td:last-child a,
        .style-two td:last-child .btn,
        .style-two td:last-child a {
            margin: 2px 4px;
            white-space: nowrap;
        }
        
        /* For tables with action buttons in a flex container */
        .table td:last-child .flex-align,
        .table td:last-child .d-flex,
        .table-striped td:last-child .flex-align,
        .table-striped td:last-child .d-flex,
        .table-hover td:last-child .flex-align,
        .table-hover td:last-child .d-flex,
        .style-two td:last-child .flex-align,
        .style-two td:last-child .d-flex {
            gap: 8px;
            flex-wrap: wrap;
        }
        
        /* Responsive table actions */
        @media (max-width: 768px) {
            .table th:last-child,
            .table td:last-child,
            .table-striped th:last-child,
            .table-striped td:last-child,
            .table-hover th:last-child,
            .table-hover td:last-child,
            .style-two th:last-child,
            .style-two td:last-child {
                min-width: 150px;
                width: 150px;
            }
        }
        
        /* Action Button Styling with Real Colors */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin: 2px 4px;
            white-space: nowrap;
        }
        
        /* Primary Action Button */
        .action-btn-primary {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        
        .action-btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }
        
        /* Secondary Action Button */
        .action-btn-secondary {
            background-color: #6b7280;
            color: #ffffff;
            border-color: #6b7280;
        }
        
        .action-btn-secondary:hover {
            background-color: #4b5563;
            border-color: #4b5563;
            color: #ffffff;
        }
        
        /* Success Action Button */
        .action-btn-success {
            background-color: #10b981;
            color: #ffffff;
            border-color: #10b981;
        }
        
        .action-btn-success:hover {
            background-color: #059669;
            border-color: #059669;
            color: #ffffff;
        }
        
        /* Warning Action Button */
        .action-btn-warning {
            background-color: #f59e0b;
            color: #ffffff;
            border-color: #f59e0b;
        }
        
        .action-btn-warning:hover {
            background-color: #d97706;
            border-color: #d97706;
            color: #ffffff;
        }
        
        /* Danger Action Button */
        .action-btn-danger {
            background-color: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
        }
        
        .action-btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
        }
        
        /* Info Action Button */
        .action-btn-info {
            background-color: #06b6d4;
            color: #ffffff;
            border-color: #06b6d4;
        }
        
        .action-btn-info:hover {
            background-color: #0891b2;
            border-color: #0891b2;
            color: #ffffff;
        }
        
        /* Outline Variants */
        .action-btn-outline-primary {
            background-color: transparent;
            color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .action-btn-outline-primary:hover {
            background-color: #3b82f6;
            color: #ffffff;
        }
        
        .action-btn-outline-secondary {
            background-color: transparent;
            color: #6b7280;
            border-color: #6b7280;
        }
        
        .action-btn-outline-secondary:hover {
            background-color: #6b7280;
            color: #ffffff;
        }
        
        .action-btn-outline-success {
            background-color: transparent;
            color: #10b981;
            border-color: #10b981;
        }
        
        .action-btn-outline-success:hover {
            background-color: #10b981;
            color: #ffffff;
        }
        
        .action-btn-outline-warning {
            background-color: transparent;
            color: #f59e0b;
            border-color: #f59e0b;
        }
        
        .action-btn-outline-warning:hover {
            background-color: #f59e0b;
            color: #ffffff;
        }
        
        .action-btn-outline-danger {
            background-color: transparent;
            color: #ef4444;
            border-color: #ef4444;
        }
        
        .action-btn-outline-danger:hover {
            background-color: #ef4444;
            color: #ffffff;
        }
        
        .action-btn-outline-info {
            background-color: transparent;
            color: #06b6d4;
            border-color: #06b6d4;
        }
        
        .action-btn-outline-info:hover {
            background-color: #06b6d4;
            color: #ffffff;
        }
        
        /* Small Action Buttons */
        .action-btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        /* Large Action Buttons */
        .action-btn-lg {
            padding: 12px 24px;
            font-size: 16px;
        }
        
        /* Card Styling */
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
            border-radius: 12px 12px 0 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Button Styling */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            line-height: 1.25rem;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .btn:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .btn-outline-secondary {
            background-color: #ffffff;
            color: #374151;
            border-color: #d1d5db;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }
        
        /* Settings Form Specific */
        .settings-form .space-y-6 {
            margin-bottom: 2rem;
        }
        
        .settings-form .space-y-6:last-child {
            margin-bottom: 0;
        }
        
        .settings-form .border-b {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .settings-form .grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .settings-form .sm\\:grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        @media (min-width: 640px) {
            .settings-form .sm\\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        
        .settings-form .sm\\:col-span-2 {
            grid-column: span 2 / span 2;
        }
        
        @media (max-width: 639px) {
            .settings-form .sm\\:col-span-2 {
                grid-column: span 1 / span 1;
            }
        }
    </style>
    
    <script>
        // Custom Multiselect Dropdown JavaScript
        function toggleDropdown(fieldName) {
            const dropdown = document.getElementById(fieldName + '_dropdown');
            const trigger = dropdown.previousElementSibling;
            
            // Close all other dropdowns
            document.querySelectorAll('.multiselect-dropdown').forEach(d => {
                if (d !== dropdown) {
                    d.classList.remove('show');
                    d.previousElementSibling.classList.remove('active');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
            trigger.classList.toggle('active');
        }
        
        function updateSelectedText(fieldName) {
            const dropdown = document.getElementById(fieldName + '_dropdown');
            const trigger = dropdown.previousElementSibling;
            const selectedText = trigger.querySelector('.selected-text');
            const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]:checked');
            
            if (checkboxes.length === 0) {
                selectedText.textContent = fieldName === 'regional_expertise' ? 'Select regions...' : 'Select interests...';
                selectedText.classList.remove('has-selections');
            } else if (checkboxes.length === 1) {
                selectedText.textContent = checkboxes[0].value;
                selectedText.classList.add('has-selections');
            } else {
                selectedText.textContent = `${checkboxes.length} items selected`;
                selectedText.classList.add('has-selections');
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.custom-multiselect')) {
                document.querySelectorAll('.multiselect-dropdown').forEach(d => {
                    d.classList.remove('show');
                    d.previousElementSibling.classList.remove('active');
                });
            }
        });
        
        // Initialize selected text on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectedText('regional_expertise');
            updateSelectedText('research_interests');
        });
    </script>
</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->


    <!-- ============================ Sidebar Start ============================ -->

    <aside class="sidebar">
        <!-- sidebar close btn -->
        <button type="button"
            class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i
                class="ph ph-x"></i></button>
        <!-- sidebar close btn -->

        <a href="{{ route('dashboard') }}"
            class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
            <img class="w-25s" src="{{ asset('images/japr-logo.png') }}" alt="Logo">
        </a>

        <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
            <div class="p-20 pt-10">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu__item">
                        <a href="{{ route('editor.dashboard') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-squares-four"></i></span>
                            <span class="text">Dashboard</span>
                            {{-- <span class="link-badge">3</span> --}}
                        </a>
                        <!-- Submenu End -->
                    </li>
                    <li class="sidebar-menu__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-graduation-cap"></i></span>
                            <span class="text">Manage Journals</span>
                        </a>
                        <!-- Submenu start -->
                        <ul class="sidebar-submenu">
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.pendingApproval') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        Pending Review
                                        @php
                                            $pendingCount = \App\Models\Journal::whereIn('approval_status', ['pending', 'in-review'])->count();
                                        @endphp
                                        @if($pendingCount > 0)
                                            <span class="badge bg-warning text-dark ms-2">{{ $pendingCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.underPeerReview') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        Under Peer Review
                                        @php
                                            $underReviewCount = \App\Models\Journal::where('approval_status', 'under_peer_review')->count();
                                        @endphp
                                        @if($underReviewCount > 0)
                                            <span class="badge bg-indigo text-white ms-2">{{ $underReviewCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.inProgress') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        In Progress
                                        @php
                                            $inProgressCount = \App\Models\Journal::whereIn('approval_status', ['in-progress', 'in_progress', 'in-review'])->count();
                                        @endphp
                                        @if($inProgressCount > 0)
                                            <span class="badge bg-blue text-white ms-2">{{ $inProgressCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.reviewed') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        Reviewed
                                        @php
                                            $reviewedCount = \App\Models\Journal::where('approval_status', 'reviewed')->count();
                                        @endphp
                                        @if($reviewedCount > 0)
                                            <span class="badge bg-purple text-white ms-2">{{ $reviewedCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            @if(auth()->user()->hasAnyRole(['Managing Editor', 'Editor in Chief']))
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.readyForNotice') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        Ready for Notice
                                        @php
                                            $readyCount = \App\Models\Journal::where('approval_status', 'ready_for_managing_editor_notice')->count();
                                        @endphp
                                        @if($readyCount > 0)
                                            <span class="badge bg-info text-white ms-2">{{ $readyCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            @endif
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.approved') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        Approved
                                        @php
                                            $approvedCount = \App\Models\Journal::whereIn('approval_status', ['approved', 'approved_with_comment'])->count();
                                        @endphp
                                        @if($approvedCount > 0)
                                            <span class="badge bg-success text-white ms-2">{{ $approvedCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.revisionRequested') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        Revision Requested
                                        @php
                                            $revisionCount = \App\Models\Journal::whereIn('approval_status', ['changes_requested', 'revision_requested'])->count();
                                        @endphp
                                        @if($revisionCount > 0)
                                            <span class="badge bg-orange text-white ms-2">{{ $revisionCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('editor.journals.rejected') }}" class="sidebar-submenu__link">
                                    <span class="d-flex align-items-center">
                                        Declined/Rejected
                                        @php
                                            $rejectedCount = \App\Models\Journal::whereIn('approval_status', ['declined', 'rejected'])->count();
                                        @endphp
                                        @if($rejectedCount > 0)
                                            <span class="badge bg-danger text-white ms-2">{{ $rejectedCount }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- Submenu End -->
                    </li>

                    <li class="sidebar-menu__item">
                        <span
                            class="text-gray-300 text-sm px-20 pt-20 fw-semibold border-top border-gray-100 d-block text-uppercase">Settings</span>
                    </li>

                    <li class="sidebar-menu__item">
                        <a href="{{ route('editor.notifications.dashboard') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-bell"></i></span>
                            <span class="text">Notifications</span>
                        </a>
                    </li>

                    <li class="sidebar-menu__item">
                        <a href="{{ route('editor.user.settings', auth()->user()->uuid) }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-gear"></i></span>
                            <span class="text">Account Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </aside>

    <div class="dashboard-main-wrapper">

        <div class="top-navbar flex-between gap-16 z-[700]">

            <div class="flex-align gap-16">
                <!-- Toggle Button Start -->
                <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500"><i
                        class="ph ph-list"></i></button>
                <!-- Toggle Button End -->


            </div>

            <div class="flex-align gap-16">
                <div class="flex-align gap-8">
                    @include('components.notification-dropdown')
                </div>


                <!-- User Profile Start -->
                <div class="dropdown">
                    <button
                        class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Str::words(auth()->user()->fullname, 1, '') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                        <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                            <div class="card-body">
                                <div class="flex-align gap-8 mb-20 pb-20 border-bottom border-gray-100">
                                    <div class="">
                                        <h4 class="my-0">{{ auth()->user()->fullname }}</h4>
                                        <p class="fw-medium text-13 text-gray-200 my-0"></p>
                                    </div>
                                </div>
                                <ul class="max-h-270 overflow-y-auto scroll-sm pl-0">
                                    <li class="mb-4">
                                        <a href="{{ route('editor.user.settings', auth()->user()->uuid) }}"
                                            class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-primary-600 d-flex"><i
                                                    class="ph ph-gear"></i></span>
                                            <span class="text">Account Settings</span>
                                        </a>
                                    </li>

                                    <li class="pt-8 border-top border-gray-100">
                                        <a href="{{ route('auth.logout') }}"
                                            class="py-12 text-15 px-20 hover-bg-danger-50 text-gray-300 hover-text-danger-600 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-danger-600 d-flex"><i
                                                    class="ph ph-sign-out"></i></span>
                                            <span class="text">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Profile Start -->

            </div>
        </div>


        <div class="dashboard-body">
            {{ $slot }}
        </div>

        <div class="dashboard-footer">
            <div class="flex-between justify-center flex-wrap gap-16">
                <p class="text-gray-300 text-13 fw-normal"> &copy; Copyright {{ date('Y') }}, All Right Reserverd
                </p>
            </div>
        </div>
    </div>

    <!-- Jquery js -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
    <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    <script src="{{ asset('assets/js/plyr.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="{{ asset('assets/js/full-calendar.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/editor-quill.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/calendar.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>



    <script>
        // ============================ Donut Chart Start ==========================
        var options = {
            series: [65.2, 25, 9.8],
            chart: {
                height: 200,
                type: 'donut',
            },
            colors: ['#3D7FF9', '#27CFA7', '#FA902F'],
            enabled: true, // Enable data labels
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex] + '%';
            },
            dropShadow: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '55%' // Fixed slice width
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        show: false
                    }
                }
            }],
            legend: {
                position: 'right',
                offsetY: 0,
                height: 230,
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#activityDonutChart"), options);
        chart.render();
        // ============================ Donut Chart End ==========================

        // ============================ Hour Spent Chart Start ==========================
        var options = {
            series: [{
                name: 'Study',
                data: [44, 55, 41, 50, 36, 43, 50, 44, 55, 41, 50, 36]
            }, {
                name: 'Exam',
                data: [26, 23, 20, 40, 32, 27, 30, 26, 23, 20, 40, 32]
            }],
            colors: ['#27CFA7', '#A9ECDC'],
            chart: {
                type: 'bar',
                height: 400,
                stacked: true,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: true
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: "35%",
                    horizontal: false,
                    borderRadius: 10,
                    borderRadiusApplication: 'end', // 'around', 'end'
                    borderRadiusWhenStacked: 'last', // 'all', 'last'
                    dataLabels: {
                        total: {
                            enabled: false,
                            style: {
                                fontSize: '13px',
                                fontWeight: 900,
                            }
                        }
                    }
                },
            },
            dataLabels: {
                enabled: false // Disable bar labels globally
            },
            grid: {
                show: true,
                borderColor: '#d5dbe7',
                strokeDashArray: 3,
                position: 'back',
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return "$" + value + "Hr";
                    },
                    style: {
                        fontSize: "14px"
                    }
                },
            },
            legend: {
                show: false,
                position: 'top',
                offsetY: 0,
                horizontalAlign: 'start',
                markers: {
                    // shape: 'circle'
                    radius: 50,
                }
            },
            fill: {
                opacity: 1
            }
        };

        var chart = new ApexCharts(document.querySelector("#stackedColumnChart"), options);
        chart.render();
        // ============================ Hour Spent Chart Start ==========================

        // Delete Event Item
        $('.delete-btn').on('click', function() {
            $(this).closest('.event-item').addClass('d-none')
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        @if (Session::has('message'))
            const type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':

                    toastr.options.timeOut = 10000;
                    toastr.info("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();
                    break;
                case 'success':

                    toastr.options.timeOut = 10000;
                    toastr.success("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'warning':

                    toastr.options.timeOut = 10000;
                    toastr.warning("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'error':

                    toastr.options.timeOut = 10000;
                    toastr.error("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
            }
        @endif
    </script>

</body>

</html>
