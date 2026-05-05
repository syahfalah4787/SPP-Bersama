<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin/officer dashboard with key metrics.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Total students & classes
        $totalSiswa = Siswa::count();
        $totalKelas = \App\Models\Kelas::count();

        // Monthly revenue (current month)
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $currentBulanName = $bulanList[(int)$currentMonth - 1];

        $monthlyRevenue = Pembayaran::where('bulan_bayar', $currentBulanName)
            ->where('tahun_bayar', $currentYear)
            ->sum('jumlah_bayar');

        // Total revenue all time
        $totalRevenue = Pembayaran::sum('jumlah_bayar');

        // Total payments count
        $totalPembayaran = Pembayaran::count();

        // Students who paid this month
        $paidThisMonth = Pembayaran::where('bulan_bayar', $currentBulanName)
            ->where('tahun_bayar', $currentYear)
            ->count();

        // Recent transactions (last 10)
        $recentTransactions = Pembayaran::with(['siswa', 'petugas', 'spp'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Monthly revenue chart data (last 6 months)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $bulanList[(int)$date->format('m') - 1];
            $year = $date->format('Y');

            $revenue = Pembayaran::where('bulan_bayar', $monthName)
                ->where('tahun_bayar', $year)
                ->sum('jumlah_bayar');

            $chartData[] = [
                'month' => substr($monthName, 0, 3) . ' ' . $year,
                'revenue' => $revenue,
            ];
        }

        return view('dashboard', compact(
            'totalSiswa',
            'totalKelas',
            'monthlyRevenue',
            'totalRevenue',
            'totalPembayaran',
            'paidThisMonth',
            'recentTransactions',
            'chartData',
            'currentBulanName',
            'currentYear'
        ));
    }
}
