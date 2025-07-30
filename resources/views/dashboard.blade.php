@extends('layouts.pharmacy')

@section('title', 'Pharmacy Dashboard')

@section('content')
<div class="pharmacy-dashboard">
    <!-- Header with User Info -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Pharmacy Dashboard</h1>
            <div class="header-actions">
                <div class="search-bar">
                    <form action="{{ route('search') }}" method="GET">
                        <input type="text" name="query" placeholder="Search patients, medications...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    @if($unreadNotificationsCount > 0)
                        <span class="badge">{{ $unreadNotificationsCount }}</span>
                    @endif
                </div>
                <div class="user-info">
                    <span class="welcome-message">Welcome, {{ Auth::user()->name }}</span>
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.edit') }}">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                             @csrf
                                  <button type="submit">Logout</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Navigation Sidebar -->
        <nav class="dashboard-sidebar" aria-label="Main navigation">
            <ul class="nav flex-column" role="menu">
                <li class="nav-item" role="none">
                    <a class="nav-link active" href="{{ route('dashboard') }}" aria-current="page" role="menuitem">
                        <i class="fas fa-tachometer-alt" aria-hidden="true"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('patients.index') }}" role="menuitem">
                        <i class="fas fa-users" aria-hidden="true"></i> Patients
                    </a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('inventory.index') }}" role="menuitem">
                        <i class="fas fa-pills" aria-hidden="true"></i> Inventory
                    </a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('prescriptions.index') }}" role="menuitem">
                        <i class="fas fa-prescription-bottle-alt" aria-hidden="true"></i> Prescriptions
                    </a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('orders.index') }}" role="menuitem">
                        <i class="fas fa-clipboard-list" aria-hidden="true"></i> Orders
                    </a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('reports.index') }}" role="menuitem">
                        <i class="fas fa-chart-bar" aria-hidden="true"></i> Reports
                    </a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('settings.index') }}" role="menuitem">
                        <i class="fas fa-cog" aria-hidden="true"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Dashboard Widgets -->
        <div class="dashboard-main">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Quick Stats Row -->
            <div class="widgets-row">
                <!-- Today's Orders Card -->
                <div class="card widget-card">
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="card-content">
                            <h5 class="card-title">Today's Orders</h5>
                            <h2 class="card-value">{{ $todaysOrdersCount }}</h2>
                            <p class="card-text">New prescriptions</p>
                        </div>
                        <a href="{{ route('orders.index') }}" class="card-link">
                            View all <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Low Stock Alert Card -->
                <div class="card widget-card warning">
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="card-content">
                            <h5 class="card-title">Low Stock</h5>
                            <h2 class="card-value">{{ $lowStockItemsCount }}</h2>
                            <p class="card-text">Medications need restocking</p>
                        </div>
                        <a href="{{ route('inventory.low-stock') }}" class="card-link">
                            View list <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Pending Orders Card -->
                <div class="card widget-card">
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-content">
                            <h5 class="card-title">Pending Orders</h5>
                            <h2 class="card-value">{{ $pendingOrdersCount }}</h2>
                            <p class="card-text">To be processed</p>
                        </div>
                        <a href="{{ route('orders.pending') }}" class="card-link">
                            Process now <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                
            <!-- Recent Activity Section -->
            <div class="recent-activity">
                <div class="section-header">
                    <h3>Recent Activity</h3>
                    <a href="{{ route('activity.log') }}" class="view-all">View All</a>
                </div>
                <div class="activity-list">
                    @forelse($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            @if($activity->type === 'order')
                                <i class="fas fa-shopping-basket"></i>
                            @elseif($activity->type === 'prescription')
                                <i class="fas fa-prescription-bottle-alt"></i>
                            @elseif($activity->type === 'inventory')
                                <i class="fas fa-pills"></i>
                            @else
                                <i class="fas fa-info-circle"></i>
                            @endif
                        </div>
                        <div class="activity-content">
                            <p class="activity-message">{{ $activity->message }}</p>
                            <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-info-circle"></i>
                        <p>No recent activity found</p>
                    </div>
                    @endforelse
                </div>
            </div>

           
    <!-- Footer -->
    <div class="dashboard-footer">
        <div class="footer-content">
            <p>Version 1.0.0</p>
            <p>Copyright © {{ date('Y') }} Attariya Pharmacy. All rights reserved.</p>
            <div class="system-info">
                <span>Last updated: {{ now()->format('d M Y H:i') }}</span>
                <span>Server Time: {{ now()->format('H:i:s') }}</span>
            </div>
        </div>
    </div>
</div>

<style>
    .pharmacy-dashboard {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-header {
        background-color: #2c3e50;
        color: white;
        padding: 15px 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .search-bar {
        position: relative;
    }

    .search-bar input {
        padding: 8px 15px;
        border-radius: 20px;
        border: none;
        width: 200px;
        transition: width 0.3s;
    }

    .search-bar input:focus {
        width: 250px;
        outline: none;
    }

    .search-bar button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #2c3e50;
        cursor: pointer;
    }

    .notifications {
        position: relative;
        cursor: pointer;
        font-size: 18px;
    }

    .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #e74c3c;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-info {
        display: flex;
        align-items: center;
        position: relative;
        cursor: pointer;
        gap: 10px;
    }

    .welcome-message {
        font-size: 14px;
    }

    .user-avatar {
        font-size: 28px;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        min-width: 150px;
        z-index: 100;
    }

    .dropdown-menu a, .dropdown-menu button {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .dropdown-menu button {
        cursor: pointer;
    }

    .dropdown-menu a:hover, .dropdown-menu button:hover {
        background-color: #f5f7fa;
    }

    .user-info:hover .dropdown-menu {
        display: block;
    }

    .dashboard-content {
        display: flex;
        flex: 1;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    .dashboard-sidebar {
        width: 250px;
        background-color: white;
        padding: 20px 0;
        border-right: 1px solid #e0e0e0;
    }

    .nav-item {
        margin-bottom: 5px;
    }

    .nav-link {
        padding: 12px 20px;
        color: #555;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.2s;
    }

    .nav-link i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .nav-link.active {
        background-color: #e8f4ff;
        color: #2c3e50;
        border-left: 3px solid #27ae60;
    }

    .nav-link:hover:not(.active) {
        background-color: #f5f5f5;
    }

    .dashboard-main {
        flex: 1;
        padding: 25px;
        overflow-x: auto;
    }

    .widgets-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .widget-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .widget-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .widget-card.warning {
        border-top: 3px solid #f39c12;
    }

    .widget-card.danger {
        border-top: 3px solid #e74c3c;
    }

    .widget-card .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-icon {
        font-size: 24px;
        color: #27ae60;
        margin-bottom: 15px;
    }

    .widget-card.warning .card-icon {
        color: #f39c12;
    }

    .widget-card.danger .card-icon {
        color: #e74c3c;
    }

    .card-content {
        margin-bottom: 15px;
    }

    .card-title {
        font-size: 14px;
        color: #777;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-value {
        font-size: 28px;
        font-weight: bold;
        color: #2c3e50;
        margin: 5px 0;
    }

    .card-text {
        font-size: 13px;
        color: #888;
    }

    .card-link {
        display: flex;
        align-items: center;
        color: #27ae60;
        text-decoration: none;
        font-size: 13px;
        margin-top: auto;
    }

    .card-link i {
        margin-left: 5px;
        font-size: 10px;
    }

    .recent-activity, .recent-orders {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-header h3 {
        color: #2c3e50;
        font-size: 18px;
    }

    .view-all {
        color: #27ae60;
        text-decoration: none;
        font-size: 13px;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-icon {
        background-color: #f5f7fa;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #27ae60;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-message {
        margin: 0;
        color: #333;
        font-size: 14px;
    }

    .activity-time {
        font-size: 12px;
        color: #888;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        color: #888;
    }

    .empty-state i {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .empty-state p {
        margin: 0;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    th {
        background-color: #f5f7fa;
        color: #2c3e50;
        font-weight: 600;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-badge.processed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-badge.completed {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .status-badge.cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        color: white;
        margin-right: 5px;
    }

    .action-btn.view {
        background-color: #17a2b8;
    }

    .action-btn.process {
        background-color: #28a745;
    }

    .action-btn:hover {
        opacity: 0.8;
    }

    .dashboard-footer {
        background-color: #2c3e50;
        color: white;
        padding: 15px 30px;
        text-align: center;
        font-size: 13px;
        margin-top: auto;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .system-info {
        color: #bbb;
        display: flex;
        gap: 15px;
    }

    @media (max-width: 992px) {
        .widgets-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-content {
            flex-direction: column;
        }

        .dashboard-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
        }

        .header-content {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .user-info {
            margin-top: 10px;
        }

        .footer-content {
            flex-direction: column;
            gap: 10px;
        }

        .system-info {
            flex-direction: column;
            gap: 5px;
        }
    }

    @media (max-width: 576px) {
        .widgets-row {
            grid-template-columns: 1fr;
        }

        .activity-item {
            flex-direction: column;
        }

        .activity-icon {
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 22px;
        }

        .search-bar input {
            width: 150px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            // Dropdown functionality
            const userInfo = document.querySelector('.user-info');
            if (userInfo) {
                userInfo.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.querySelector('.dropdown-menu');
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                const dropdowns = document.querySelectorAll('.dropdown-menu');
                dropdowns.forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
            });

            // Notification bell click
            const notificationBell = document.querySelector('.notifications');
            if (notificationBell) {
                notificationBell.addEventListener('click', function() {
                    // In a real app, this would mark notifications as read
                    // and redirect to notifications page
                    window.location.href = "{{ route('notifications.index') }}";
                });
            }

            // Search bar focus effect
            const searchInput = document.querySelector('.search-bar input');
            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    this.parentElement.style.boxShadow = '0 0 0 2px rgba(39, 174, 96, 0.2)';
                });

                searchInput.addEventListener('blur', function() {
                    this.parentElement.style.boxShadow = 'none';
                });
            }
        } catch (error) {
            console.error('Dashboard script error:', error);
        }
    });
</script>
@endsection