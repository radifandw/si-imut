<?php

// namespace App\Console\Commands;

// use Illuminate\Console\Attributes\Description;
// use Illuminate\Console\Attributes\Signature;
// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Config;

// #[Signature('app:migrate-to-supabase')]
// #[Description('Migrate data from local PostgreSQL to Supabase')]
// class MigrateToSupabase extends Command
// {
//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         $this->info('🚀 Starting migration to Supabase...');

//         // Setup Supabase connection
//         Config::set('database.connections.supabase', [
//             'driver' => 'pgsql',
//             'host' => 'db.uhsccjgkhveapbgfkpdd.supabase.co',
//             'port' => '5432',
//             'database' => 'postgres',
//             'username' => 'postgres',
//             'password' => '0iQHLdjJbG2zsOQf',
//             'charset' => 'utf8',
//             'prefix' => '',
//             'schema' => 'public',
//             'sslmode' => 'require',
//         ]);

//         try {
//             // Test Supabase connection
//             $this->info('🔍 Testing Supabase connection...');
//             DB::connection('supabase')->getPdo();
//             $this->info('✅ Supabase connection successful!');
//         } catch (\Exception $e) {
//             $this->error('❌ Cannot connect to Supabase: ' . $e->getMessage());
//             return 1;
//         }

//         // Run migrations on Supabase
//         $this->info('📦 Running migrations on Supabase...');
//         try {
//             $this->call('migrate', [
//                 '--database' => 'supabase',
//                 '--force' => true
//             ]);
//             $this->info('✅ Migrations completed!');
//         } catch (\Exception $e) {
//             $this->error('❌ Migration failed: ' . $e->getMessage());
//             return 1;
//         }

//         // Migrate data
//         $this->migrateUsers();
//         $this->migrateUsulans();
//         $this->migrateBerkas();
//         $this->migrateAsnBerkas();
//         $this->migrateDokumenBerkas();
//         $this->migratePns();

//         $this->info('🎉 Migration to Supabase completed successfully!');
//         return 0;
//     }

//     private function migrateUsers()
//     {
//         $this->info('👥 Migrating users...');
//         $users = DB::table('users')->get();
//         $count = 0;

//         foreach ($users as $user) {
//             DB::connection('supabase')->table('users')->insert([
//                 'id' => $user->id,
//                 'name' => $user->name,
//                 'email' => $user->email,
//                 'email_verified_at' => $user->email_verified_at,
//                 'password' => $user->password,
//                 'role' => $user->role,
//                 'instansi' => $user->instansi,
//                 'remember_token' => $user->remember_token,
//                 'created_at' => $user->created_at,
//                 'updated_at' => $user->updated_at,
//             ]);
//             $count++;
//         }
//         $this->info("✅ Migrated {$count} users");
//     }

//     private function migrateUsulans()
//     {
//         $this->info('📋 Migrating usulans...');
//         $usulans = DB::table('usulan')->get();
//         $count = 0;

//         foreach ($usulans as $usulan) {
//             DB::connection('supabase')->table('usulan')->insert([
//                 'id' => $usulan->id,
//                 'user_id' => $usulan->user_id,
//                 'judul' => $usulan->judul,
//                 'deskripsi' => $usulan->deskripsi,
//                 'status' => $usulan->status,
//                 'created_at' => $usulan->created_at,
//                 'updated_at' => $usulan->updated_at,
//             ]);
//             $count++;
//         }
//         $this->info("✅ Migrated {$count} usulans");
//     }

//     private function migrateBerkas()
//     {
//         $this->info('📄 Migrating berkas...');
//         $berkas = DB::table('berkas')->get();
//         $count = 0;

//         foreach ($berkas as $b) {
//             DB::connection('supabase')->table('berkas')->insert([
//                 'id' => $b->id,
//                 'usulan_id' => $b->usulan_id,
//                 'kategori' => $b->kategori,
//                 'jenis_usulan' => $b->jenis_usulan,
//                 'unit_kerja' => $b->unit_kerja,
//                 'created_at' => $b->created_at,
//                 'updated_at' => $b->updated_at,
//             ]);
//             $count++;
//         }
//         $this->info("✅ Migrated {$count} berkas");
//     }

//     private function migrateAsnBerkas()
//     {
//         $this->info('👤 Migrating asn_berkas...');
//         $asnBerkas = DB::table('asn_berkas')->get();
//         $count = 0;

//         foreach ($asnBerkas as $asn) {
//             DB::connection('supabase')->table('asn_berkas')->insert([
//                 'id' => $asn->id,
//                 'berkas_id' => $asn->berkas_id,
//                 'nip' => $asn->nip,
//                 'nama' => $asn->nama,
//                 'pangkat_golongan' => $asn->pangkat_golongan,
//                 'jabatan_saat_ini' => $asn->jabatan_saat_ini,
//                 'jabatan_tujuan' => $asn->jabatan_tujuan,
//                 'unit_kerja_saat_ini' => $asn->unit_kerja_saat_ini,
//                 'status_pegawai' => $asn->status_pegawai,
//                 'kedudukan_hukum' => $asn->kedudukan_hukum,
//                 'created_at' => $asn->created_at,
//                 'updated_at' => $asn->updated_at,
//             ]);
//             $count++;
//         }
//         $this->info("✅ Migrated {$count} asn_berkas");
//     }

//     private function migrateDokumenBerkas()
//     {
//         $this->info('📎 Migrating dokumen_berkas...');
//         $dokumens = DB::table('dokumen_berkas')->get();
//         $count = 0;

//         foreach ($dokumens as $doc) {
//             DB::connection('supabase')->table('dokumen_berkas')->insert([
//                 'id' => $doc->id,
//                 'berkas_id' => $doc->berkas_id,
//                 'nama_dokumen' => $doc->nama_dokumen,
//                 'file_path' => $doc->file_path,
//                 'jenis_dokumen' => $doc->jenis_dokumen,
//                 'created_at' => $doc->created_at,
//                 'updated_at' => $doc->updated_at,
//             ]);
//             $count++;
//         }
//         $this->info("✅ Migrated {$count} dokumen_berkas");
//     }

//     private function migratePns()
//     {
//         $this->info('🏛️ Migrating pns...');
//         $pns = DB::table('pns')->get();
//         $count = 0;

//         foreach ($pns as $p) {
//             DB::connection('supabase')->table('pns')->insert([
//                 'id' => $p->id,
//                 'nip' => $p->nip,
//                 'nik' => $p->nik,
//                 'nama' => $p->nama,
//                 'gelar_depan' => $p->gelar_depan,
//                 'gelar_belakang' => $p->gelar_belakang,
//                 'nama_lengkap' => $p->nama_lengkap,
//                 'golongan' => $p->golongan,
//                 'pangkat' => $p->pangkat,
//                 'tmt_golongan' => $p->tmt_golongan,
//                 'jabatan' => $p->jabatan,
//                 'tmt_jabatan' => $p->tmt_jabatan,
//                 'unit_kerja' => $p->unit_kerja,
//                 'tempat_lahir' => $p->tempat_lahir,
//                 'tanggal_lahir' => $p->tanggal_lahir,
//                 'created_at' => $p->created_at,
//                 'updated_at' => $p->updated_at,
//             ]);
//             $count++;
//         }
//         $this->info("✅ Migrated {$count} pns records");
//     }
// }
