<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usulan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->text('perihal');
            $table->enum('kewenangan', ['Admin Kabupaten', 'BKN Pusat'])->default('Admin Kabupaten');
            $table->enum('tahapan', [
                'Draft',
                'Input Berkas PERTEK/Rekomendasi',
                'Menunggu Persetujuan Admin',
                'Disetujui',
                'Ditolak'
            ])->default('Draft');
            $table->enum('jenis_usulan', ['Otomasi', 'Non Otomasi'])->default('Non Otomasi');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usulan');
    }
};
