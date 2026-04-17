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
        Schema::table('asn_berkas', function (Blueprint $table) {
            $table->string('jabatan_tujuan')->nullable()->after('jabatan_saat_ini');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asn_berkas', function (Blueprint $table) {
            $table->dropColumn('jabatan_tujuan');
        });
    }
};
