@extends('layouts.app')

@section('title', 'My Account - Premium Farming Feeds')

@push('styles')
<style>
    .account-section {
        padding: 4rem 0;
        background-color: var(--light-bg);
        min-height: calc(100vh - 80px);
    }

    .account-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
        align-items: start;
    }

    /* Sidebar */
    .account-sidebar {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 100px;
    }

    .user-info {
        text-align: center;
        padding-bottom: 2rem;
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 2rem;
        font-weight: 700;
    }

    .user-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .user-email {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .account-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .account-nav li {
        margin-bottom: 0.5rem;
    }

    .account-nav a {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.9rem 1rem;
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .account-nav a:hover {
        background-color: var(--light-bg);
        color: var(--primary-green);
    }

    .account-nav a.active {
        background-color: var(--primary-green);
        color: white;
    }

    .account-nav i {
        font-size: 1.2rem;
    }

    .logout-btn {
        width: 100%;
        padding: 0.9rem;
        background-color: #fee;
        color: #dc2626;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #dc2626;
        color: white;
    }

    /* Main Content */
    .account-content {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .content-header {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .content-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .content-header p {
        color: var(--text-muted);
        font-size: 1rem;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--light-bg) 0%, white 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: var(--accent-orange);
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background-color: var(--primary-green);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    /* Recent Orders */
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead {
        background-color: var(--light-bg);
    }

    .orders-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--text-dark);
        border-bottom: 2px solid #e5e7eb;
    }

    .orders-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: var(--text-dark);
    }

    .orders-table tr:hover {
        background-color: var(--light-bg);
    }

    .order-status {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .order-status.completed {
        background-color: #d1fae5;
        color: #065f46;
    }

    .order-status.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .order-status.processing {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .view-order-btn {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .view-order-btn:hover {
        color: var(--accent-orange);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .btn-primary {
        background-color: var(--primary-green);
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-green-dark);
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .account-container {
            grid-template-columns: 1fr;
        }

        .account-sidebar {
            position: static;
        }

        .orders-table {
            font-size: 0.9rem;
        }

        .orders-table th,
        .orders-table td {
            padding: 0.7rem;
        }
    }

    @media (max-width: 768px) {
        .orders-table thead {
            display: none;
        }

        .orders-table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .orders-table td {
            display: flex;
            justify-content: space-between;
            padding: 0.7rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .orders-table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--text-muted);
        }

        .orders-table td:last-child {
            border-bottom: none;
        }
    }
</style>
@endpush

@section('content')
<section class="account-section">
    <div class="container">
        <div class="account-container">
            <!-- Sidebar -->
            <aside class="account-sidebar">
                <div class="user-info">
                    <div class="user-avatar">JD</div>
                    <div class="user-name">John Doe</div>
                    <div class="user-email">john@example.com</div>
                </div>

                <nav>
                    <ul class="account-nav">
                        <li>
                            <a href="#" class="active">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-box-seam"></i>
                                My Orders
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-heart"></i>
                                Wishlist
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-geo-alt"></i>
                                Addresses
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-person"></i>
                                Profile Settings
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-lock"></i>
                                Change Password
                            </a>
                        </li>
                    </ul>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="account-content">
                <div class="content-header">
                    <h1>Welcome Back, John!</h1>
                    <p>Manage your orders and account settings</p>
                </div>

                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <div class="stat-value">12</div>
                        <div class="stat-label">Total Orders</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: var(--accent-orange);">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-value">2</div>
                        <div class="stat-label">Pending Orders</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: #10b981;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-value">10</div>
                        <div class="stat-label">Completed</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: #6366f1;">
                            <i class="bi bi-heart"></i>
                        </div>
                        <div class="stat-value">5</div>
                        <div class="stat-label">Wishlist Items</div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <h2 class="section-title">Recent Orders</h2>

                @php
                    $orders = [
                        [
                            'id' => '#ORD-2024-001',
                            'date' => '2024-12-15',
                            'items' => 'Kienyeji Premium Mash, Dairy Meal',
                            'total' => 6800,
                            'status' => 'completed'
                        ],
                        [
                            'id' => '#ORD-2024-002',
                            'date' => '2024-12-14',
                            'items' => 'Sow & Weaner Premium',
                            'total' => 3800,
                            'status' => 'processing'
                        ],
                        [
                            'id' => '#ORD-2024-003',
                            'date' => '2024-12-12',
                            'items' => 'Broiler Finisher Pellets (x2)',
                            'total' => 6800,
                            'status' => 'pending'
                        ],
                    ];
                @endphp

                @if(count($orders) > 0)
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td data-label="Order ID">{{ $order['id'] }}</td>
                            <td data-label="Date">{{ date('d M Y', strtotime($order['date'])) }}</td>
                            <td data-label="Items">{{ $order['items'] }}</td>
                            <td data-label="Total">KES {{ number_format($order['total']) }}</td>
                            <td data-label="Status">
                                <span class="order-status {{ $order['status'] }}">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </td>
                            <td data-label="Action">
                                <a href="#" class="view-order-btn">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h3>No Orders Yet</h3>
                    <p>You haven't placed any orders yet. Start shopping for quality feeds!</p>
                    <a href="{{ url('/products') }}" class="btn-primary">Browse Products</a>
                </div>
                @endif
            </main>
        </div>
    </div>
</section>
@endsection