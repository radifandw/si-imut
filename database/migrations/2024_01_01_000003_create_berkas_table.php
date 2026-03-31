<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulan_id')->constrained('usulan')->onDelete('cascade');
            $table->enum('kategori', ['Mutasi', 'Kenaikan Pangkat', 'Pensiun', 'Lainnya'])->default('Mutasi');
            $table->string('jenis_usulan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->timestamps();
        });

        Schema::create('asn_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berkas_id')->constrained('berkas')->onDelete('cascade');
            $table->string('nip');
            $table->string('nama');
            $table->string('pangkat_golongan')->nullable();
            $table->string('jabatan_saat_ini')->nullable();
            $table->string('unit_kerja_saat_ini')->nullable();
            $table->enum('status_pegawai', ['PNS', 'PPPK'])->default('PNS');
            $table->string('kedudukan_hukum')->nullable();
            $table->timestamps();
        });

        Schema::create('dokumen_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berkas_id')->constrained('berkas')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->string('jenis_dokumen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_berkas');
        Schema::dropIfExists('asn_berkas');
        Schema::dropIfExists('berkas');
    }
};
