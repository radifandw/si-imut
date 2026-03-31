# SI-IMUT — Sistem Informasi Mutasi ASN

Sistem manajemen usulan mutasi ASN berbasis web untuk Pemerintah Kabupaten.

---

## Fitur

**User (Instansi/OPD)**
- Login dengan akun instansi
- Buat usulan baru dengan nomor surat auto-generate
- Tambah berkas ASN (wizard 3 langkah: Data ASN > Riwayat > Dokumen)
- Kirim usulan ke admin untuk direview
- Monitor status usulan secara real-time

**Admin (BKD/Kabupaten)**
- Dashboard statistik seluruh usulan
- Review detail berkas dan data ASN
- Setujui atau tolak usulan dengan catatan
- Filter dan cari usulan

---

## Tech Stack

| Layer    | Teknologi                          |
|----------|------------------------------------|
| Backend  | Laravel 11 (PHP 8.3)               |
| Frontend | Blade + Tailwind CSS + Alpine.js   |
| Database | PostgreSQL                         |
| Storage  | Laravel Storage (public disk)      |

---

## Instalasi

### 1. Clone & Install

```bash
git clone https://github.com/radifandw/si-imut.git
cd si-imut
composer install
```

### 2. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit .env sesuaikan database:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=si_imut
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 3. Setup Database

```bash
php artisan migrate --seed
```

### 4. Setup Storage

```bash
php artisan storage:link
```

### 5. Jalankan

```bash
php artisan serve
```

Buka: http://localhost:8000

---

## Akun Demo

| Role  | Email             | Password |
|-------|-------------------|----------|
| Admin | admin@siimut.id   | admin123 |
| User  | user@siimut.id    | user123  |

---

## Skema Database

- users           : id, name, email, password, role, instansi, nip
- usulan          : id, nomor_surat, tanggal_surat, perihal, kewenangan, tahapan, jenis_usulan, user_id, catatan_admin
- berkas          : id, usulan_id, kategori, jenis_usulan, unit_kerja
- asn_berkas      : id, berkas_id, nip, nama, pangkat_golongan, jabatan_saat_ini, unit_kerja_saat_ini, status_pegawai, kedudukan_hukum
- dokumen_berkas  : id, berkas_id, nama_dokumen, file_path, jenis_dokumen

---

## Alur Sistem

User Login > Buat Usulan > Tambah Berkas ASN > Kirim ke Admin > Admin Review > Disetujui / Ditolak

---

Dikembangkan untuk Pemerintah Kabupaten — BKD/BKPSDM
