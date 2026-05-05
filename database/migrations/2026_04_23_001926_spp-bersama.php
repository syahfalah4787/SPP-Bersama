<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add role column to users table (admin, petugas)
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas'])->default('petugas')->after('name');
        });

        // Kelas (Class) table
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50);
            $table->string('kompetensi_keahlian', 100);
            $table->timestamps();
        });

        // SPP (Fee) table
        Schema::create('spp', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->integer('nominal');
            $table->timestamps();
        });

        // Siswa (Student) table
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 20)->unique();
            $table->string('nis', 20)->unique();
            $table->string('nama', 100);
            $table->string('alamat', 255);
            $table->string('no_telp', 20);
            $table->foreignId('id_kelas')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('id_spp')->constrained('spp')->onDelete('cascade');
            $table->string('password');
            $table->timestamps();
        });

        // Pembayaran (Payment) table
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_petugas')->constrained('users')->onDelete('cascade');
            $table->string('nisn', 20);
            $table->date('tgl_bayar');
            $table->string('bulan_bayar', 20);
            $table->string('tahun_bayar', 4);
            $table->foreignId('id_spp')->constrained('spp')->onDelete('cascade');
            $table->integer('jumlah_bayar');
            $table->timestamps();

            $table->foreign('nisn')->references('nisn')->on('siswa')->onDelete('cascade');
            // Prevent double payment for same student, same month, same year
            $table->unique(['nisn', 'bulan_bayar', 'tahun_bayar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('spp');
        Schema::dropIfExists('kelas');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
