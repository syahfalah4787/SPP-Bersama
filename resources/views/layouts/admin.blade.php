<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SPP Bersama') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-navy { background-color: #061a35; }
        .text-navy { color: #061a35; }
    </style>
</head>
<body class="font-sans antialiased h-screen flex flex-col bg-[#f4f6f9]" x-data="{ sidebarOpen: false }">


    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col relative" style="min-height:0">
        
        <!-- Top Navy Bar (Full Width) -->
        <div class="relative bg-navy h-20 flex items-center justify-between px-4 md:px-6 z-30 shadow-md">
            <!-- Left Profile & Hamburger -->
            <div class="flex items-center gap-3 md:gap-4">
                <!-- Hamburger Menu (Mobile) -->
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-white hover:text-slate-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center flex-shrink-0 shadow-inner">
                    <!-- User Icon -->
                    <svg class="w-7 h-7 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="text-white hidden sm:block">
                    <h2 class="font-bold text-[17px] leading-tight">{{ auth()->user()->name }}</h2>
                    <p class="text-[11px] text-slate-300 mt-0.5">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
            
            <!-- Right Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-red-500 hover:text-red-400 transition">
                    <span class="text-xs font-bold">Log-out</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Lower Section (Sidebar + Main Content) -->
        <div class="flex relative" style="height:calc(100vh - 5rem);min-height:0">
            
            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>

            <!-- Left Navy Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="absolute md:relative w-[220px] bg-navy h-full flex-shrink-0 flex flex-col z-40 shadow-xl transition-transform duration-300 md:translate-x-0">
                <nav class="flex-1 px-4 pt-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-2 py-3 border-b border-white/20 text-white hover:bg-white/5 transition {{ request()->routeIs('dashboard') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        <span class="font-semibold text-[13px]">Dashboard</span>
                    </a>

                    <!-- Kelola Data (Admin Only) -->
                    @if(auth()->user()->role === 'admin')
                    <div x-data="{ open: {{ request()->is('siswa*') || request()->is('kelas*') || request()->is('spp*') || request()->is('petugas*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-3 border-b border-white/20 text-white hover:bg-white/5 transition">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-semibold text-[13px]">Kelola Data</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-collapse class="pl-9 pr-2 py-2 space-y-1 bg-black/10">
                            <a href="{{ route('siswa.index') }}" class="block px-2 py-1.5 text-xs text-slate-300 hover:text-white hover:bg-white/5 rounded">Data Siswa</a>
                            <a href="{{ route('kelas.index') }}" class="block px-2 py-1.5 text-xs text-slate-300 hover:text-white hover:bg-white/5 rounded">Data Kelas</a>
                            <a href="{{ route('spp.index') }}" class="block px-2 py-1.5 text-xs text-slate-300 hover:text-white hover:bg-white/5 rounded">Data SPP</a>
                            <a href="{{ route('petugas.index') }}" class="block px-2 py-1.5 text-xs text-slate-300 hover:text-white hover:bg-white/5 rounded">Data Petugas</a>
                        </div>
                    </div>
                    @endif

                    <a href="{{ route('pembayaran.index') }}" class="flex items-center gap-3 px-2 py-3 border-b border-white/20 text-white hover:bg-white/5 transition {{ request()->routeIs('pembayaran.*') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold text-[13px]">Pembayaran</span>
                    </a>

                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-2 py-3 border-b border-white/20 text-white hover:bg-white/5 transition {{ request()->routeIs('laporan.*') ? 'bg-white/10' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-semibold text-[13px]">Laporan</span>
                    </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 relative" style="overflow-y:auto;min-height:0;background:url('{{ asset('image/sekolah1.jpg') }}') center/cover fixed no-repeat">
                
                <!-- Background Overlay -->
                <div class="fixed inset-0 bg-white/10 backdrop-blur-[1px] z-0 pointer-events-none md:left-[220px] top-20"></div>

                <!-- Page Content -->
                <div class="relative z-10 px-4 py-6 md:px-8 md:py-8 max-w-7xl mx-auto flex flex-col">
                    
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                         class="mb-6 rounded border border-emerald-200 bg-emerald-50/90 backdrop-blur-sm p-4">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-emerald-700">{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                         class="mb-6 rounded border border-red-200 bg-red-50/90 backdrop-blur-sm p-4">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-red-700">{{ session('error') }}</span>
                        </div>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
