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
        Schema::create('pns', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nik')->nullable();
            $table->string('nama');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('nama_lengkap')->nullable(); // NAMA + GELAR
            $table->string('golongan')->nullable();     // GOL AKHIR NAMA
            $table->string('pangkat')->nullable();      // PANGKAT AKHIR NAMA
            $table->date('tmt_golongan')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->string('unit_kerja')->nullable();   // UNOR NAMA
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pns');
    }
};
