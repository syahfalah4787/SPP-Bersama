<!-- Top Navigation Bar -->
<header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white/80 px-4 backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/80 sm:px-6 lg:px-8">
    <!-- Left: Hamburger + Title -->
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-700 lg:hidden">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div>
            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">@yield('title', 'Dashboard')</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">@yield('subtitle', '')</p>
        </div>
    </div>

    <!-- Right: User Menu -->
    <div class="flex items-center gap-3">
        <div class="hidden text-right sm:block">
            <p class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ auth()->user()->name }}</p>
            <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
        </div>
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-sm font-bold text-white shadow-md shadow-indigo-500/20 transition hover:shadow-lg">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-200 bg-white py-1 shadow-xl dark:border-slate-700 dark:bg-slate-800">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </a>
                <div class="my-1 border-t border-slate-100 dark:border-slate-700"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
