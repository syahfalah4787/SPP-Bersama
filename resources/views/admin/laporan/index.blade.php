@extends('layouts.admin')
@section('title', 'Laporan Pembayaran')
@section('subtitle', 'Generate dan cetak laporan')

@section('content')
<!-- Filter Form -->
<div class="rounded bg-navy p-6 shadow-xl border border-white/10">
    <h3 class="text-base font-bold text-white">Filter Laporan</h3>
    <form method="GET" class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div>
            <label class="block text-sm font-medium text-slate-300">Bulan</label>
            <select name="bulan" class="mt-1 w-full rounded border border-white/20 bg-navy text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                <option value="">Semua Bulan</option>
                @foreach($bulanList as $b)
                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-300">Tahun</label>
            <select name="tahun" class="mt-1 w-full rounded border border-white/20 bg-navy text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                @foreach($years as $y)
                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-300">Siswa</label>
            <select name="nisn" class="mt-1 w-full rounded border border-white/20 bg-navy text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                <option value="">Semua Siswa</option>
                @foreach($siswaList as $s)
                <option value="{{ $s->nisn }}" {{ $nisn == $s->nisn ? 'selected' : '' }}>{{ $s->nama }} ({{ $s->nisn }})</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 rounded bg-[#0ea5e9] px-4 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-sky-600">Filter</button>
            <a href="{{ route('laporan.print', request()->query()) }}" target="_blank" class="rounded bg-white/10 px-4 py-2.5 text-sm font-bold text-white hover:bg-white/20">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            </a>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
    <!-- Card 1 -->
    <div class="bg-navy p-6 flex flex-col relative overflow-hidden shadow-lg border border-white/10">
        <div class="flex justify-between items-start">
            <div class="w-12 h-12 flex items-center justify-center border-2 border-white/10 rounded-full">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="text-right">
                <h3 class="text-[42px] font-bold text-white leading-none tracking-tighter">{{ number_format($totalRecords) }}</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Total Transaksi</p>
            </div>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="bg-navy p-6 flex flex-col relative overflow-hidden shadow-lg border border-white/10">
        <div class="flex justify-between items-start">
            <div class="w-12 h-12 flex items-center justify-center border-2 border-white/10 rounded-full">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
            <div class="text-right">
                <h3 class="text-3xl font-bold text-white leading-none tracking-tighter">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Total Pendapatan</p>
            </div>
        </div>
    </div>
</div>

<!-- Report Table -->
<div class="mt-6 overflow-hidden rounded bg-navy shadow-xl border border-white/10">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10 bg-black/20 text-white">
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">No</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">NISN</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Nama Siswa</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Kelas</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Bulan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($pembayaran as $index => $p)
                <tr class="transition hover:bg-white/5">
                    <td class="px-6 py-4 text-sm text-slate-300">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm font-mono text-slate-300">{{ $p->nisn }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-white">{{ $p->siswa->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-300">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="px-6 py-4"><span class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-0.5 text-xs font-medium text-white">{{ $p->bulan_bayar }} {{ $p->tahun_bayar }}</span></td>
                    <td class="px-6 py-4 text-sm text-slate-300">{{ $p->tgl_bayar->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-[#10b981]">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-slate-300">{{ $p->petugas->name ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada data untuk filter ini</td></tr>
                @endforelse
            </tbody>
            @if($pembayaran->count() > 0)
            <tfoot>
                <tr class="border-t-2 border-white/20 bg-black/40">
                    <td colspan="6" class="px-6 py-4 text-right text-sm font-bold text-white">TOTAL</td>
                    <td class="px-6 py-4 text-sm font-bold text-[#10b981]">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
