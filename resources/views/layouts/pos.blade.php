<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>POS System | Premium Farming Feeds</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        /* Simple POS Layout */
        .pos-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .pos-sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .pos-logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .pos-logo-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 2px solid #3498db;
        }
        
        .pos-logo-text {
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
        }
        
        .pos-nav {
            padding: 0 10px;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            color: #bdc3c7;
            padding: 12px 15px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            background: #34495e;
            color: white;
        }
        
        .nav-link.active {
            background: #3498db;
            color: white;
        }
        
        .nav-link i {
            width: 25px;
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        /* Main Content */
        .pos-main {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
        }
        
        .pos-header {
            background: white;
            padding: 15px 25px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .pos-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .pos-content {
            padding: 25px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .pos-sidebar {
                width: 70px;
                padding: 15px 0;
            }
            
            .pos-logo-text,
            .nav-link span {
                display: none;
            }
            
            .nav-link {
                justify-content: center;
                padding: 15px;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 1.3rem;
            }
            
            .pos-main {
                margin-left: 70px;
            }
            
            .pos-content {
                padding: 15px;
            }
        }
        
        /* Simple Card */
        .pos-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="pos-container">
        <!-- Sidebar -->
        <aside class="pos-sidebar">
            <div class="pos-logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="pos-logo-img">
                <div class="pos-logo-text d-none d-md-block">POS System</div>
            </div>
            
            <nav class="pos-nav">
                <div class="nav-item">
                    <a href="{{ route('pos.dashboard') }}" class="nav-link {{ request()->routeIs('pos.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pos.sell') }}" class="nav-link {{ request()->routeIs('pos.sell') ? 'active' : '' }}">
                        <i class="fas fa-cash-register"></i>
                        <span>Sell</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pos.products') }}" class="nav-link {{ request()->routeIs('pos.products') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span>Products</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pos.orders') }}" class="nav-link {{ request()->routeIs('pos.orders') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Orders</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pos.reports') }}" class="nav-link {{ request()->routeIs('pos.reports') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pos.customers') }}" class="nav-link {{ request()->routeIs('pos.customers') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Customers</span>
                    </a>
                </div>
                  <div class="nav-item">
                    <a href="{{ route('pos.conversion') }}" class="nav-link {{ request()->routeIs('pos.conversion') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Conversions</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pos.inventory') }}" class="nav-link {{ request()->routeIs('pos.inventory') ? 'active' : '' }}">
                        <i class="fas fa-warehouse"></i>
                        <span>Inventory</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('pos.settings') }}" class="nav-link {{ request()->routeIs('pos.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </div>
                
                <div class="nav-item mt-4">
                    <a href="{{ url('/') }}" class="nav-link text-warning">
                        <i class="fas fa-home"></i>
                        <span>Main Site</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="pos-main">
            <!-- Header -->
            <header class="pos-header">
                <h4 class="mb-0 fw-bold">
                    @yield('page-title', 'POS System')
                </h4>
                
                <div class="pos-user">
                    <span class="badge bg-primary">
                        <i class="fas fa-user me-1"></i> {{ auth()->user()->name }}
                    </span>
                    <span class="text-muted" id="current-time"></span>
                </div>
            </header>

            <!-- Content -->
            <div class="pos-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const dateString = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric' });
            
            document.getElementById('current-time').textContent = `${dateString} • ${timeString}`;
        }
        
        updateTime();
        setInterval(updateTime, 60000);
        
        // Auto-dismiss alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    <!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">➕ Add New Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pos.products') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Selling Price (KSh) *</label>
                            <input type="number" name="selling_price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Qty *</label>
                            <input type="number" name="stock" class="form-control" required value="10">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit</label>
                            <select name="unit" class="form-select">
                                <option value="bag">Bag</option>
                                <option value="kg">KG</option>
                                <option value="ltr">Litre</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="poultry">Poultry</option>
                                <option value="pig">Pig</option>
                                <option value="pet">Pet</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>