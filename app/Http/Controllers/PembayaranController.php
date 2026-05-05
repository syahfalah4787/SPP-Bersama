<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pembayaran = Pembayaran::with(['siswa', 'petugas', 'spp'])
            ->when($search, function ($query, $search) {
                $query->where('nisn', 'like', "%{$search}%")
                    ->orWhere('bulan_bayar', 'like', "%{$search}%")
                    ->orWhereHas('siswa', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pembayaran.index', compact('pembayaran', 'search'));
    }

    public function create(Request $request)
    {
        $kelasList = Kelas::withCount('siswa')->orderBy('nama_kelas')->get();
        $sppList = Spp::orderBy('tahun', 'desc')->get();
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('admin.pembayaran.create', compact('kelasList', 'sppList', 'bulanList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|exists:siswa,nisn',
            'bulan_bayar' => 'required|string',
            'tahun_bayar' => 'required|string|size:4',
            'id_spp' => 'required|exists:spp,id',
            'jumlah_bayar' => 'required|integer|min:1',
        ]);

        $siswa = Siswa::with('spp')->where('nisn', $validated['nisn'])->first();

        if ($validated['id_spp'] != $siswa->id_spp) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tarif SPP tidak sesuai dengan data siswa!');
        }

        if ($validated['jumlah_bayar'] < $siswa->spp->nominal) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah bayar tidak boleh kurang dari tarif SPP (Rp ' . number_format($siswa->spp->nominal, 0, ',', '.') . ')!');
        }

        $exists = Pembayaran::where('nisn', $validated['nisn'])
            ->where('bulan_bayar', $validated['bulan_bayar'])
            ->where('tahun_bayar', $validated['tahun_bayar'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pembayaran untuk bulan dan tahun tersebut sudah ada!');
        }

        $validated['id_petugas'] = Auth::id();
        $validated['tgl_bayar'] = now()->toDateString();

        $pembayaran = Pembayaran::create($validated);

        return redirect()->route('pembayaran.show', $pembayaran)
            ->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['siswa.kelas', 'petugas', 'spp']);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function destroy(Pembayaran $pembayaran)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak! Hanya Admin yang dapat menghapus data pembayaran.');
        }

        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus!');
    }

    public function getSiswaByKelas(Request $request)
    {
        $siswaList = Siswa::with(['kelas', 'spp'])
            ->where('id_kelas', $request->id_kelas)
            ->orderBy('nama')
            ->get();

        return response()->json(['siswa' => $siswaList]);
    }

    public function getSiswaData(Request $request)
    {
        $siswa = Siswa::with(['kelas', 'spp'])
            ->where('nisn', $request->nisn)
            ->first();

        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $paidMonths = $siswa->getPaidMonths($request->tahun ?? now()->format('Y'));

        return response()->json([
            'siswa' => $siswa,
            'kelas' => $siswa->kelas,
            'spp' => $siswa->spp,
            'paid_months' => $paidMonths,
            'bulan_list' => $bulanList,
        ]);
    }
}
