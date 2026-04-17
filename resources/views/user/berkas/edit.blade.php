@extends('layouts.app')

@section('title', 'Edit Berkas')
@section('page-title', 'Edit Berkas ASN')
@section('breadcrumb', 'Usulan / Berkas / Edit')

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
@php $asn = $berkas->asnBerkas->first(); @endphp
<div class="mt-4">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">
        <a href="{{ route('user.usulan.index') }}" class="hover:text-orange-600">Daftar Usulan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('user.berkas.index', $usulan) }}" class="hover:text-orange-600">Pertek/Rekomendasi</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Edit Berkas</span>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-4 text-sm">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('user.berkas.update', [$usulan, $berkas]) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Data ASN --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-5">
            <h3 class="font-bold text-gray-800 mb-5 text-lg flex items-center gap-2">
                <i class="fas fa-user-circle text-orange-500"></i> Data ASN & Prosedur
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @foreach(['Pengangkatan','Promosi','Mutasi','Pengukuhan','Pemberhentian'] as $k)
                        <option value="{{ $k }}" {{ $berkas->kategori === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Usulan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Usulan <span class="text-red-500">*</span></label>
                    <input type="text" name="jenis_usulan" value="{{ old('jenis_usulan', $berkas->jenis_usulan) }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                {{-- Jabatan Tujuan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan Tujuan</label>
                    <input type="text" name="jabatan_tujuan" value="{{ old('jabatan_tujuan', $asn?->jabatan_tujuan) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="Jabatan yang dituju">
                </div>

                {{-- Unit Kerja --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Kerja <span class="text-red-500">*</span></label>
                    <select name="unit_kerja" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">— Pilih Unit Kerja —</option>
                        @foreach($unitKerjaList as $dinas => $units)
                            <optgroup label="{{ $dinas }}">
                                @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ $berkas->unit_kerja === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIP / NIPPPK <span class="text-red-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip', $asn?->nip) }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                {{-- Status Pegawai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Pegawai <span class="text-red-500">*</span></label>
                    <select name="status_pegawai" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="PNS" {{ ($asn?->status_pegawai ?? 'PNS') === 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ ($asn?->status_pegawai) === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                    </select>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $asn?->nama) }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                {{-- Pangkat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pangkat / Gol. Ruang</label>
                    <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', $asn?->pangkat_golongan) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="contoh: Penata Muda / III-a">
                </div>

                {{-- Jabatan Saat Ini --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan Saat Ini</label>
                    <input type="text" name="jabatan_saat_ini" value="{{ old('jabatan_saat_ini', $asn?->jabatan_saat_ini) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                {{-- Unit Kerja Saat Ini --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Kerja Saat Ini</label>
                    <input type="text" name="unit_kerja_saat_ini" value="{{ old('unit_kerja_saat_ini', $asn?->unit_kerja_saat_ini) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                {{-- Kedudukan Hukum --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kedudukan Hukum</label>
                    <input type="text" name="kedudukan_hukum" value="{{ old('kedudukan_hukum', $asn?->kedudukan_hukum) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="contoh: Aktif">
                </div>
            </div>
        </div>

        {{-- Dokumen yang sudah ada --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-5">
            <h3 class="font-bold text-gray-800 mb-4 text-lg flex items-center gap-2">
                <i class="fas fa-paperclip text-orange-500"></i> Dokumen Terlampir
            </h3>

            @if($berkas->dokumen->isEmpty())
            <p class="text-sm text-gray-400 py-4 text-center">Belum ada dokumen terlampir.</p>
            @else
            <div class="space-y-2 mb-5">
                @foreach($berkas->dokumen as $dok)
                <div class="flex items-center justify-between border border-gray-200 rounded-lg px-4 py-3 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-alt text-orange-400"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $dok->nama_dokumen }}</p>
                            <p class="text-xs text-gray-400">{{ $dok->jenis_dokumen ?? 'Dokumen' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ Storage::url($dok->file_path) }}" target="_blank"
                           class="text-xs text-blue-600 hover:underline px-3 py-1.5 border border-blue-200 rounded-lg bg-blue-50">
                            <i class="fas fa-eye mr-1"></i> Lihat
                        </a>
                        <form method="POST"
                              action="{{ route('user.berkas.dokumen.destroy', [$usulan, $berkas, $dok]) }}"
                              onsubmit="return confirm('Hapus dokumen ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs text-red-600 hover:text-red-800 px-3 py-1.5 border border-red-200 rounded-lg bg-red-50 hover:bg-red-100 transition">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Tambah dokumen baru --}}
            <div x-data="{ extras: [{}] }">
                <p class="text-sm font-medium text-gray-700 mb-3">Tambah / Ganti Dokumen</p>
                <div class="space-y-3">
                    <template x-for="(ex, i) in extras" :key="i">
                        <div class="border border-dashed border-gray-300 rounded-xl p-4 bg-white flex flex-col md:flex-row md:items-center gap-3">
                            <div class="flex-1">
                                <input type="text" :name="'nama_dokumen[' + i + ']'"
                                       class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       placeholder="Nama dokumen (contoh: Surat Pengantar)">
                                <input type="hidden" :name="'jenis_dokumen[' + i + ']'" value="Tambahan">
                            </div>
                            <div class="md:w-72 flex gap-2 items-center">
                                <input type="file" :name="'dokumen[' + i + ']'"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-xs bg-white focus:outline-none file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-orange-500 file:text-white">
                                <button type="button" @click="extras.splice(i, 1)" x-show="extras.length > 1"
                                        class="text-red-400 hover:text-red-600 px-2">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                <button type="button" @click="extras.push({})"
                        class="mt-3 w-full border-2 border-dashed border-gray-200 hover:border-orange-400 text-gray-400 hover:text-orange-500 py-3 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i> Tambah Dokumen Lain
                </button>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="flex justify-between">
            <a href="{{ route('user.berkas.index', $usulan) }}"
               class="border border-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-2.5 rounded-lg text-sm font-semibold transition shadow">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
