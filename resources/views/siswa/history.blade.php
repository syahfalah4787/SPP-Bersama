<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Pembayaran - SPP Bersama</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
    <!-- Top Navigation -->
    <nav class="sticky top-0 z-30 border-b border-slate-200 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/20">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-slate-800">SPP Bersama</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('siswa.dashboard') }}" class="text-sm font-medium {{ request()->routeIs('siswa.dashboard') ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }}">Dashboard</a>
                    <a href="{{ route('siswa.history') }}" class="text-sm font-medium {{ request()->routeIs('siswa.history') ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }}">Riwayat</a>
                    <div class="ml-2 flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 text-xs font-bold text-white">{{ strtoupper(substr($siswa->nama, 0, 1)) }}</div>
                        <form method="POST" action="{{ route('siswa.logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Riwayat Pembayaran</h1>
                <p class="text-sm text-slate-500">Detail pembayaran SPP Anda</p>
            </div>
            <form method="GET" class="flex items-center gap-2">
                <select name="tahun" onchange="this.form.submit()" class="rounded-xl border-slate-200 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach($years as $y)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Monthly Status Overview -->
        <div class="mb-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
            <h3 class="text-base font-semibold text-slate-800 mb-4">Status Bulan - Tahun {{ $tahun }}</h3>
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-12">
                @foreach($bulanList as $bulan)
                @php $isPaid = in_array($bulan, $paidMonths); @endphp
                <div class="rounded-lg p-2 text-center {{ $isPaid ? 'bg-emerald-50 ring-1 ring-emerald-200' : 'bg-slate-50 ring-1 ring-slate-200' }}">
                    <p class="text-[10px] font-semibold {{ $isPaid ? 'text-emerald-700' : 'text-slate-500' }}">{{ substr($bulan, 0, 3) }}</p>
                    @if($isPaid)
                    <svg class="mx-auto mt-0.5 h-4 w-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    @else
                    <svg class="mx-auto mt-0.5 h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Payment History Table -->
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/60">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-base font-semibold text-slate-800">Detail Transaksi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Bulan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tanggal Bayar</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Petugas</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pembayaran as $index => $p)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700">{{ $p->bulan_bayar }}</span></td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $p->tgl_bayar->format('d F Y') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-emerald-600">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $p->petugas->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Lunas
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada riwayat pembayaran untuk tahun {{ $tahun }}</td></tr>
                        @endforelse
                    </tbody>
                    @if($pembayaran->count() > 0)
                    <tfoot>
                        <tr class="border-t-2 border-slate-200 bg-slate-50">
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-slate-800">TOTAL</td>
                            <td class="px-6 py-4 text-sm font-bold text-emerald-600">Rp {{ number_format($pembayaran->sum('jumlah_bayar'), 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </main>
</body>
</html>
