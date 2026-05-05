@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    
    <!-- Total Siswa -->
    <div class="bg-navy rounded shadow-xl flex flex-col border border-white/10 overflow-hidden">
        <div class="p-4 flex justify-between items-start text-white">
            <div class="p-1">
                <!-- Person Icon -->
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <div class="text-right">
                <h3 x-data="{ count: 0, target: {{ $totalSiswa }} }" 
                    x-init="let step = Math.ceil(target / 50); let timer = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(timer); } }, 20);" 
                    x-text="count.toLocaleString('id-ID')" 
                    class="text-[32px] font-bold leading-none">0</h3>
                <p class="text-xs text-slate-300 font-semibold mt-1">Total Siswa</p>
            </div>
        </div>
        <a href="{{ route('siswa.index') }}" class="bg-white px-4 py-1.5 flex items-center justify-between group hover:bg-slate-50 transition">
            <span class="text-[11px] text-[#0ea5e9] font-bold tracking-wide">Lihat Detail</span>
            <svg class="w-4 h-4 text-navy group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
            </svg>
        </a>
    </div>

    <!-- Total Kelas -->
    <div class="bg-navy rounded shadow-xl flex flex-col border border-white/10 overflow-hidden">
        <div class="p-4 flex justify-between items-start text-white">
            <div class="p-1">
                <!-- Stack/Database Icon -->
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                </svg>
            </div>
            <div class="text-right">
                <h3 x-data="{ count: 0, target: {{ $totalKelas }} }" 
                    x-init="let step = Math.ceil(target / 50) || 1; let timer = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(timer); } }, 20);" 
                    x-text="count.toLocaleString('id-ID')" 
                    class="text-[32px] font-bold leading-none">0</h3>
                <p class="text-xs text-slate-300 font-semibold mt-1">Total Kelas</p>
            </div>
        </div>
        <a href="{{ route('kelas.index') }}" class="bg-white px-4 py-1.5 flex items-center justify-between group hover:bg-slate-50 transition">
            <span class="text-[11px] text-[#0ea5e9] font-bold tracking-wide">Lihat Detail</span>
            <svg class="w-4 h-4 text-navy group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
            </svg>
        </a>
    </div>

    <!-- Total Transaksi -->
    <div class="bg-navy rounded shadow-xl flex flex-col border border-white/10 overflow-hidden">
        <div class="p-4 flex justify-between items-start text-white">
            <div class="p-1">
                <!-- Transaction/Refresh Icon -->
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div class="text-right">
                <h3 x-data="{ count: 0, target: {{ $totalPembayaran }} }" 
                    x-init="let step = Math.ceil(target / 50) || 1; let timer = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(timer); } }, 20);" 
                    x-text="count.toLocaleString('id-ID')" 
                    class="text-[32px] font-bold leading-none">0</h3>
                <p class="text-xs text-slate-300 font-semibold mt-1">Total Transaksi</p>
            </div>
        </div>
        <a href="{{ route('pembayaran.index') }}" class="bg-white px-4 py-1.5 flex items-center justify-between group hover:bg-slate-50 transition">
            <span class="text-[11px] text-[#0ea5e9] font-bold tracking-wide">Lihat Detail</span>
            <svg class="w-4 h-4 text-navy group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
            </svg>
        </a>
    </div>

</div>

<!-- Chart Section -->
<div class="bg-navy rounded shadow-xl border border-white/10 p-4">
    <canvas id="revenueChart" height="100"></canvas>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Parse PHP data to JS
    const chartData = @json(array_reverse($chartData));
    const labels = chartData.map(item => item.month);
    const data = chartData.map(item => item.revenue);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan SPP',
                data: data,
                borderColor: '#10b981', // green
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#10b981',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        callback: function(value, index, values) {
                            if (value >= 1000000) {
                                return (value / 1000000) + 'M';
                            }
                            if (value >= 1000) {
                                return (value / 1000) + 'K';
                            }
                            return value;
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });
});
</script>
@endpush
