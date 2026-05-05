@extends('layouts.admin')
@section('title', 'Detail Siswa')
@section('subtitle', $siswa->nama)

@section('content')
<div class="mb-6">
    <a href="{{ route('siswa.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-300 hover:text-white transition">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Data Siswa
    </a>
</div>

<!-- Student Info Card -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="rounded bg-navy p-6 shadow-xl border border-white/10">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 text-2xl font-bold text-white shadow-lg">
                {{ strtoupper(substr($siswa->nama, 0, 2)) }}
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">{{ $siswa->nama }}</h3>
                <p class="text-sm text-slate-400">NISN: {{ $siswa->nisn }} | NIS: {{ $siswa->nis }}</p>
            </div>
        </div>
        <div class="mt-6 space-y-3">
            <div class="flex justify-between text-sm"><span class="text-slate-400">Kelas</span><span class="font-medium text-white">{{ $siswa->kelas->nama_kelas }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-slate-400">Kompetensi</span><span class="font-medium text-white">{{ $siswa->kelas->kompetensi_keahlian }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-slate-400">Alamat</span><span class="font-medium text-white text-right max-w-[60%]">{{ $siswa->alamat }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-slate-400">No. Telp</span><span class="font-medium text-white">{{ $siswa->no_telp }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-slate-400">SPP/Bulan</span><span class="font-bold text-[#10b981]">Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</span></div>
        </div>
    </div>

    <!-- Payment Status Grid -->
    <div class="lg:col-span-2 rounded bg-navy p-6 shadow-xl border border-white/10">
        <h3 class="text-base font-bold text-white">Status Pembayaran {{ $currentYear }}</h3>
        <p class="text-sm text-slate-400">Status pembayaran per bulan</p>
        <div class="mt-4 grid grid-cols-3 gap-3 sm:grid-cols-4 lg:grid-cols-6">
            @foreach($bulanList as $bulan)
            @php $isPaid = in_array($bulan, $paidMonths); @endphp
            <div class="rounded border p-3 text-center transition {{ $isPaid ? 'bg-[#10b981]/20 border-[#10b981]/50' : 'bg-[#ef4444]/10 border-[#ef4444]/30' }}">
                <p class="text-xs font-bold {{ $isPaid ? 'text-[#10b981]' : 'text-[#ef4444]' }}">{{ substr($bulan, 0, 3) }}</p>
                <div class="mt-1">
                    @if($isPaid)
                    <svg class="mx-auto h-5 w-5 text-[#10b981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                    <svg class="mx-auto h-5 w-5 text-[#ef4444]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    @endif
                </div>
                <p class="mt-1 text-[10px] font-bold {{ $isPaid ? 'text-[#10b981]' : 'text-[#ef4444]' }}">{{ $isPaid ? 'Lunas' : 'Belum' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Payment History Table -->
<div class="mt-6 rounded bg-navy shadow-xl border border-white/10">
    <div class="border-b border-white/10 px-6 py-4">
        <h3 class="text-base font-bold text-white">Riwayat Pembayaran</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5 bg-black/20">
                    <th class="px-6 py-4 text-left text-[12px] font-bold text-slate-300 uppercase tracking-wider">Bulan</th>
                    <th class="px-6 py-4 text-left text-[12px] font-bold text-slate-300 uppercase tracking-wider">Tahun</th>
                    <th class="px-6 py-4 text-left text-[12px] font-bold text-slate-300 uppercase tracking-wider">Tanggal Bayar</th>
                    <th class="px-6 py-4 text-left text-[12px] font-bold text-slate-300 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-left text-[12px] font-bold text-slate-300 uppercase tracking-wider">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($siswa->pembayaran->sortByDesc('created_at') as $p)
                <tr class="transition hover:bg-white/5">
                    <td class="px-6 py-4"><span class="inline-flex rounded-full bg-[#0ea5e9]/20 px-3 py-1 text-xs font-bold text-[#0ea5e9]">{{ $p->bulan_bayar }}</span></td>
                    <td class="px-6 py-4 text-[13px] text-slate-300">{{ $p->tahun_bayar }}</td>
                    <td class="px-6 py-4 text-[13px] text-slate-300">{{ $p->tgl_bayar->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-[13px] font-bold text-[#10b981]">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-[13px] text-slate-300">{{ $p->petugas->name ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-[13px] text-slate-400">Belum ada riwayat pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
