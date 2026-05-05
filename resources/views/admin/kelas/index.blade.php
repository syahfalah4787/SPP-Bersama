@extends('layouts.admin')
@section('title', 'Data Kelas')
@section('subtitle', 'Kelola data kelas dan kompetensi keahlian')

@section('content')
<div x-data="{ showCreate: false, showEdit: false, editData: {} }">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="relative">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari kelas..." class="w-full rounded border border-white/20 bg-navy text-white placeholder-slate-400 py-2.5 pl-10 pr-4 text-sm shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9] sm:w-72">
        </form>
        <button @click="showCreate = true" class="inline-flex items-center gap-2 rounded bg-[#0ea5e9] px-4 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-sky-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kelas
        </button>
    </div>

    <!-- Table -->
    <div class="mt-6 overflow-hidden rounded bg-navy shadow-xl border border-white/10">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-black/20 text-white">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Nama Kelas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Kompetensi Keahlian</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Jumlah Siswa</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($kelas as $index => $k)
                    <tr class="transition hover:bg-white/5">
                        <td class="px-6 py-4 text-sm text-slate-300">{{ $kelas->firstItem() + $index }}</td>
                        <td class="px-6 py-4"><span class="text-sm font-bold text-white">{{ $k->nama_kelas }}</span></td>
                        <td class="px-6 py-4 text-sm text-slate-300">{{ $k->kompetensi_keahlian }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-0.5 text-xs font-medium text-white">{{ $k->siswa_count }} siswa</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="editData = { id: {{ $k->id }}, nama_kelas: '{{ $k->nama_kelas }}', kompetensi_keahlian: '{{ $k->kompetensi_keahlian }}' }; showEdit = true"
                                        class="rounded p-1.5 text-[#0ea5e9] transition hover:bg-[#0ea5e9]/10" title="Edit">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form method="POST" action="{{ route('kelas.destroy', $k) }}" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded p-1.5 text-[#ef4444] transition hover:bg-[#ef4444]/10" title="Hapus">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada data kelas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kelas->hasPages())
        <div class="border-t border-white/10 px-6 py-4">{{ $kelas->links() }}</div>
        @endif
    </div>

    <!-- Create Modal -->
    <div x-show="showCreate" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showCreate = false"></div>
        <div class="relative w-full max-w-md rounded-3xl bg-navy p-8 shadow-2xl border border-white/10" @click.away="showCreate = false">
            <h3 class="text-xl font-bold text-white mb-6">Tambah Kelas Baru</h3>
            <form method="POST" action="{{ route('kelas.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Nama Kelas</label>
                    <input type="text" name="nama_kelas" required class="w-full rounded-xl border border-white/10 bg-black/20 py-3 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Kompetensi Keahlian</label>
                    <input type="text" name="kompetensi_keahlian" required class="w-full rounded-xl border border-white/10 bg-black/20 py-3 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showCreate = false" class="rounded-xl border border-white/10 bg-white/5 px-6 py-2.5 text-[14px] font-semibold text-slate-300 transition hover:bg-white/10">Batal</button>
                    <button type="submit" class="rounded-xl bg-[#0ea5e9] px-6 py-2.5 text-[14px] font-bold text-white shadow-lg shadow-sky-500/30 transition hover:bg-sky-500">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEdit" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showEdit = false"></div>
        <div class="relative w-full max-w-md rounded-3xl bg-navy p-8 shadow-2xl border border-white/10" @click.away="showEdit = false">
            <h3 class="text-xl font-bold text-white mb-6">Edit Kelas</h3>
            <form :action="'/kelas/' + editData.id" method="POST" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Nama Kelas</label>
                    <input type="text" name="nama_kelas" x-model="editData.nama_kelas" required class="w-full rounded-xl border border-white/10 bg-black/20 py-3 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Kompetensi Keahlian</label>
                    <input type="text" name="kompetensi_keahlian" x-model="editData.kompetensi_keahlian" required class="w-full rounded-xl border border-white/10 bg-black/20 py-3 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showEdit = false" class="rounded-xl border border-white/10 bg-white/5 px-6 py-2.5 text-[14px] font-semibold text-slate-300 transition hover:bg-white/10">Batal</button>
                    <button type="submit" class="rounded-xl bg-[#0ea5e9] px-6 py-2.5 text-[14px] font-bold text-white shadow-lg shadow-sky-500/30 transition hover:bg-sky-500">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
