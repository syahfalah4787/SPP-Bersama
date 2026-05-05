@extends('layouts.admin')
@section('title', 'Data Pembayaran')
@section('subtitle', 'Riwayat transaksi pembayaran SPP')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <form method="GET" class="relative">
        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari NISN, nama..." class="w-full rounded border border-white/20 bg-navy text-white placeholder-slate-400 py-2.5 pl-10 pr-4 text-sm shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9] sm:w-72">
    </form>
    <a href="{{ route('pembayaran.create') }}" class="inline-flex items-center gap-2 rounded bg-[#0ea5e9] px-4 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-sky-600">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Entri Pembayaran
    </a>
</div>

<div class="mt-6 overflow-hidden rounded bg-navy shadow-xl border border-white/10">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10 bg-black/20 text-white">
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">No</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Siswa</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Bulan/Tahun</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Petugas</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($pembayaran as $index => $p)
                <tr class="transition hover:bg-white/5">
                    <td class="px-6 py-4 text-sm text-slate-300">{{ $pembayaran->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#0ea5e9]/20 text-xs font-bold text-[#0ea5e9]">{{ strtoupper(substr($p->siswa->nama ?? '-', 0, 2)) }}</div>
                            <div>
                                <p class="text-sm font-bold text-white">{{ $p->siswa->nama ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $p->nisn }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-0.5 text-xs font-medium text-white">{{ $p->bulan_bayar }} {{ $p->tahun_bayar }}</span></td>
                    <td class="px-6 py-4 text-sm font-bold text-[#10b981]">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-slate-300">{{ $p->petugas->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-300">{{ $p->tgl_bayar->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($p->siswa)
                            <a href="{{ route('siswa.show', $p->nisn) }}" class="rounded p-1.5 text-slate-300 transition hover:bg-white/10 hover:text-white" title="Detail Siswa">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @else
                            <button disabled class="rounded p-1.5 text-slate-600" title="Siswa tidak ditemukan">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            @endif
                            @if(auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('pembayaran.destroy', $p) }}" onsubmit="return confirm('Yakin ingin menghapus riwayat pembayaran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded p-1.5 text-[#ef4444] transition hover:bg-[#ef4444]/10">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada data pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pembayaran->hasPages())
    <div class="border-t border-white/10 px-6 py-4">{{ $pembayaran->links() }}</div>
    @endif
</div>
@endsection
