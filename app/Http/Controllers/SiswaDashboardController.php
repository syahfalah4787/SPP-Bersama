<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();
        $siswa->load(['kelas', 'spp', 'pembayaran.spp']);

        $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $currentYear = now()->format('Y');
        $paidMonths = $siswa->getPaidMonths($currentYear);
        $totalPaid = $siswa->pembayaran->where('tahun_bayar', $currentYear)->sum('jumlah_bayar');
        $totalExpected = $siswa->spp->nominal * 12;
        $remaining = $totalExpected - $totalPaid;

        return view('siswa.dashboard', compact('siswa','bulanList','currentYear','paidMonths','totalPaid','totalExpected','remaining'));
    }

    public function history(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();
        $tahun = $request->input('tahun', now()->format('Y'));

        $pembayaran = $siswa->pembayaran()
            ->with('spp', 'petugas')
            ->where('tahun_bayar', $tahun)
            ->orderByRaw("FIELD(bulan_bayar,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $paidMonths = $pembayaran->pluck('bulan_bayar')->toArray();

        $years = $siswa->pembayaran()->selectRaw('DISTINCT tahun_bayar')->orderBy('tahun_bayar','desc')->pluck('tahun_bayar');
        if ($years->isEmpty()) $years = collect([now()->format('Y')]);

        return view('siswa.history', compact('siswa','pembayaran','bulanList','paidMonths','tahun','years'));
    }
}
