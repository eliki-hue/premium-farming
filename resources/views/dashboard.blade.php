<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Premium Feeds</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #198754;
            --secondary: #0d6efd;
            --warning: #ffc107;
            --info: #0dcaf0;
        }
        
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-top: 4px solid var(--primary);
            text-align: center;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            color: white;
            background: var(--primary);
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #212529;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 14px;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/">
                <i class="fas fa-store me-2"></i>Premium Feeds
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @if(auth()->user()->pos_access ?? false)
                        <li>
                            <a class="dropdown-item text-success" href="{{ route('pos.sell') }}">
                                <i class="fas fa-cash-register me-2"></i> POS System
                            </a>
                        </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <!-- Welcome Message -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Welcome back, {{ auth()->user()->name }}! 👋</h4>
                <p class="card-text text-muted">
                    @if(auth()->user()->pos_access ?? false)
                        You have access to the POS system. Click the button below to start selling.
                    @else
                        Welcome to your Premium Feeds dashboard.
                    @endif
                </p>
                
                @if(auth()->user()->pos_access ?? false)
                <a href="{{ route('pos.sell') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-cash-register me-2"></i> Open POS System
                </a>
                @endif
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-value">
                    KSh {{ number_format($todaySales ?? 0) }}
                </div>
                <div class="stat-label">Today's Sales</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">
                    {{ $todayOrders ?? 0 }}
                </div>
                <div class="stat-label">Today's Orders</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value">
                    {{ $totalProducts ?? 0 }}
                </div>
                <div class="stat-label">Total Products</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">
                    @php
                        // Count distinct customers safely
                        try {
                            // Try to count by customer_phone if column exists
                            if (Schema::hasColumn('orders', 'customer_phone')) {
                                $totalCustomers = \App\Models\Order::distinct('customer_phone')->count('customer_phone');
                            } else {
                                $totalCustomers = \App\Models\Order::distinct('customer_email')->count('customer_email');
                            }
                        } catch (\Exception $e) {
                            $totalCustomers = 0;
                        }
                    @endphp
                    {{ $totalCustomers ?? 0 }}
                </div>
                <div class="stat-label">Total Customers</div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-rocket me-2"></i> Quick Links
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="/pos/sell" class="list-group-item list-group-item-action">
                                <i class="fas fa-store me-2"></i> Visit Shop
                            </a>
                            <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-box me-2"></i> Browse Products
                            </a>
                            <a href="{{ route('cart.view') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-cart me-2"></i> View Cart
                            </a>
                            @if(auth()->user()->pos_access ?? false)
                            <a href="{{ route('pos.sell') }}" class="list-group-item list-group-item-action text-success">
                                <i class="fas fa-cash-register me-2">POS System</i> 
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-history me-2"></i> Recent Activity
                    </div>
                    <div class="card-body">
                        @php
                            // Get recent orders safely
                            try {
                                $recentOrders = \App\Models\Order::where('user_id', auth()->id())
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                            } catch (\Exception $e) {
                                $recentOrders = collect();
                            }
                        @endphp
                        
                        @if($recentOrders->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentOrders as $order)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Order #{{ $order->order_number ?? 'N/A' }}</strong>
                                            <small class="d-block text-muted">{{ $order->created_at->format('M d, h:i A') ?? '' }}</small>
                                        </div>
                                        <span class="badge bg-success">KSh {{ number_format($order->total_amount ?? 0) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-3">No recent orders</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Store Info -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> Store Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6><i class="fas fa-clock text-primary me-2"></i> Business Hours</h6>
                        <p class="mb-0">Monday - Saturday: 8:00 AM - 6:00 PM</p>
                        <p>Sunday: 9:00 AM - 4:00 PM</p>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-phone text-success me-2"></i> Contact</h6>
                        <p class="mb-0">Phone: +254 700 123 456</p>
                        <p>Email: info@premiumfeeds.com</p>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-map-marker-alt text-danger me-2"></i> Location</h6>
                        <p class="mb-0">Nairobi, Kenya</p>
                        <p>CBD, Kimathi Street</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-update time
        function updateTime() {
            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                const now = new Date();
                timeElement.textContent = now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });
            }
        }
        
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>