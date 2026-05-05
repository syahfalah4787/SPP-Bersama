@extends('layouts.admin')
@section('title', 'Data Petugas')
@section('subtitle', 'Kelola data admin dan petugas')

@section('content')
<div x-data="{ showCreate: false, showEdit: false, editData: {} }">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="relative">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari petugas..." class="w-full rounded border border-white/20 bg-navy text-white placeholder-slate-400 py-2.5 pl-10 pr-4 text-sm shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9] sm:w-72">
        </form>
        <button @click="showCreate = true" class="inline-flex items-center gap-2 rounded bg-[#0ea5e9] px-4 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-sky-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Petugas
        </button>
    </div>

    <div class="mt-6 overflow-hidden rounded bg-navy shadow-xl border border-white/10">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-black/20 text-white">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300">Transaksi</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($petugas as $index => $p)
                    <tr class="transition hover:bg-white/5">
                        <td class="px-6 py-4 text-sm text-slate-300">{{ $petugas->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white">{{ strtoupper(substr($p->name, 0, 1)) }}</div>
                                <span class="text-sm font-bold text-white">{{ $p->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-300">{{ $p->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $p->isAdmin() ? 'bg-amber-500/20 text-amber-400' : 'bg-[#0ea5e9]/20 text-[#0ea5e9]' }}">
                                {{ ucfirst($p->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-300">{{ $p->pembayaran_count }} transaksi</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="editData = { id: {{ $p->id }}, name: '{{ addslashes($p->name) }}', username: '{{ $p->username }}', email: '{{ $p->email }}', role: '{{ $p->role }}' }; showEdit = true"
                                        class="rounded p-1.5 text-[#0ea5e9] transition hover:bg-[#0ea5e9]/10" title="Edit">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if($p->id !== auth()->id())
                                <form method="POST" action="{{ route('petugas.destroy', $p) }}" onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded p-1.5 text-[#ef4444] transition hover:bg-[#ef4444]/10" title="Hapus">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada data petugas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($petugas->hasPages())
        <div class="border-t border-white/10 px-6 py-4">{{ $petugas->links() }}</div>
        @endif
    </div>

    <!-- Create Modal -->
    <div x-show="showCreate" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showCreate = false"></div>
        <div class="relative w-full max-w-md rounded-3xl bg-navy p-8 shadow-2xl border border-white/10" @click.away="showCreate = false">
            <h3 class="text-xl font-bold text-white mb-6">Tambah Petugas</h3>
            <form method="POST" action="{{ route('petugas.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Nama</label>
                    <input type="text" name="name" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Username</label>
                    <input type="text" name="username" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Role</label>
                    <select name="role" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                        <option value="petugas" class="bg-navy">Petugas</option>
                        <option value="admin" class="bg-navy">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
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
            <h3 class="text-xl font-bold text-white mb-6">Edit Petugas</h3>
            <form :action="'/petugas/' + editData.id" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Nama</label>
                    <input type="text" name="name" x-model="editData.name" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Username</label>
                    <input type="text" name="username" x-model="editData.username" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Email</label>
                    <input type="email" name="email" x-model="editData.email" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Role</label>
                    <select name="role" x-model="editData.role" required class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                        <option value="petugas" class="bg-navy">Petugas</option>
                        <option value="admin" class="bg-navy">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[14px] font-semibold text-slate-300 mb-2">Password Baru (opsional)</label>
                    <input type="password" name="password" class="w-full rounded-xl border border-white/10 bg-black/20 py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
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
