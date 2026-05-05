<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Display a listing of students with search and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $siswa = Siswa::with(['kelas', 'spp'])
            ->when($search, function ($query, $search) {
                $query->where('nisn', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhereHas('kelas', function ($q) use ($search) {
                        $q->where('nama_kelas', 'like', "%{$search}%");
                    });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $sppList = Spp::orderBy('tahun', 'desc')->get();

        return view('admin.siswa.index', compact('siswa', 'search', 'kelasList', 'sppList'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'id_kelas' => 'required|exists:kelas,id',
            'id_spp' => 'required|exists:spp,id',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Siswa::create($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * Display the specified student with payment history.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'spp', 'pembayaran.petugas', 'pembayaran.spp']);

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $currentYear = now()->format('Y');
        $paidMonths = $siswa->getPaidMonths($currentYear);

        return view('admin.siswa.show', compact('siswa', 'bulanList', 'currentYear', 'paidMonths'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:20|unique:siswa,nisn,' . $siswa->id,
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'id_kelas' => 'required|exists:kelas,id',
            'id_spp' => 'required|exists:spp,id',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $validated['password'] = Hash::make($request->password);
        }

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
