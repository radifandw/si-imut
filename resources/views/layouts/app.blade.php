<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SI-IMUT') — Sistem Informasi Mutasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-150; }
        .sidebar-link:hover { @apply bg-white/10; }
        .sidebar-link.active { @apply bg-white text-blue-700; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen" x-data="{ sidebarOpen: true }">

{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-blue-700 to-blue-900 text-white transition-transform duration-300 flex flex-col shadow-xl">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-white/20">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
            <span class="text-blue-700 font-extrabold text-sm">SI</span>
        </div>
        <div>
            <div class="font-bold text-lg leading-none">SI-IMUT</div>
            <div class="text-xs text-blue-200">Sistem Informasi Mutasi</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @yield('sidebar-menu')
    </nav>

    {{-- User info --}}
    <div class="px-4 py-4 border-t border-white/20">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-blue-200 capitalize">{{ auth()->user()->role }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-blue-200 hover:text-white transition" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Main --}}
<div :class="sidebarOpen ? 'ml-64' : 'ml-0'" class="transition-all duration-300 min-h-screen flex flex-col">

    {{-- Topbar --}}
    <header class="sticky top-0 z-30 bg-white shadow-sm flex items-center justify-between px-6 py-3">
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-bars text-lg"></i>
            </button>
            <div>
                <h1 class="font-semibold text-gray-800 text-sm">@yield('page-title', 'Dashboard')</h1>
                <div class="text-xs text-gray-400">@yield('breadcrumb', 'Home')</div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <div class="text-xs font-medium text-gray-700">{{ auth()->user()->instansi }}</div>
                <div class="text-xs text-gray-400">{{ now()->translatedFormat('d F Y') }}</div>
            </div>
            <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </header>

    {{-- Alerts --}}
    <div class="px-6 pt-4">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-2 text-sm">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
                <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600"><i class="fas fa-times"></i></button>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-2 text-sm">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                {{ session('error') }}
                <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <main class="flex-1 px-6 pb-8 pt-2">
        @yield('content')
    </main>

    <footer class="text-center text-xs text-gray-400 py-4 border-t">
        © {{ date('Y') }} SI-IMUT — Sistem Informasi Mutasi Kabupaten
    </footer>
</div>

@stack('scripts')
</body>
</html>
