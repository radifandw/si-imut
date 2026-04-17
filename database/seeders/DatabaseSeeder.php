<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Usulan;
use App\Models\Pns;
use App\Models\Berkas;
use App\Models\AsnBerkas;

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

        $usulan2 = Usulan::updateOrCreate(
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

        Pns::updateOrCreate(
            ['nip' => '198501012010011001'],
            [
                'nama'         => 'Budi Santoso',
                'nama_lengkap' => 'Budi Santoso, S.Pd.',
                'gelar_belakang' => 'S.Pd.',
                'golongan'     => 'III-b',
                'pangkat'      => 'Penata Muda Tingkat I',
                'jabatan'      => 'Guru Kelas',
                'unit_kerja'   => 'SDN 5 Paowan Kec. Panarukan - Dinas Pendidikan dan Kebudayaan',
                'tempat_lahir' => 'Situbondo',
                'tanggal_lahir' => '1985-01-01',
            ]
        );

        $berkas = Berkas::updateOrCreate(
            ['usulan_id' => $usulan2->id],
            [
                'kategori'     => 'Mutasi',
                'jenis_usulan' => 'Jabatan di Unit Kerjanya (Internalisasi)',
                'unit_kerja'   => 'SDN 5 Paowan Kec. Panarukan - Dinas Pendidikan dan Kebudayaan',
            ]
        );

        AsnBerkas::updateOrCreate(
            ['berkas_id' => $berkas->id, 'nip' => '198501012010011001'],
            [
                'nama'               => 'Budi Santoso, S.Pd.',
                'pangkat_golongan'   => 'Penata Muda Tingkat I / III-b',
                'jabatan_saat_ini'   => 'Guru Kelas',
                'jabatan_tujuan'     => 'Plh. Kepala Dinas',
                'unit_kerja_saat_ini' => 'SDN 5 Paowan Kec. Panarukan - Dinas Pendidikan dan Kebudayaan',
                'status_pegawai'     => 'PNS',
                'kedudukan_hukum'    => '-',
            ]
        );
    }
}
