<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', now()->format('Y'));
        $nisn = $request->input('nisn');

        $query = Pembayaran::with(['siswa.kelas', 'petugas', 'spp']);
        if ($bulan) $query->where('bulan_bayar', $bulan);
        if ($tahun) $query->where('tahun_bayar', $tahun);
        if ($nisn) $query->where('nisn', $nisn);

        $pembayaran = $query->orderBy('tgl_bayar', 'desc')->get();
        $totalAmount = $pembayaran->sum('jumlah_bayar');
        $totalRecords = $pembayaran->count();
        $siswaList = Siswa::orderBy('nama')->get();
        $years = Pembayaran::selectRaw('DISTINCT tahun_bayar')->orderBy('tahun_bayar', 'desc')->pluck('tahun_bayar');

        return view('admin.laporan.index', compact('pembayaran','bulanList','bulan','tahun','nisn','totalAmount','totalRecords','siswaList','years'));
    }

    public function print(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', now()->format('Y'));
        $nisn = $request->input('nisn');

        $query = Pembayaran::with(['siswa.kelas', 'petugas', 'spp']);
        if ($bulan) $query->where('bulan_bayar', $bulan);
        if ($tahun) $query->where('tahun_bayar', $tahun);
        if ($nisn) $query->where('nisn', $nisn);

        $pembayaran = $query->orderBy('tgl_bayar', 'desc')->get();
        $totalAmount = $pembayaran->sum('jumlah_bayar');

        return view('admin.laporan.print', compact('pembayaran','totalAmount','bulan','tahun','nisn'));
    }
}
