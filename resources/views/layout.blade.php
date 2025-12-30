<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-collapsed { width: 72px; }
        .sidebar-expanded { width: 16rem; }
        .main-shifted { margin-left: 16rem; }
        .main-collapsed { margin-left: 4.5rem; }
        .avatar-small { width: 32px; height: 32px; }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 transition-colors" id="page-body">

<!-- ================= TOP NAVBAR ================= -->
<header class="fixed top-0 left-0 right-0 z-30 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">

        <!-- LEFT -->
        <div class="flex items-center gap-3">
            <button id="sidebarToggle" class="p-2 rounded hover:bg-gray-100">
                ☰
            </button>
            <a href="{{ route('dashboard') }}" class="font-bold text-green-700 hidden sm:inline">
                Premium Farming Feeds
            </a>
        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">

            <!-- Notifications -->
            <div class="relative">
                <button id="notifBtn" class="p-2 rounded hover:bg-gray-100">
                    🔔
                </button>

                <div id="notifMenu" class="hidden absolute right-0 mt-2 w-72 bg-white border rounded shadow">
                    <div class="p-3 font-semibold">Notifications</div>
                    <div class="divide-y">
                        <div class="p-2 text-sm">No new notifications</div>
                    </div>

                    @if(Route::has('shop.orders'))
                        <div class="p-2 text-center">
                            <a href="{{ route('shop.orders') }}" class="text-green-600 text-sm">View all</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- PROFILE -->
            <div class="relative">
                <button id="profileBtn" class="flex items-center gap-2 px-2 py-1 rounded hover:bg-gray-100">

                    @auth
                        <img class="avatar-small rounded-full"
                             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff">
                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                    @else
                        <img class="avatar-small rounded-full"
                             src="https://ui-avatars.com/api/?name=Guest&background=6B7280&color=fff">
                        <span class="hidden sm:inline">Guest</span>
                    @endauth

                    ⌄
                </button>

                <div id="profileMenu" class="hidden absolute right-0 mt-2 w-44 bg-white border rounded shadow">

                    @auth
                        @if(Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-50">Profile</a>
                        @endif

                        @if(Route::has('dashboard'))
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 hover:bg-gray-50 text-red-600">
                                Logout
                            </button>
                        </form>
                    @else
                        @if(Route::has('login'))
                            <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-50">Login</a>
                        @endif
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-50">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ================= LAYOUT ================= -->
<div class="flex pt-16">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar-expanded fixed top-16 left-0 bottom-0 bg-white border-r">

        <div class="p-4 border-b text-center">
            <h2 class="font-bold text-green-700">Premium Farming Feeds</h2>
        </div>

        <nav class="p-3">
            <ul class="space-y-1">

                @if(($mode ?? '') === 'pos')
                    <li><a href="{{ route('pos.sell') }}" class="block p-2 hover:bg-gray-100">POS</a></li>

                    @if(Route::has('pos.categories'))
                        <li><a href="{{ route('pos.categories') }}" class="block p-2 hover:bg-gray-100">Categories</a></li>
                    @endif

                    @if(Route::has('pos.items'))
                        <li><a href="{{ route('pos.items') }}" class="block p-2 hover:bg-gray-100">Items</a></li>
                    @endif

                    @if(Route::has('pos.stores'))
                        <li><a href="{{ route('pos.stores') }}" class="block p-2 hover:bg-gray-100">Stores</a></li>
                    @endif

                @elseif(($mode ?? '') === 'shop')
                    <li><a href="{{ route('shop.index') }}" class="block p-2 hover:bg-gray-100">Shop Home</a></li>

                    @if(Route::has('shop.products'))
                        <li><a href="{{ route('shop.products') }}" class="block p-2 hover:bg-gray-100">Products</a></li>
                    @endif

                    @if(Route::has('shop.orders'))
                        <li><a href="{{ route('shop.orders') }}" class="block p-2 hover:bg-gray-100">Orders</a></li>
                    @endif
                @else
                    <li><a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-100">Dashboard</a></li>
                    <li><a href="{{ route('shop.index') }}" class="block p-2 hover:bg-gray-100">Shop</a></li>
                @endif
            </ul>
        </nav>
    </aside>

    <!-- MAIN -->
    <main id="mainContent" class="flex-1 p-6 ml-64">
        @yield('content')
    </main>
</div>

<!-- ================= SCRIPTS ================= -->
<script>
    const toggle = (id) => document.getElementById(id)?.classList.toggle('hidden');

    document.getElementById('profileBtn')?.addEventListener('click', e => {
        e.stopPropagation(); toggle('profileMenu');
    });

    document.getElementById('notifBtn')?.addEventListener('click', e => {
        e.stopPropagation(); toggle('notifMenu');
    });

    document.addEventListener('click', () => {
        document.getElementById('profileMenu')?.classList.add('hidden');
        document.getElementById('notifMenu')?.classList.add('hidden');
    });
</script>

</body>
</html>
