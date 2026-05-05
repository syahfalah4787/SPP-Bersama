@extends('layouts.admin')
@section('title', 'Entri Pembayaran')
@section('subtitle', 'Catat pembayaran SPP siswa')

@section('content')
<div class="mb-6">
    <a href="{{ route('pembayaran.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div x-data="paymentWizard()" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Left: Wizard Steps -->
    <div class="lg:col-span-2">
        <div class="rounded bg-navy p-6 shadow-xl border border-white/10">

            <!-- Step Indicators -->
            <div class="flex items-center gap-2 mb-8">
                <template x-for="(label, i) in ['Pilih Kelas', 'Pilih Siswa', 'Pembayaran']" :key="i">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2 cursor-pointer" @click="i < step && goToStep(i + 1)">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold transition-all duration-300"
                                 :class="step > i + 1 ? 'bg-[#10b981] text-white' : (step === i + 1 ? 'bg-[#0ea5e9] text-white ring-4 ring-[#0ea5e9]/30' : 'bg-white/10 text-slate-500')">
                                <span x-show="step <= i + 1" x-text="i + 1"></span>
                                <svg x-show="step > i + 1" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-xs font-bold" :class="step >= i + 1 ? 'text-white' : 'text-slate-500'" x-text="label"></span>
                        </div>
                        <div x-show="i < 2" class="w-8 h-px mx-1" :class="step > i + 1 ? 'bg-[#10b981]' : 'bg-white/10'"></div>
                    </div>
                </template>
            </div>

            <!-- STEP 1: Pilih Kelas -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <h3 class="text-lg font-bold text-white mb-1">Pilih Kelas</h3>
                <p class="text-sm text-slate-400 mb-5">Pilih kelas siswa yang akan melakukan pembayaran</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($kelasList as $k)
                    <button type="button"
                            @click="selectKelas({{ $k->id }}, '{{ addslashes($k->nama_kelas) }}', '{{ addslashes($k->kompetensi_keahlian) }}')"
                            :class="selectedKelasId === {{ $k->id }} ? 'border-[#0ea5e9] bg-[#0ea5e9]/10 ring-2 ring-[#0ea5e9]/30' : 'border-white/10 hover:border-white/30 hover:bg-white/5'"
                            class="flex items-center gap-4 rounded-xl border p-4 text-left transition-all duration-200">
                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-white/10 flex-shrink-0">
                            <svg class="h-5 w-5 text-[#0ea5e9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-white">{{ $k->nama_kelas }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $k->kompetensi_keahlian }} &bull; {{ $k->siswa_count }} siswa</p>
                        </div>
                    </button>
                    @endforeach
                </div>
                @if($kelasList->isEmpty())
                <div class="text-center py-12 text-slate-400 text-sm">Belum ada data kelas</div>
                @endif
            </div>

            <!-- STEP 2: Pilih Siswa -->
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Pilih Siswa</h3>
                        <p class="text-sm text-slate-400">Kelas: <span class="text-[#0ea5e9] font-bold" x-text="selectedKelasName"></span></p>
                    </div>
                    <button type="button" @click="goToStep(1)" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Ganti Kelas
                    </button>
                </div>

                <!-- Search within students -->
                <div class="relative mb-4">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="siswaSearch" placeholder="Cari nama atau NISN..." class="w-full rounded-lg border border-white/10 bg-black/20 py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                </div>

                <div x-show="loadingSiswa" class="text-center py-8">
                    <svg class="animate-spin h-6 w-6 text-[#0ea5e9] mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <p class="mt-2 text-xs text-slate-400">Memuat data siswa...</p>
                </div>

                <div x-show="!loadingSiswa" class="space-y-2 max-h-[400px] overflow-y-auto pr-1 custom-scrollbar">
                    <template x-for="s in filteredSiswa" :key="s.nisn">
                        <button type="button" @click="selectSiswa(s)"
                                :class="selectedNisn === s.nisn ? 'border-[#0ea5e9] bg-[#0ea5e9]/10 ring-2 ring-[#0ea5e9]/30' : 'border-white/10 hover:border-white/30 hover:bg-white/5'"
                                class="flex w-full items-center gap-4 rounded-xl border p-4 text-left transition-all duration-200">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white flex-shrink-0" x-text="s.nama.substring(0,2).toUpperCase()"></div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-white" x-text="s.nama"></p>
                                <p class="text-xs text-slate-400"><span x-text="'NISN: ' + s.nisn"></span> &bull; <span x-text="'NIS: ' + s.nis"></span></p>
                            </div>
                            <div x-show="s.spp" class="text-right flex-shrink-0">
                                <p class="text-xs text-slate-400">SPP/Bulan</p>
                                <p class="text-sm font-bold text-[#10b981]" x-text="'Rp ' + Number(s.spp?.nominal || 0).toLocaleString('id-ID')"></p>
                            </div>
                        </button>
                    </template>
                    <div x-show="!loadingSiswa && filteredSiswa.length === 0" class="text-center py-8 text-slate-400 text-sm">
                        <span x-show="siswaList.length === 0">Belum ada siswa di kelas ini</span>
                        <span x-show="siswaList.length > 0 && filteredSiswa.length === 0">Siswa tidak ditemukan</span>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Form Pembayaran -->
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Form Pembayaran</h3>
                        <p class="text-sm text-slate-400">Lengkapi data pembayaran untuk <span class="text-[#0ea5e9] font-bold" x-text="siswaData?.nama"></span></p>
                    </div>
                    <button type="button" @click="goToStep(2)" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Ganti Siswa
                    </button>
                </div>

                <form method="POST" action="{{ route('pembayaran.store') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="nisn" :value="selectedNisn">

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label class="block text-[14px] font-bold text-slate-300 mb-2">Bulan Bayar</label>
                            <select name="bulan_bayar" x-model="selectedBulan" required
                                    class="w-full rounded border border-white/20 bg-navy py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                                <option value="">-- Pilih Bulan --</option>
                                @foreach($bulanList as $b)
                                <option value="{{ $b }}" :disabled="paidMonths.includes('{{ $b }}')" :class="paidMonths.includes('{{ $b }}') ? 'text-slate-600' : ''">
                                    {{ $b }} <span x-show="paidMonths.includes('{{ $b }}')">(Sudah Lunas)</span>
                                </option>
                                @endforeach
                            </select>
                            @error('bulan_bayar') <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[14px] font-bold text-slate-300 mb-2">Tahun Bayar</label>
                            <input type="text" name="tahun_bayar" x-model="selectedTahun" required
                                   class="w-full rounded border border-white/20 bg-navy py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]"
                                   @change="refreshPaidMonths()">
                            @error('tahun_bayar') <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[14px] font-bold text-slate-300 mb-2">SPP</label>
                        <select name="id_spp" x-model="selectedSpp" required
                                class="w-full rounded border border-white/20 bg-navy py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                            <option value="">-- Pilih SPP --</option>
                            @foreach($sppList as $sp)
                            <option value="{{ $sp->id }}" data-nominal="{{ $sp->nominal }}">
                                {{ $sp->tahun }} - Rp {{ number_format($sp->nominal, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_spp') <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[14px] font-bold text-slate-300 mb-2">Jumlah Bayar (Rp)</label>
                        <input type="number" name="jumlah_bayar" x-model="jumlahBayar" min="1" required
                               class="w-full rounded border border-white/20 bg-navy py-2.5 px-4 text-[14px] text-white shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                        @error('jumlah_bayar') <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full rounded bg-[#10b981] px-6 py-3 text-sm font-bold text-white shadow-lg transition hover:bg-emerald-600">
                        <svg class="mr-2 inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Simpan Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Student Info Panel -->
    <div>
        <div class="rounded bg-navy p-6 shadow-xl border border-white/10">
            <h3 class="text-base font-bold text-white">Info Siswa</h3>
            <template x-if="siswaData">
                <div class="mt-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-xl font-bold text-white" x-text="siswaData.nama.substring(0,2).toUpperCase()"></div>
                        <div>
                            <p class="font-bold text-white" x-text="siswaData.nama"></p>
                            <p class="text-xs text-slate-400" x-text="'NISN: ' + siswaData.nisn"></p>
                        </div>
                    </div>
                    <div class="rounded bg-black/20 border border-white/5 p-3 space-y-2">
                        <div class="flex justify-between text-sm"><span class="text-slate-400">Kelas</span><span class="font-bold text-white" x-text="kelasData?.nama_kelas || '-'"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-slate-400">Kompetensi</span><span class="font-bold text-white text-right text-xs" x-text="kelasData?.kompetensi_keahlian || '-'"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-slate-400">SPP/Bulan</span><span class="font-bold text-[#10b981]" x-text="sppData?.nominal ? 'Rp ' + Number(sppData.nominal).toLocaleString('id-ID') : '-'"></span></div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 mb-2">Status Pembayaran (<span x-text="selectedTahun"></span>):</p>
                        <div class="flex flex-wrap gap-1">
                            <template x-for="m in allMonths" :key="m">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-bold"
                                      :class="paidMonths.includes(m) ? 'bg-[#10b981]/20 text-[#10b981]' : 'bg-white/5 text-slate-500'"
                                      x-text="m.substring(0,3)"></span>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="!siswaData">
                <div class="mt-4 text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <p class="mt-2 text-sm text-slate-400 font-semibold">Pilih kelas & siswa terlebih dahulu</p>
                </div>
            </template>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>

@push('scripts')
<script>
function paymentWizard() {
    return {
        step: 1,
        selectedKelasId: null,
        selectedKelasName: '',
        siswaList: [],
        siswaSearch: '',
        loadingSiswa: false,
        selectedNisn: '',
        siswaData: null,
        kelasData: null,
        sppData: null,
        paidMonths: [],
        selectedBulan: '',
        selectedTahun: '{{ now()->format("Y") }}',
        selectedSpp: '',
        jumlahBayar: 0,
        errorMessage: '',
        allMonths: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],

        get filteredSiswa() {
            if (!this.siswaSearch) return this.siswaList;
            const q = this.siswaSearch.toLowerCase();
            return this.siswaList.filter(s => s.nama.toLowerCase().includes(q) || s.nisn.includes(q));
        },

        goToStep(s) { this.step = s; },

        async selectKelas(id, name, kompetensi) {
            this.selectedKelasId = id;
            this.selectedKelasName = name;
            this.siswaSearch = '';
            this.step = 2;
            this.loadingSiswa = true;
            try {
                const res = await fetch(`/api/siswa-by-kelas?id_kelas=${id}`);
                const data = await res.json();
                this.siswaList = data.siswa;
            } catch (e) { console.error(e); this.siswaList = []; }
            this.loadingSiswa = false;
        },

        async selectSiswa(s) {
            this.selectedNisn = s.nisn;
            this.siswaData = s;
            this.kelasData = s.kelas;
            this.sppData = s.spp;
            if (s.spp) {
                this.selectedSpp = s.spp.id;
                this.jumlahBayar = s.spp.nominal;
            }
            await this.refreshPaidMonths();
            this.step = 3;
        },

        async refreshPaidMonths() {
            if (!this.selectedNisn) return;
            try {
                const res = await fetch(`/api/siswa-data?nisn=${this.selectedNisn}&tahun=${this.selectedTahun}`);
                if (res.ok) {
                    const data = await res.json();
                    this.paidMonths = data.paid_months;
                }
            } catch (e) { console.error(e); }
        }
    };
}
</script>
@endpush
@endsection
