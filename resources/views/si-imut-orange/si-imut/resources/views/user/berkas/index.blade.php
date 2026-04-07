@extends('layouts.app')

@section('title', 'Pertek/Rekomendasi')
@section('page-title', 'Pertek / Rekomendasi')
@section('breadcrumb', 'Usulan / Berkas')

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
<div class="mt-4">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">
        <a href="{{ route('user.usulan.index') }}" class="hover:text-orange-600 transition">Daftar Usulan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Pertek/Rekomendasi</span>
    </div>

    {{-- Info Usulan --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                <div>
                    <div class="flex items-center gap-2 text-gray-400 text-xs mb-1"><i class="fas fa-file-alt"></i> Nomor Surat</div>
                    <div class="font-bold text-orange-600">{{ $usulan->nomor_surat }}</div>
                </div>
                <div>
                    <div class="flex items-center gap-2 text-gray-400 text-xs mb-1"><i class="fas fa-calendar"></i> Tanggal Surat</div>
                    <div class="font-semibold text-gray-800">{{ $usulan->tanggal_surat->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="flex items-center gap-2 text-gray-400 text-xs mb-1"><i class="fas fa-tag"></i> Jenis Usulan</div>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-800 text-white">
                        <i class="fas fa-hand-point-right text-xs"></i> {{ $usulan->jenis_usulan }}
                    </span>
                </div>
            </div>
            <div>
                <span class="px-4 py-2 rounded-full text-sm font-medium text-white {{ $usulan->tahapan_badge }}">
                    {{ $usulan->tahapan }}
                </span>
            </div>
        </div>

        <div class="mt-4 flex gap-3">
            @if(in_array($usulan->tahapan, ['Draft', 'Input Berkas PERTEK/Rekomendasi']))
            <a href="{{ route('user.berkas.create', $usulan) }}"
               class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow transition">
                <i class="fas fa-plus"></i> Tambah Berkas
            </a>
            <form method="POST" action="{{ route('user.usulan.kirim', $usulan) }}"
                  onsubmit="return confirm('Kirim usulan ini ke admin untuk diproses?')">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow transition">
                    <i class="fas fa-paper-plane"></i> Kirim Usulan
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Tabel Berkas/ASN --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Daftar Berkas ASN</h3>
            <span class="bg-orange-100 text-orange-600 text-xs font-medium px-3 py-1 rounded-full">
                {{ $berkas->count() }} berkas
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b text-left">
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-10">No</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Nama ASN</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">NIP</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pangkat/Gol</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jabatan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Unit Kerja</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Dokumen</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($berkas as $i => $b)
                        @foreach($b->asnBerkas as $asn)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-800">{{ $asn->nama }}</div>
                                <div class="text-xs text-gray-400">{{ $asn->status_pegawai }}</div>
                            </td>
                            <td class="px-4 py-4 text-gray-600 font-mono text-xs">{{ $asn->nip }}</td>
                            <td class="px-4 py-4 text-gray-600 text-xs">{{ $asn->pangkat_golongan ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-600 text-xs">{{ $asn->jabatan_saat_ini ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-600 text-xs max-w-xs">{{ $b->unit_kerja ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-medium">{{ $b->kategori }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                    {{ $b->dokumen->count() }} file
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if(in_array($usulan->tahapan, ['Draft', 'Input Berkas PERTEK/Rekomendasi']))
                                <form method="POST" action="{{ route('user.berkas.destroy', [$usulan, $b]) }}"
                                      onsubmit="return confirm('Hapus berkas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition border border-red-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-16 text-center">
                            <i class="fas fa-folder-open text-5xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 text-sm">Belum ada berkas. Klik <strong>Tambah Berkas</strong> untuk menambahkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
