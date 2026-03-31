@extends('layouts.app')

@section('title', 'Tambah Berkas')
@section('page-title', 'Tambah Berkas ASN')
@section('breadcrumb', 'Usulan / Berkas / Tambah')

@section('sidebar-menu')
    <a href="{{ route('user.dashboard') }}" class="sidebar-link text-white">
        <i class="fas fa-home w-5"></i> Dashboard
    </a>
    <div class="mt-4 mb-2 px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider">Usulan</div>
    <a href="{{ route('user.usulan.index') }}" class="sidebar-link active">
        <i class="fas fa-file-alt w-5"></i> Daftar Usulan
    </a>
@endsection

@section('content')
<div class="mt-4" x-data="berkasWizard()">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">
        <a href="{{ route('user.usulan.index') }}" class="hover:text-blue-600">Daftar Usulan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('user.berkas.index', $usulan) }}" class="hover:text-blue-600">Pertek/Rekomendasi</a>
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
                        ? 'border-b-2 border-blue-600 text-blue-600 bg-blue-50'
                        : (currentStep > {{ $i + 1 }} ? 'text-green-600' : 'text-gray-400')"
                    class="flex-1 flex items-center justify-center gap-2 py-4 text-sm font-medium transition">
                <span :class="currentStep > {{ $i + 1 }} ? 'bg-green-500' : (currentStep === {{ $i + 1 }} ? 'bg-blue-600' : 'bg-gray-300')"
                      class="w-6 h-6 rounded-full text-white text-xs flex items-center justify-center font-bold">
                    <template x-if="currentStep > {{ $i + 1 }}"><i class="fas fa-check text-xs"></i></template>
                    <template x-if="currentStep <= {{ $i + 1 }}">{{ $i + 1 }}</template>
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
                <i class="fas fa-user-circle text-blue-600"></i> Langkah 1 — Pilih Prosedur & Data ASN
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" x-model="kategori" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Pilih Kategori —</option>
                        <option value="Mutasi">Mutasi</option>
                        <option value="Kenaikan Pangkat">Kenaikan Pangkat</option>
                        <option value="Pensiun">Pensiun</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                {{-- Jenis Usulan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Usulan <span class="text-red-500">*</span></label>
                    <select name="jenis_usulan" x-model="jenisUsulan" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Pilih Jenis —</option>
                        <option value="Mutasi Jabatan Guru">Mutasi Jabatan Guru</option>
                        <option value="Mutasi Jabatan Fungsional">Mutasi Jabatan Fungsional</option>
                        <option value="Mutasi Jabatan Struktural">Mutasi Jabatan Struktural</option>
                        <option value="Pengangkatan Manajerial">Pengangkatan Manajerial</option>
                        <option value="Tugas Tambahan Kepala">Tugas Tambahan Kepala</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                {{-- Unit Kerja --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Kerja <span class="text-red-500">*</span></label>
                    <select name="unit_kerja" x-model="unitKerja" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                               class="flex-1 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                               placeholder="19850101 201001 1 001">
                        <button type="button" @click="cariASN()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-search mr-1"></i> Cari
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Masukkan NIP lalu klik Cari, atau isi manual di bawah</p>
                </div>

                {{-- Status Pegawai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Pegawai <span class="text-red-500">*</span></label>
                    <select name="status_pegawai" x-model="statusPegawai" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="PNS">PNS</option>
                        <option value="PPPK">PPPK</option>
                    </select>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" x-model="nama" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nama lengkap ASN">
                </div>

                {{-- Pangkat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pangkat / Gol. Ruang</label>
                    <input type="text" name="pangkat_golongan" x-model="pangkat"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="contoh: Penata Muda / III-a">
                </div>

                {{-- Jabatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan Saat Ini</label>
                    <input type="text" name="jabatan_saat_ini" x-model="jabatan"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="contoh: Guru Kelas">
                </div>

                {{-- Unit Kerja Saat Ini --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Kerja Saat Ini</label>
                    <input type="text" name="unit_kerja_saat_ini" x-model="unitKerjaSaatIni"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nama unit kerja saat ini">
                </div>

                {{-- Kedudukan Hukum --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kedudukan Hukum</label>
                    <input type="text" name="kedudukan_hukum"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="contoh: Aktif">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" @click="nextStep()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow">
                    Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>

        {{-- STEP 2: Riwayat --}}
        <div x-show="currentStep === 2" class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-5 text-lg flex items-center gap-2">
                <i class="fas fa-history text-blue-600"></i> Langkah 2 — Riwayat ASN
            </h3>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-5">
                <p class="text-sm text-blue-700"><i class="fas fa-info-circle mr-2"></i>
                    Data riwayat ASN akan ditarik otomatis dari sistem SIASN saat integrasi API aktif. Untuk saat ini, pastikan data di tab Data ASN sudah lengkap dan benar.
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
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow">
                    Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>

        {{-- STEP 3: Dokumen --}}
        <div x-show="currentStep === 3" class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-5 text-lg flex items-center gap-2">
                <i class="fas fa-paperclip text-blue-600"></i> Langkah 3 — Upload Dokumen
            </h3>

            <div class="space-y-4" x-data="{ files: [] }">
                <template x-for="(file, index) in files" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs font-medium text-gray-600 mb-1 block">Nama Dokumen</label>
                                <input type="text" :name="'nama_dokumen[' + index + ']'"
                                       class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="contoh: SK Terakhir">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600 mb-1 block">Jenis Dokumen</label>
                                <select :name="'jenis_dokumen[' + index + ']'"
                                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="SK">SK</option>
                                    <option value="Ijazah">Ijazah</option>
                                    <option value="Sertifikat">Sertifikat</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600 mb-1 block">File (PDF/JPG/PNG)</label>
                                <div class="flex gap-2">
                                    <input type="file" :name="'dokumen[' + index + ']'"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="flex-1 border border-gray-200 rounded px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button type="button" @click="files.splice(index, 1)"
                                            class="text-red-500 hover:text-red-700 px-2">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <button type="button" @click="files.push({})"
                        class="w-full border-2 border-dashed border-gray-300 hover:border-blue-400 text-gray-400 hover:text-blue-500 py-4 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i> Tambah Dokumen
                </button>

                <p class="text-xs text-gray-400 text-center">Format: PDF, JPG, PNG. Maksimal 5MB per file.</p>
            </div>

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
        nip: '',
        nama: '',
        pangkat: '',
        jabatan: '',
        unitKerjaSaatIni: '',
        statusPegawai: 'PNS',
        kategori: '',
        jenisUsulan: '',
        unitKerja: '',
        nextStep() {
            if (!this.kategori || !this.jenisUsulan || !this.unitKerja || !this.nip || !this.nama) {
                alert('Harap lengkapi semua field yang wajib diisi (*)');
                return;
            }
            this.currentStep = 2;
        },
        cariASN() {
            // Dummy data untuk demo
            const dummyData = {
                '197001011995031001': { nama: 'Budi Santoso, S.Pd', pangkat: 'Pembina / IV-a', jabatan: 'Guru Madya', unit: 'SDN 1 Panji' },
                '198505152010011002': { nama: 'Siti Aminah, S.Pd', pangkat: 'Penata / III-c', jabatan: 'Guru Pertama', unit: 'SDN 2 Panji' },
            };
            const nipClean = this.nip.replace(/\s/g, '');
            if (dummyData[nipClean]) {
                const d = dummyData[nipClean];
                this.nama = d.nama;
                this.pangkat = d.pangkat;
                this.jabatan = d.jabatan;
                this.unitKerjaSaatIni = d.unit;
            } else {
                alert('NIP tidak ditemukan di database dummy. Isi data manual.');
            }
        }
    }
}
</script>
@endpush
