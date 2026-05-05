<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
    /**
     * Display a listing of SPP rates with search and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $spp = Spp::withCount('siswa')
            ->when($search, function ($query, $search) {
                $query->where('tahun', 'like', "%{$search}%")
                    ->orWhere('nominal', 'like', "%{$search}%");
            })
            ->orderBy('tahun', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.spp.index', compact('spp', 'search'));
    }

    /**
     * Store a newly created SPP rate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2030',
            'nominal' => 'required|integer|min:0',
        ]);

        Spp::create($validated);

        return redirect()->route('spp.index')
            ->with('success', 'Data SPP berhasil ditambahkan!');
    }

    /**
     * Update the specified SPP rate.
     */
    public function update(Request $request, Spp $spp)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2030',
            'nominal' => 'required|integer|min:0',
        ]);

        $spp->update($validated);

        return redirect()->route('spp.index')
            ->with('success', 'Data SPP berhasil diperbarui!');
    }

    /**
     * Remove the specified SPP rate.
     */
    public function destroy(Spp $spp)
    {
        if ($spp->siswa()->count() > 0) {
            return redirect()->route('spp.index')
                ->with('error', 'Data SPP tidak dapat dihapus karena masih digunakan oleh siswa!');
        }

        $spp->delete();

        return redirect()->route('spp.index')
            ->with('success', 'Data SPP berhasil dihapus!');
    }
}
