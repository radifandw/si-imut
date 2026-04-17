@extends('layouts.app')

@section('title', 'Tambah Berkas')
@section('page-title', 'Tambah Berkas ASN')
@section('breadcrumb', 'Usulan / Berkas / Tambah')

@section('sidebar-menu')
    <a href="{{ route('user.dashboard') }}" class="sidebar-link text-white">
        <i class="fas fa-home w-5"></i> Dashboard
    </a>
    <div class="mt-4 mb-2 px-4 text-xs font-semibold text-orange-300 uppercase tracking-wider">Usulan</div>
    <a href="{{ route('user.usulan.index') }}" class="sidebar-link active">
        <i class="fas fa-file-alt w-5"></i> Daftar Usulan
    </a>
@endsection

@section('content')
<div class="mt-4" x-data="berkasWizard()">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">
        <a href="{{ route('user.usulan.index') }}" class="hover:text-orange-600">Daftar Usulan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('user.berkas.index', $usulan) }}" class="hover:text-orange-600">Pertek/Rekomendasi</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Tambah Berkas</span>
    </div>

    {{-- Wizard Tabs --}}
    <div class="bg-white rounded-xl shadow-sm mb-5">
        <div class="flex border-b">
            @foreach(['Data ASN', 'Riwayat', 'Dokumen'] as $i => $tab)
            <button type="button"
                    @click="currentStep = {{ $i + 1 }}"
                    :class="currentStep === {{ $i + 1 }}
                        ? 'border-b-2 border-orange-500 text-orange-600 bg-orange-50'
                        : (currentStep > {{ $i + 1 }} ? 'text-green-600' : 'text-gray-400')"
                    class="flex-1 flex items-center justify-center gap-2 py-4 text-sm font-medium transition">
                <span :class="currentStep > {{ $i + 1 }} ? 'bg-green-500' : (currentStep === {{ $i + 1 }} ? 'bg-orange-500' : 'bg-gray-300')"
                      class="w-6 h-6 rounded-full text-white text-xs flex items-center justify-center font-bold">
                    <template x-if="currentStep > {{ $i + 1 }}"><i class="fas fa-check text-xs"></i></template>
                    <template x-if="currentStep <= {{ $i + 1 }}"><span>{{ $i + 1 }}</span></template>
                </span>
                <span class="hidden sm:inline">{{ $tab }}</span>
            </button>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('user.berkas.store', $usulan) }}" enctype="multipart/form-data">
        @csrf

        {{-- STEP 1: Data ASN --}}
        <div x-show="currentStep === 1" class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-5 text-lg flex items-center gap-2">
                <i class="fas fa-user-circle text-orange-500"></i> Langkah 1 — Pilih Prosedur & Data ASN
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" x-model="kategori" @change="jenisUsulan=''; updateDokumen()" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">— Pilih Kategori —</option>
                        <option value="Pengangkatan">Pengangkatan</option>
                        <option value="Promosi">Promosi</option>
                        <option value="Mutasi">Mutasi</option>
                        <option value="Pengukuhan">Pengukuhan</option>
                        <option value="Pemberhentian">Pemberhentian</option>
                    </select>
                </div>

                {{-- Jenis Usulan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Usulan <span class="text-red-500">*</span></label>
                    <select name="jenis_usulan" x-model="jenisUsulan" @change="updateDokumen()" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                            :disabled="!kategori">
                        <option value="">— Pilih Jenis —</option>
                        <template x-if="kategori === 'Pengangkatan'">
                            <template x-for="j in ['PLT/PLH','ke Jabatan Fungsional','Pengangkatan Kembali Jabatan Fungsional (Khusus Tugas Belajar)']">
                                <option :value="j" x-text="j"></option>
                            </template>
                        </template>
                        <template x-if="kategori === 'Promosi'">
                            <option value="Kenaikan Jenjang Jabatan Fungsional">Kenaikan Jenjang Jabatan Fungsional</option>
                        </template>
                        <template x-if="kategori === 'Mutasi'">
                            <template x-for="j in ['antar Perangkat Daerah','Jabatan di Unit Kerjanya (Internalisasi)']">
                                <option :value="j" x-text="j"></option>
                            </template>
                        </template>
                        <template x-if="kategori === 'Pengukuhan'">
                            <template x-for="j in ['Manajerial','Non Manajerial']">
                                <option :value="j" x-text="j"></option>
                            </template>
                        </template>
                        <template x-if="kategori === 'Pemberhentian'">
                            <option value="Jabatan Fungsional (Khusus Tugas Belajar)">Jabatan Fungsional (Khusus Tugas Belajar)</option>
                        </template>
                    </select>
                </div>

                {{-- Jabatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                    <select name="jabatan_tujuan" x-model="jabatanTujuan" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">— Pilih Jabatan —</option>
                        <optgroup label="Jabatan Fungsional">
                            <option>Guru Ahli Pertama</option>
                            <option>Guru Ahli Muda</option>
                            <option>Guru Ahli Madya</option>
                            <option>Analis Kebijakan Ahli Pertama</option>
                            <option>Analis Kebijakan Ahli Muda</option>
                            <option>Pranata Komputer Ahli Pertama</option>
                            <option>Perencana Ahli Pertama</option>
                            <option>Auditor Ahli Pertama</option>
                            <option>Penyuluh Pertanian Ahli Pertama</option>
                            <option>Dokter Ahli Pertama</option>
                            <option>Perawat Ahli Pertama</option>
                            <option>Bidan Ahli Pertama</option>
                        </optgroup>
                        <optgroup label="Jabatan Struktural / PLT">
                            <option>Plt. Kepala Dinas</option>
                            <option>Plt. Kepala Bidang</option>
                            <option>Plt. Kepala Seksi</option>
                            <option>Plt. Sekretaris</option>
                            <option>Plh. Kepala Dinas</option>
                            <option>Plh. Kepala Bidang</option>
                        </optgroup>
                        <optgroup label="Jabatan Pelaksana">
                            <option>Pengadministrasi Umum</option>
                            <option>Pengelola Data</option>
                            <option>Analis Data</option>
                        </optgroup>
                    </select>
                </div>

                {{-- Unit Kerja --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Kerja <span class="text-red-500">*</span></label>
                    <select name="unit_kerja" x-model="unitKerja" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">— Pilih Unit Kerja —</option>
                        @foreach($unitKerjaList as $dinas => $units)
                            <optgroup label="{{ $dinas }}">
                                @foreach($units as $unit)
                                    <option value="{{ $unit }}">{{ $unit }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIP / NIPPPK <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <input type="text" name="nip" x-model="nip" required
                               class="flex-1 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 font-mono"
                               placeholder="19850101 201001 1 001">
                        <button type="button" @click="cariASN()"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-search mr-1"></i> Cari
                        </button>
                    </div>
                </div>

                {{-- Status Pegawai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Pegawai <span class="text-red-500">*</span></label>
                    <select name="status_pegawai" x-model="statusPegawai" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="PNS">PNS</option>
                        <option value="PPPK">PPPK</option>
                    </select>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" x-model="nama" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="Nama lengkap ASN">
                </div>

                {{-- Pangkat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pangkat / Gol. Ruang</label>
                    <input type="text" name="pangkat_golongan" x-model="pangkat"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="contoh: Penata Muda / III-a">
                </div>

                {{-- Jabatan saat ini --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan Saat Ini</label>
                    <input type="text" name="jabatan_saat_ini" x-model="jabatan"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="contoh: Guru Kelas">
                </div>

                {{-- Unit Kerja Saat Ini --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Kerja Saat Ini</label>
                    <input type="text" name="unit_kerja_saat_ini" x-model="unitKerjaSaatIni"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="Nama unit kerja saat ini">
                </div>

                {{-- Kedudukan Hukum --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kedudukan Hukum</label>
                    <input type="text" name="kedudukan_hukum"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="contoh: Aktif">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" @click="nextStep()"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow">
                    Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>

        {{-- STEP 2: Riwayat --}}
        <div x-show="currentStep === 2" class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-5 text-lg flex items-center gap-2">
                <i class="fas fa-history text-orange-500"></i> Langkah 2 — Riwayat ASN
            </h3>
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-5">
                <p class="text-sm text-orange-700"><i class="fas fa-info-circle mr-2"></i>
                    Data riwayat ASN akan ditarik otomatis dari sistem SIASN saat integrasi API aktif.
                </p>
            </div>
            <div class="bg-gray-50 rounded-lg p-5 border border-dashed border-gray-300">
                <div class="text-center text-gray-400 py-8">
                    <i class="fas fa-database text-4xl mb-3 block text-gray-300"></i>
                    <p class="text-sm">Riwayat jabatan, kepangkatan, dan pendidikan ASN</p>
                    <p class="text-xs text-gray-400 mt-1">Akan tersedia setelah integrasi API SIASN</p>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button type="button" @click="currentStep = 1"
                        class="border border-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </button>
                <button type="button" @click="currentStep = 3"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow">
                    Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>

        {{-- STEP 3: Dokumen --}}
        <div x-show="currentStep === 3" class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-5 text-lg flex items-center gap-2">
                <i class="fas fa-paperclip text-orange-500"></i> Langkah 3 — Upload Dokumen
            </h3>

            {{-- Jika belum pilih kategori/jenis --}}
            <template x-if="dokumenWajib.length === 0">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-5">
                    <p class="text-sm text-yellow-700">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Kembali ke Step 1 dan pilih Kategori serta Jenis Usulan terlebih dahulu.
                    </p>
                </div>
            </template>

            {{-- Daftar dokumen otomatis --}}
            <template x-if="dokumenWajib.length > 0">
                <div>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg px-4 py-3 mb-4">
                        <p class="text-xs font-semibold text-orange-700 uppercase tracking-wide">
                            <i class="fas fa-folder-open mr-1"></i>
                            Dokumen untuk: <span x-text="kategori + ' — ' + jenisUsulan" class="normal-case"></span>
                        </p>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(dok, index) in dokumenWajib" :key="index">
                            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50 flex flex-col md:flex-row md:items-center gap-3">

                                {{-- Nomor & Nama dokumen (readonly, otomatis) --}}
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-orange-600 font-bold text-xs" x-text="index + 1"></span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800 text-sm" x-text="dok"></div>
                                        <div class="text-xs text-orange-500 mt-0.5">
                                            <i class="fas fa-asterisk text-xs"></i> Wajib dilampirkan
                                        </div>
                                        {{-- Hidden input untuk nama dokumen --}}
                                        <input type="hidden" :name="'nama_dokumen[' + index + ']'" :value="dok">
                                        <input type="hidden" :name="'jenis_dokumen[' + index + ']'" value="Wajib">
                                    </div>
                                </div>

                                {{-- Upload file --}}
                                <div class="md:w-72">
                                    <label class="block text-xs text-gray-500 mb-1">Upload File (PDF/JPG/PNG, maks 5MB)</label>
                                    <input type="file"
                                           :name="'dokumen[' + index + ']'"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-orange-500 file:text-white hover:file:bg-orange-600 cursor-pointer">
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Tambah dokumen tambahan --}}
                    <div class="mt-4" x-data="{ extras: [] }">
                        <template x-for="(ex, ei) in extras" :key="ei">
                            <div class="border border-dashed border-gray-300 rounded-xl p-4 bg-white flex flex-col md:flex-row md:items-center gap-3 mt-3">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-paperclip text-gray-400 text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" :name="'nama_dokumen[' + (dokumenWajib.length + ei) + ']'"
                                               class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                                               placeholder="Nama dokumen tambahan">
                                        <input type="hidden" :name="'jenis_dokumen[' + (dokumenWajib.length + ei) + ']'" value="Tambahan">
                                    </div>
                                </div>
                                <div class="md:w-72 flex gap-2 items-center">
                                    <input type="file" :name="'dokumen[' + (dokumenWajib.length + ei) + ']'"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-xs bg-white focus:outline-none file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-gray-500 file:text-white">
                                    <button type="button" @click="extras.splice(ei, 1)"
                                            class="text-red-400 hover:text-red-600 transition px-2">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <button type="button" @click="extras.push({})"
                                class="mt-3 w-full border-2 border-dashed border-gray-200 hover:border-orange-400 text-gray-400 hover:text-orange-500 py-3 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus-circle"></i> Tambah Dokumen Lain
                        </button>
                    </div>
                </div>
            </template>

            <div class="flex justify-between mt-6">
                <button type="button" @click="currentStep = 2"
                        class="border border-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </button>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-2.5 rounded-lg text-sm font-semibold transition shadow">
                    <i class="fas fa-save mr-1"></i> Simpan Berkas
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function berkasWizard() {
    return {
        currentStep: 1,
        nip: '', nama: '', pangkat: '', jabatan: '',
        unitKerjaSaatIni: '', statusPegawai: 'PNS',
        kategori: '', jenisUsulan: '', unitKerja: '', jabatanTujuan: '',
        dokumenWajib: [],

        dokumenMap: {
            'Pengangkatan|PLT/PLH': [
                'SK Pangkat Terakhir',
                'Surat Pengantar'
            ],
            'Pengangkatan|ke Jabatan Fungsional': [
                'Bukti Screen Shoot Riwayat Sertifikasi pada MyASN dengan Penulisan "Uji Kompetensi"',
                'Sertifikat Uji Kompetensi',
                'Surat Pengantar'
            ],
            'Pengangkatan|Pengangkatan Kembali Jabatan Fungsional (Khusus Tugas Belajar)': [
                'Surat Keterangan dari Universitas',
                'Surat Rekomendasi jurusan yang diterbitkan Bupati',
                'Surat Akreditasi Program Studi',
                'Surat Pengantar'
            ],
            'Promosi|Kenaikan Jenjang Jabatan Fungsional': [
                'Bukti Screen Shoot MyASN pada Riwayat Sertifikasi dengan Penulisan "Uji Kompetensi"',
                'Sertifikat Uji Kompetensi',
                'Surat Pengantar'
            ],
            'Mutasi|antar Perangkat Daerah': [
                'Persetujuan Mutasi dari Pimpinan Unit Kerja',
                'Penerimaan Persetujuan Mutasi dari Pimpinan Unit Kerja yang dituju',
                'Surat Pernyataan Ketersediaan Lowongan Jabatan dan Pembayaran TPP',
                'Surat Pengantar'
            ],
            'Mutasi|Jabatan di Unit Kerjanya (Internalisasi)': [
                'Surat Pernyataan Ketersediaan Lowongan Jabatan dan Pembayaran TPP',
                'Surat Pengantar'
            ],
            'Pengukuhan|Manajerial': [
                'Perbub SOTK Lama',
                'Perbub SOTK Baru',
                'Surat Pengantar'
            ],
            'Pengukuhan|Non Manajerial': [
                'Perbub SOTK Lama',
                'Perbub SOTK Baru',
                'Surat Pengantar'
            ],
            'Pemberhentian|Jabatan Fungsional (Khusus Tugas Belajar)': [
                'SK Tubel Bupati',
                'Surat Pengantar'
            ],
        },

        updateDokumen() {
            const key = this.kategori + '|' + this.jenisUsulan;
            this.dokumenWajib = this.dokumenMap[key] || [];
        },

        nextStep() {
            if (!this.kategori || !this.jenisUsulan || !this.unitKerja || !this.nip || !this.nama || !this.jabatanTujuan) {
                alert('Harap lengkapi semua field yang wajib diisi (*)');
                return;
            }
            this.currentStep = 2;
        },

        async cariASN() {
            if (!this.nip) return;
            const nipBersih = this.nip.replace(/\s+/g, '');
            let data;
            try {
                const res = await fetch(`{{ route('user.pns.cari') }}?nip=${encodeURIComponent(nipBersih)}`);
                data = await res.json();
            } catch (e) {
                alert('Gagal menghubungi server: ' + e.message);
                return;
            }
            if (data.error) {
                alert('Error server: ' + data.error);
            } else if (data.found) {
                this.nama = data.nama;
                this.pangkat = data.pangkat;
                this.jabatan = data.jabatan;
                this.unitKerjaSaatIni = data.unit_kerja;
            } else {
                alert('NIP tidak ditemukan di database. Silakan isi manual.');
            }
        }
    }
}
</script>
@endpush
