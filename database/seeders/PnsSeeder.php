<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use App\Models\Pns;

class PnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spreadsheet = IOFactory::load(database_path('data/DB_PNS_01032026.xlsx'));
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
        array_shift($rows); // skip header

        $chunk = [];
        foreach ($rows as $row) {
            if (empty($row[0])) continue;
            $chunk[] = [
                'nip'           => (string) $row[0],
                'nik'           => $row[1] ?? null,
                'nama'          => $row[2] ?? null,
                'gelar_depan'   => $row[3] ?? null,
                'gelar_belakang'=> $row[4] ?? null,
                'nama_lengkap'  => trim(($row[3] ? $row[3].' ' : '').($row[2] ?? '') . ($row[4] ? ', '.$row[4] : '')),
                'golongan'      => $row[6] ?? null,
                'pangkat'       => trim($row[7] ?? ''),
                'tmt_golongan'  => !empty($row[8]) ? Carbon::parse($row[8])->toDateString() : null,
                'jabatan'       => $row[9] ?? null,
                'tmt_jabatan'   => !empty($row[10]) ? Carbon::parse($row[10])->toDateString() : null,
                'unit_kerja'    => $row[11] ?? null,
                'tempat_lahir'  => $row[12] ?? null,
                'tanggal_lahir' => !empty($row[13]) ? Carbon::parse($row[13])->toDateString() : null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            if (count($chunk) === 200) {
                Pns::insert($chunk);
                $chunk = [];
            }
        }

        if ($chunk) Pns::insert($chunk);
    }
}
