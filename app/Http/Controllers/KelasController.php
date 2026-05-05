<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of classes with search and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kelas = Kelas::withCount('siswa')
            ->when($search, function ($query, $search) {
                $query->where('nama_kelas', 'like', "%{$search}%")
                    ->orWhere('kompetensi_keahlian', 'like', "%{$search}%");
            })
            ->orderBy('nama_kelas')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kelas.index', compact('kelas', 'search'));
    }

    /**
     * Store a newly created class.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'kompetensi_keahlian' => 'required|string|max:100',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Update the specified class.
     */
    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'kompetensi_keahlian' => 'required|string|max:100',
        ]);

        $kela->update($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified class.
     */
    public function destroy(Kelas $kela)
    {
        if ($kela->siswa()->count() > 0) {
            return redirect()->route('kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa!');
        }

        $kela->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
