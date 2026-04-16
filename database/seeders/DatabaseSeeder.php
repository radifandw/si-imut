<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Usulan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@siimut.id'],
            [
                'name'     => 'Administrator SI-IMUT',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'instansi' => 'BKD Kabupaten',
                'nip'      => '199001012020121001',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@siimut.id'],
            [
                'name'     => 'Dinas Pendidikan Kab. Situbondo',
                'password' => Hash::make('user123'),
                'role'     => 'user',
                'instansi' => 'Dinas Pendidikan dan Kebudayaan',
                'nip'      => '198505152010011002',
            ]
        );

        Usulan::updateOrCreate(
            ['nomor_surat' => 'P/4703/03/D/2026'],
            [
                'tanggal_surat' => '2026-03-26',
                'perihal'       => 'Mutasi ASN',
                'kewenangan'    => 'Admin Kabupaten',
                'tahapan'       => 'Input Berkas PERTEK/Rekomendasi',
                'jenis_usulan'  => 'Non Otomasi',
                'user_id'       => $user->id,
            ]
        );

        Usulan::updateOrCreate(
            ['nomor_surat' => 'P/3653/02/D/2026'],
            [
                'tanggal_surat' => '2026-02-17',
                'perihal'       => 'Permohonan Rekomendasi Pengangkatan Manajerial',
                'kewenangan'    => 'BKN Pusat',
                'tahapan'       => 'Input Berkas PERTEK/Rekomendasi',
                'jenis_usulan'  => 'Non Otomasi',
                'user_id'       => $user->id,
            ]
        );
    }
}
