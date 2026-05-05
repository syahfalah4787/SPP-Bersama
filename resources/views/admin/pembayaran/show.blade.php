@extends('layouts.admin')
@section('title', 'Detail Pembayaran')
@section('subtitle', 'ID #{{ $pembayaran->id }}')

@section('content')
<div class="mb-6">
    <a href="{{ route('pembayaran.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div class="mx-auto max-w-2xl rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200/60 dark:bg-slate-800 dark:ring-slate-700/60">
    <!-- Header -->
    <div class="border-b border-slate-200 pb-6 dark:border-slate-700 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/25">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="mt-4 text-xl font-bold text-slate-800 dark:text-white">Bukti Pembayaran SPP</h2>
        <p class="text-sm text-slate-500">{{ $pembayaran->bulan_bayar }} {{ $pembayaran->tahun_bayar }}</p>
    </div>

    <div class="mt-6 space-y-4">
        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
            <span class="text-sm text-slate-500">ID Transaksi</span>
            <span class="text-sm font-mono font-semibold text-slate-800 dark:text-white">#{{ str_pad($pembayaran->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
            <span class="text-sm text-slate-500">Nama Siswa</span>
            <span class="text-sm font-medium text-slate-800 dark:text-white">{{ $pembayaran->siswa->nama ?? '-' }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
            <span class="text-sm text-slate-500">NISN</span>
            <span class="text-sm font-mono text-slate-800 dark:text-white">{{ $pembayaran->nisn }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
            <span class="text-sm text-slate-500">Kelas</span>
            <span class="text-sm text-slate-800 dark:text-white">{{ $pembayaran->siswa->kelas->nama_kelas ?? '-' }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
            <span class="text-sm text-slate-500">Tanggal Bayar</span>
            <span class="text-sm text-slate-800 dark:text-white">{{ $pembayaran->tgl_bayar->format('d F Y') }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
            <span class="text-sm text-slate-500">Petugas</span>
            <span class="text-sm text-slate-800 dark:text-white">{{ $pembayaran->petugas->name ?? '-' }}</span>
        </div>
        <div class="flex justify-between py-3 rounded-xl bg-emerald-50 px-4 dark:bg-emerald-900/30">
            <span class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">Jumlah Bayar</span>
            <span class="text-lg font-bold text-emerald-700 dark:text-emerald-300">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak
        </button>
    </div>
</div>
@endsection
