<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Siswa - SPP Bersama</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-navy { background-color: #061a35; }
        .text-navy { color: #061a35; }
    </style>
</head>
<body class="font-sans antialiased h-screen flex flex-col bg-[#f4f6f9]">



    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col relative" style="min-height:0">
        
        <!-- Top Navy Bar (Full Width) -->
        <div class="bg-navy h-20 flex items-center justify-between px-6 z-30 shadow-md">
            <!-- Left Profile -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center flex-shrink-0 shadow-inner">
                    <!-- Academic Cap Icon -->
                    <svg class="w-7 h-7 text-navy" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                      <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                    </svg>
                </div>
                <div class="text-white">
                    <h2 class="font-bold text-[17px] leading-tight">{{ $siswa->nama }}</h2>
                    <p class="text-[11px] text-slate-300 mt-0.5">{{ $siswa->kelas->nama_kelas }}</p>
                </div>
            </div>
            
            <!-- Right Logout -->
            <form method="POST" action="{{ route('siswa.logout') }}">
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
            
            <!-- Left Navy Sidebar -->
            <aside class="w-[220px] bg-navy h-full flex-shrink-0 flex flex-col z-20 shadow-xl">
                <nav class="flex-1 px-4 pt-4">
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-2 py-2 border-b border-white/80 text-white hover:bg-white/5 transition">
                        <!-- 4 Squares Icon -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="font-semibold text-[13px]">Dashboard</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 relative" style="overflow-y:auto;min-height:0;background:url('{{ asset('image/sekolah1.jpg') }}') center/cover fixed no-repeat">
                
                <!-- Background Overlay -->
                <div class="fixed inset-0 bg-white/10 backdrop-blur-[1px] z-0 pointer-events-none" style="left:220px;top:5rem"></div>

                <!-- Cards & Content -->
                <div class="relative z-10 px-8 py-8 max-w-6xl mx-auto flex flex-col">
                    
                    <!-- Student Info Banner -->
                    <div class="bg-navy rounded-lg shadow-xl px-6 py-4 flex flex-wrap lg:flex-nowrap divide-x divide-white/20 text-white mb-6 border border-white/10">
                        <div class="px-4 py-1 first:pl-0 flex-1">
                            <p class="text-xs text-slate-300 mb-0.5">Nama</p>
                            <p class="text-[13px] font-medium">{{ $siswa->nama }}</p>
                        </div>
                        <div class="px-4 py-1 flex-1">
                            <p class="text-xs text-slate-300 mb-0.5">Kelas</p>
                            <p class="text-[13px] font-medium">{{ $siswa->kelas->nama_kelas }}</p>
                        </div>
                        <div class="px-4 py-1 flex-1">
                            <p class="text-xs text-slate-300 mb-0.5">NIS</p>
                            <p class="text-[13px] font-medium">{{ $siswa->nis }}</p>
                        </div>
                        <div class="px-4 py-1 flex-1">
                            <p class="text-xs text-slate-300 mb-0.5">NISN</p>
                            <p class="text-[13px] font-medium">{{ $siswa->nisn }}</p>
                        </div>
                        <div class="px-4 py-1 flex-1">
                            <p class="text-xs text-slate-300 mb-0.5">NO Tlpn.</p>
                            <p class="text-[13px] font-medium">{{ $siswa->no_telp }}</p>
                        </div>
                        <div class="px-4 py-1 flex-1">
                            <p class="text-xs text-slate-300 mb-0.5">Alamat</p>
                            <p class="text-[11px] leading-tight font-medium">{{ $siswa->alamat }}</p>
                        </div>
                    </div>

                    <!-- Financial Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Total Pembayaran -->
                        <div class="bg-navy rounded-lg shadow-xl p-6 text-white flex flex-col justify-center border border-white/10">
                            <p class="text-[11px] font-bold mb-4">Total Pembayaran <span class="text-slate-400 font-normal ml-0.5">({{ now()->format('d/m/Y') }})</span></p>
                            <h3 x-data="{ count: 0, target: {{ $totalExpected }} }" 
                                x-init="let step = Math.ceil(target / 50) || 1; let timer = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(timer); } }, 20);" 
                                x-text="'RP. ' + count.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})" 
                                class="text-[26px] font-bold text-[#0ea5e9]">RP. 0,00</h3>
                        </div>
                        
                        <!-- Jatuh Tempo -->
                        <div class="bg-navy rounded-lg shadow-xl p-6 text-white flex flex-col justify-center border border-white/10">
                            <p class="text-[11px] font-bold mb-4">Jatuh Tempo <span class="text-slate-400 font-normal ml-0.5">({{ now()->format('d/m/Y') }})</span></p>
                            <h3 x-data="{ count: 0, target: {{ $remaining }} }" 
                                x-init="let step = Math.ceil(target / 50) || 1; let timer = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(timer); } }, 20);" 
                                x-text="'RP. ' + count.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})" 
                                class="text-[26px] font-bold text-[#ef4444]">RP. 0,00</h3>
                        </div>

                        <!-- Total Dibayarkan -->
                        <div class="bg-navy rounded-lg shadow-xl p-6 text-white flex flex-col justify-center border border-white/10">
                            <p class="text-[11px] font-bold mb-4">Total Dibayarkan <span class="text-slate-400 font-normal ml-0.5">({{ now()->format('d/m/Y') }})</span></p>
                            <h3 x-data="{ count: 0, target: {{ $totalPaid }} }" 
                                x-init="let step = Math.ceil(target / 50) || 1; let timer = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(timer); } }, 20);" 
                                x-text="'RP. ' + count.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})" 
                                class="text-[26px] font-bold text-[#10b981]">RP. 0,00</h3>
                        </div>
                    </div>

                    <!-- Riwayat Pembayaran -->
                    <div class="flex-1 mt-2">
                        <div class="flex items-center gap-2 text-white mb-4 drop-shadow-md bg-navy/80 w-fit px-4 py-1.5 rounded-full border border-white/10 backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h2 class="text-sm font-bold tracking-wide">Riwayat Pembayaran</h2>
                        </div>

                        <div class="space-y-2">
                            @forelse($siswa->pembayaran->sortByDesc('tgl_bayar')->take(4) as $idx => $pembayaran)
                            <div class="bg-navy rounded shadow-lg px-6 py-2.5 flex items-center justify-between text-white border border-white/10 hover:bg-navy/90 transition">
                                <div class="flex items-center gap-4 w-1/3">
                                    <span class="text-lg font-bold">{{ $idx + 1 }}.</span>
                                    <div>
                                        <h4 class="font-bold text-[13px]">{{ $siswa->nama }}</h4>
                                        <p class="text-[11px] text-slate-300">{{ $siswa->kelas->nama_kelas }}</p>
                                    </div>
                                </div>
                                <div class="w-1/3 text-center">
                                    <span class="text-lg font-bold tracking-wide">RP. {{ number_format($pembayaran->jumlah_bayar, 2, ',', '.') }}</span>
                                </div>
                                <div class="w-1/3 text-right">
                                    <p class="text-[11px] text-slate-300">({{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d/m/Y') }})</p>
                                    <p class="text-[11px] text-slate-400">TRX-{{ str_pad($pembayaran->id, 7, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="bg-navy rounded shadow-lg p-6 text-center text-white border border-white/10">
                                <p class="text-sm">Belum ada riwayat pembayaran.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

</body>
</html>
