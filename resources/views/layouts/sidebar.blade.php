<!-- Sidebar Navigation -->
<aside class="fixed inset-y-0 left-0 z-40 w-64 transform bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 transition-transform duration-300 ease-in-out lg:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <!-- Logo -->
    <div class="flex h-16 items-center gap-3 border-b border-slate-700/50 px-6">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/30">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <div>
            <h1 class="text-sm font-bold text-white tracking-wide">SPP Bersama</h1>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest">Payment System</p>
        </div>
    </div>

    <!-- Nav Links -->
    <nav class="mt-6 space-y-1 px-3">
        <p class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Menu Utama</p>

        <a href="{{ route('dashboard') }}"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('pembayaran.index') }}"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('pembayaran.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('pembayaran.*') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Pembayaran
        </a>

        @if(auth()->user()->isAdmin())
        <p class="mb-3 mt-6 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Master Data</p>

        <a href="{{ route('siswa.index') }}"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('siswa.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('siswa.*') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Data Siswa
        </a>

        <a href="{{ route('kelas.index') }}"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('kelas.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('kelas.*') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Data Kelas
        </a>

        <a href="{{ route('spp.index') }}"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('spp.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('spp.*') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Data SPP
        </a>

        <a href="{{ route('petugas.index') }}"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('petugas.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('petugas.*') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Data Petugas
        </a>

        <p class="mb-3 mt-6 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Laporan</p>

        <a href="{{ route('laporan.index') }}"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('laporan.*') ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Laporan
        </a>
        @endif
    </nav>

    <!-- Bottom Section -->
    <div class="absolute bottom-0 left-0 right-0 border-t border-slate-700/50 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-slate-800/50 p-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 text-sm font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
</aside>
