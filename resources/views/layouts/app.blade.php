<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? config('app.name', 'POS System') }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
:root {
    --primary: #1d4ed8;
    --primary-soft: #eff6ff;
    --dark: #0f172a;
    --muted: #64748b;
    --light: #f8fafc;
}

/* ===== GLOBAL ===== */
body {
    margin: 0;
    font-family: "Inter", system-ui, sans-serif;
    background: var(--light);
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 260px;
    background: linear-gradient(180deg, #0d39a1, #1e293b);
    color: #fff;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    padding: 20px 15px;
}

.logo-box {
    text-align: center;
    margin-bottom: 35px;
}

.logo-box img {
    width: 110px;
    border-radius: 10px;
}

.logo-box h5 {
    margin-top: 12px;
    font-weight: 700;
}

.menu-title {
    font-size: 11px;
    letter-spacing: 1px;
    color: #94a3b8;
    margin: 18px 0 10px;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #e5e7eb;
    text-decoration: none;
    padding: 11px 14px;
    border-radius: 10px;
    font-size: 15px;
    transition: 0.2s;
}

.sidebar a:hover,
.sidebar a.active {
    background: rgba(255,255,255,0.12);
    color: #fff;
}

/* ===== TOPBAR ===== */
.topbar {
    height: 70px;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    position: fixed;
    left: 260px;
    right: 0;
    top: 0;
    z-index: 100;
}

.search input {
    border-radius: 30px;
    padding: 7px 16px;
    width: 280px;
    border: 1px solid #cbd5e1;
}

.top-icons {
    display: flex;
    align-items: center;
    gap: 22px;
}

/* Notification */
.notify {
    position: relative;
    cursor: pointer;
}

.notify span {
    position: absolute;
    top: -6px;
    right: -8px;
    background: red;
    color: #fff;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 50%;
}

/* Dropdowns */
.dropdown-menu {
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    border: none;
}

/* ===== CONTENT ===== */
.content {
    margin-left: 260px;
    padding: 100px 30px 30px;
    min-height: 100vh;
}

/* ===== POS CARDS ===== */
.card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.07);
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo-box">
        <img src="{{ asset('images/logo.jpeg') }}">
        <h5>Premium Farming Feeds</h5>
        <small class="text-secondary">POS Management</small>
    </div>

    <div class="menu-title">MAIN</div>
    <a href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="menu-title">POINT OF SALE</div>
    <a href="{{ route('pos.sell') }}">
        <i class="bi bi-cart-check"></i> POS Sell
    </a>
    <a href="{{ route('pos.categories') }}">
        <i class="bi bi-tags"></i> Categories
    </a>
    <a href="{{ route('pos.conversion') }}">
        <i class="bi bi-shop"></i> Conversion
    </a>
    <a href="{{ route('pos.goods-received') }}">
        <i class="bi bi-box-seam"></i> Goods Received
    </a>
    <a href="{{ route('pos.update-prices') }}">
        <i class="bi bi-cash-stack"></i> Update Prices
    </a>
    <a href="/reports/sales">
        <i class="bi bi-bar-chart-line"></i> Sales Report
    </a>

    <div class="menu-title">ACCOUNT</div>
    <a href="/profile">
        <i class="bi bi-person"></i> Profile
    </a>
    <a href="/logout" class="text-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

</div>

<!-- TOP BAR -->
<div class="topbar">

    <div class="search">
        <input type="text" placeholder="Search products, invoices...">
    </div>

    <div class="top-icons">

        <!-- Notifications -->
        <div class="dropdown">
            <div class="notify" data-bs-toggle="dropdown">
                <i class="bi bi-bell fs-5 text-primary"></i>
                <span>2</span>
            </div>
            <ul class="dropdown-menu dropdown-menu-end p-3" style="width:280px">
                <li class="fw-bold mb-2">Notifications</li>
                <li class="small text-muted">Low stock on Chick Mash</li>
                <li class="small text-muted">New sale recorded</li>
            </ul>
        </div>

        <!-- User -->
        <div class="dropdown">
            <a data-bs-toggle="dropdown" class="text-decoration-none text-dark">
                <i class="bi bi-person-circle fs-4"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                <li><a class="dropdown-item" href="/settings">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
            </ul>
        </div>

    </div>
</div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
