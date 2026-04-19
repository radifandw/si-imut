<?php

// namespace App\Console\Commands;

// use Illuminate\Console\Attributes\Description;
// use Illuminate\Console\Attributes\Signature;
// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;

// #[Signature('app:export-data')]
// #[Description('Export all data to JSON files for Supabase import')]
// class ExportData extends Command
// {
//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         $this->info('📤 Exporting data to JSON files...');

//         $this->exportTable('users');
//         $this->exportTable('usulan');
//         $this->exportTable('berkas');
//         $this->exportTable('asn_berkas');
//         $this->exportTable('dokumen_berkas');
//         $this->exportTable('pns');

//         $this->info('✅ All data exported to storage/app/exports/');
//         $this->info('📁 Files ready for Supabase import:');
//         $this->info('   - users.json');
//         $this->info('   - usulan.json');
//         $this->info('   - berkas.json');
//         $this->info('   - asn_berkas.json');
//         $this->info('   - dokumen_berkas.json');
//         $this->info('   - pns.json');
//     }

//     private function exportTable($tableName)
//     {
//         $this->info("📄 Exporting {$tableName}...");

//         $data = DB::table($tableName)->get();

//         // Convert to array
//         $dataArray = $data->map(function ($item) {
//             return (array) $item;
//         })->toArray();

//         // Save to JSON file in project root
//         $fileName = "database/exports/{$tableName}.json";
//         $filePath = base_path($fileName);

//         // Ensure directory exists
//         $directory = dirname($filePath);
//         if (!is_dir($directory)) {
//             mkdir($directory, 0755, true);
//         }

//         file_put_contents($filePath, json_encode($dataArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

//         $this->info("✅ Exported " . count($dataArray) . " records from {$tableName} to {$fileName}");
//     }
// }
