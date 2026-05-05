<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of officers with search and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $petugas = User::withCount('pembayaran')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.petugas.index', compact('petugas', 'search'));
    }

    /**
     * Store a newly created officer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan!');
    }

    /**
     * Update the specified officer.
     */
    public function update(Request $request, User $petuga)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $petuga->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $petuga->id,
            'role' => 'required|in:admin,petugas',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $validated['password'] = Hash::make($request->password);
        }

        $petuga->update($validated);

        return redirect()->route('petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui!');
    }

    /**
     * Remove the specified officer.
     */
    public function destroy(User $petuga)
    {
        if ($petuga->id === auth()->id()) {
            return redirect()->route('petugas.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        if ($petuga->pembayaran()->count() > 0) {
            return redirect()->route('petugas.index')
                ->with('error', 'Petugas tidak dapat dihapus karena memiliki riwayat transaksi!');
        }

        $petuga->delete();

        return redirect()->route('petugas.index')
            ->with('success', 'Data petugas berhasil dihapus!');
    }
}
