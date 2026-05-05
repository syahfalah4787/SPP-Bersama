<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@spp.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Officers
        $petugas1 = User::create([
            'name' => 'Budi Santoso',
            'username' => 'petugas1',
            'email' => 'budi@spp.test',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'email_verified_at' => now(),
        ]);

        
        $petugas2 = User::create([
            'name' => 'Siti Aminah',
            'username' => 'petugas2',
            'email' => 'siti@spp.test',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'email_verified_at' => now(),
        ]);

        // Create Classes
        $kelas = [];
        $kelasData = [
            ['nama_kelas' => 'X RPL 1', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'X RPL 2', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'X TKJ 1', 'kompetensi_keahlian' => 'Teknik Komputer dan Jaringan'],
            ['nama_kelas' => 'XI RPL 1', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'XI RPL 2', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'XI TKJ 1', 'kompetensi_keahlian' => 'Teknik Komputer dan Jaringan'],
            ['nama_kelas' => 'XII RPL 1', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'XII RPL 2', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'XII TKJ 1', 'kompetensi_keahlian' => 'Teknik Komputer dan Jaringan'],
        ];

        foreach ($kelasData as $k) {
            $kelas[] = Kelas::create($k);
        }

        // Create SPP Rates
        $spp2025 = Spp::create(['tahun' => 2025, 'nominal' => 150000]);
        $spp2026 = Spp::create(['tahun' => 2026, 'nominal' => 175000]);

        // Create Students
        $siswaData = [
            ['nisn' => '0012345001', 'nis' => '10001', 'nama' => 'Ahmad Fauzi', 'alamat' => 'Jl. Merdeka No. 10, Jakarta', 'no_telp' => '081234567001', 'id_kelas' => $kelas[0]->id, 'id_spp' => $spp2026->id],
            ['nisn' => '0012345002', 'nis' => '10002', 'nama' => 'Dewi Lestari', 'alamat' => 'Jl. Sudirman No. 25, Bandung', 'no_telp' => '081234567002', 'id_kelas' => $kelas[0]->id, 'id_spp' => $spp2026->id],
            ['nisn' => '0012345003', 'nis' => '10003', 'nama' => 'Rizky Pratama', 'alamat' => 'Jl. Gatot Subroto No. 5, Surabaya', 'no_telp' => '081234567003', 'id_kelas' => $kelas[1]->id, 'id_spp' => $spp2026->id],
            ['nisn' => '0012345004', 'nis' => '10004', 'nama' => 'Putri Ayu', 'alamat' => 'Jl. Pemuda No. 8, Semarang', 'no_telp' => '081234567004', 'id_kelas' => $kelas[2]->id, 'id_spp' => $spp2026->id],
            ['nisn' => '0012345005', 'nis' => '10005', 'nama' => 'Andi Wijaya', 'alamat' => 'Jl. Asia Afrika No. 15, Bandung', 'no_telp' => '081234567005', 'id_kelas' => $kelas[3]->id, 'id_spp' => $spp2025->id],
            ['nisn' => '0012345006', 'nis' => '10006', 'nama' => 'Sari Indah', 'alamat' => 'Jl. Diponegoro No. 20, Yogyakarta', 'no_telp' => '081234567006', 'id_kelas' => $kelas[3]->id, 'id_spp' => $spp2025->id],
            ['nisn' => '0012345007', 'nis' => '10007', 'nama' => 'Bayu Nugroho', 'alamat' => 'Jl. Pahlawan No. 30, Malang', 'no_telp' => '081234567007', 'id_kelas' => $kelas[4]->id, 'id_spp' => $spp2025->id],
            ['nisn' => '0012345008', 'nis' => '10008', 'nama' => 'Fitri Handayani', 'alamat' => 'Jl. Imam Bonjol No. 12, Medan', 'no_telp' => '081234567008', 'id_kelas' => $kelas[5]->id, 'id_spp' => $spp2025->id],
            ['nisn' => '0012345009', 'nis' => '10009', 'nama' => 'Dimas Arya', 'alamat' => 'Jl. Veteran No. 7, Jakarta', 'no_telp' => '081234567009', 'id_kelas' => $kelas[6]->id, 'id_spp' => $spp2025->id],
            ['nisn' => '0012345010', 'nis' => '10010', 'nama' => 'Rina Melati', 'alamat' => 'Jl. Kartini No. 18, Surabaya', 'no_telp' => '081234567010', 'id_kelas' => $kelas[7]->id, 'id_spp' => $spp2025->id],
            ['nisn' => '0012345011', 'nis' => '10011', 'nama' => 'Hendra Saputra', 'alamat' => 'Jl. Ahmad Yani No. 22, Bekasi', 'no_telp' => '081234567011', 'id_kelas' => $kelas[8]->id, 'id_spp' => $spp2025->id],
            ['nisn' => '0012345012', 'nis' => '10012', 'nama' => 'Mega Puspita', 'alamat' => 'Jl. Thamrin No. 9, Jakarta', 'no_telp' => '081234567012', 'id_kelas' => $kelas[1]->id, 'id_spp' => $spp2026->id],
        ];

        $siswaModels = [];
        foreach ($siswaData as $s) {
            $s['password'] = Hash::make('password');
            $siswaModels[] = Siswa::create($s);
        }

        // Create some sample payments
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Payments for 2026 (first few months for some students)
        foreach (array_slice($siswaModels, 0, 6) as $index => $siswa) {
            $monthsToPay = min($index + 2, 4); // Pay 2-4 months
            for ($m = 0; $m < $monthsToPay; $m++) {
                Pembayaran::create([
                    'id_petugas' => $index % 2 === 0 ? $petugas1->id : $petugas2->id,
                    'nisn' => $siswa->nisn,
                    'tgl_bayar' => "2026-" . str_pad($m + 1, 2, '0', STR_PAD_LEFT) . "-" . rand(1, 28),
                    'bulan_bayar' => $bulanList[$m],
                    'tahun_bayar' => '2026',
                    'id_spp' => $siswa->id_spp,
                    'jumlah_bayar' => $siswa->spp->nominal,
                ]);
            }
        }

        // A few payments for 2025
        foreach (array_slice($siswaModels, 4, 4) as $index => $siswa) {
            for ($m = 6; $m < 12; $m++) {
                Pembayaran::create([
                    'id_petugas' => $petugas1->id,
                    'nisn' => $siswa->nisn,
                    'tgl_bayar' => "2025-" . str_pad($m + 1, 2, '0', STR_PAD_LEFT) . "-" . rand(1, 28),
                    'bulan_bayar' => $bulanList[$m],
                    'tahun_bayar' => '2025',
                    'id_spp' => $siswa->id_spp,
                    'jumlah_bayar' => $siswa->spp->nominal,
                ]);
            }
        }
    }
}
