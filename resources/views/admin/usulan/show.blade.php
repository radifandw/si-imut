@extends('layouts.app')

@section('title', 'Detail Usulan')
@section('page-title', 'Review Usulan')
@section('breadcrumb', 'Admin / Usulan / Detail')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link text-white">
        <i class="fas fa-home w-5"></i> Dashboard
    </a>
    <div class="mt-4 mb-2 px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider">Manajemen</div>
    <a href="{{ route('admin.usulan.index') }}" class="sidebar-link active">
        <i class="fas fa-file-alt w-5"></i> Kelola Usulan
    </a>
@endsection

@section('content')
<div class="mt-4" x-data="{ showSetujui: false, showTolak: false }">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">
        <a href="{{ route('admin.usulan.index') }}" class="hover:text-blue-600">Kelola Usulan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">{{ $usulan->nomor_surat }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Kiri: Info Usulan --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Header Card --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $usulan->nomor_surat }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $usulan->tanggal_surat->format('d M Y') }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-medium text-white {{ $usulan->tahapan_badge }}">
                        {{ $usulan->tahapan }}
                    </span>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-xs font-semibold text-gray-400 uppercase mb-1">Perihal</div>
                    <p class="text-gray-800 text-sm">{{ $usulan->perihal }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase mb-1">Kewenangan</div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $usulan->kewenangan === 'BKN Pusat' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white' }}">
                            {{ $usulan->kewenangan }}
                        </span>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase mb-1">Jenis Usulan</div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-800 text-white">
                            {{ $usulan->jenis_usulan }}
                        </span>
                    </div>
                </div>

                @if($usulan->catatan_admin)
                <div class="mt-4 p-4 rounded-lg {{ $usulan->tahapan === 'Ditolak' ? 'bg-red-50 border border-red-200' : 'bg-green-50 border border-green-200' }}">
                    <div class="text-xs font-semibold {{ $usulan->tahapan === 'Ditolak' ? 'text-red-500' : 'text-green-600' }} uppercase mb-1">
                        <i class="fas fa-comment-alt mr-1"></i> Catatan Admin
                    </div>
                    <p class="text-sm {{ $usulan->tahapan === 'Ditolak' ? 'text-red-700' : 'text-green-700' }}">{{ $usulan->catatan_admin }}</p>
                </div>
                @endif
            </div>

            {{-- Daftar Berkas ASN --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Daftar Berkas ASN</h3>
                    <span class="bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">
                        {{ $usulan->berkas->count() }} berkas
                    </span>
                </div>

                @forelse($usulan->berkas as $i => $b)
                <div class="p-6 {{ !$loop->last ? 'border-b' : '' }}">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ $i + 1 }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">{{ $b->kategori }} — {{ $b->jenis_usulan }}</div>
                            <div class="text-xs text-gray-500">{{ $b->unit_kerja }}</div>
                        </div>
                    </div>

                    @foreach($b->asnBerkas as $asn)
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <div>
                                <div class="text-xs text-gray-400 mb-0.5">Nama</div>
                                <div class="text-sm font-semibold text-gray-800">{{ $asn->nama }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-0.5">NIP</div>
                                <div class="text-sm text-gray-700 font-mono">{{ $asn->nip }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-0.5">Status</div>
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs font-medium">{{ $asn->status_pegawai }}</span>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-0.5">Pangkat/Gol</div>
                                <div class="text-sm text-gray-700">{{ $asn->pangkat_golongan ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-0.5">Jabatan</div>
                                <div class="text-sm text-gray-700">{{ $asn->jabatan_saat_ini ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-0.5">Kedudukan Hukum</div>
                                <div class="text-sm text-gray-700">{{ $asn->kedudukan_hukum ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Dokumen --}}
                    @if($b->dokumen->count() > 0)
                    <div class="mt-3">
                        <div class="text-xs font-semibold text-gray-400 uppercase mb-2">Dokumen Lampiran</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($b->dokumen as $dok)
                            <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                               class="flex items-center gap-2 bg-white border border-gray-200 hover:border-blue-400 hover:text-blue-600 px-3 py-2 rounded-lg text-xs font-medium transition">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                {{ $dok->nama_dokumen }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @empty
                <div class="px-6 py-12 text-center text-gray-400 text-sm">
                    <i class="fas fa-folder-open text-4xl text-gray-200 mb-3 block"></i>
                    Belum ada berkas yang diinput
                </div>
                @endforelse
            </div>
        </div>

        {{-- Kanan: Info Pengirim + Aksi --}}
        <div class="space-y-5">

            {{-- Info Instansi --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm">Informasi Pengirim</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-700">
                        {{ strtoupper(substr($usulan->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800 text-sm">{{ $usulan->user->name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $usulan->user->email ?? '-' }}</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Instansi</span>
                        <span class="text-gray-700 font-medium text-right max-w-32 text-xs">{{ $usulan->user->instansi ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">NIP</span>
                        <span class="text-gray-700 font-mono text-xs">{{ $usulan->user->nip ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Dikirim</span>
                        <span class="text-gray-700 text-xs">{{ $usulan->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Aksi Admin --}}
            @if($usulan->tahapan === 'Menunggu Persetujuan Admin')
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm">Tindakan Admin</h3>
                <div class="space-y-3">
                    <button @click="showSetujui = true"
                            class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold transition shadow">
                        <i class="fas fa-check-circle"></i> Setujui Usulan
                    </button>
                    <button @click="showTolak = true"
                            class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-semibold transition shadow">
                        <i class="fas fa-times-circle"></i> Tolak Usulan
                    </button>
                </div>
            </div>
            @endif

            {{-- Timeline --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm">Timeline Status</h3>
                <div class="space-y-3">
                    @php
                    $steps = ['Draft','Input Berkas PERTEK/Rekomendasi','Menunggu Persetujuan Admin','Disetujui'];
                    $current = array_search($usulan->tahapan, $steps);
                    if($usulan->tahapan === 'Ditolak') $current = 99;
                    @endphp
                    @foreach($steps as $idx => $step)
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 text-xs
                            {{ $idx < $current ? 'bg-green-500 text-white' : ($idx === $current ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400') }}">
                            @if($idx < $current)
                                <i class="fas fa-check text-xs"></i>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </div>
                        <span class="text-xs {{ $idx === $current ? 'text-blue-600 font-semibold' : ($idx < $current ? 'text-green-600' : 'text-gray-400') }}">
                            {{ $step }}
                        </span>
                    </div>
                    @endforeach
                    @if($usulan->tahapan === 'Ditolak')
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center text-xs">
                            <i class="fas fa-times text-xs"></i>
                        </div>
                        <span class="text-xs text-red-600 font-semibold">Ditolak</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Setujui --}}
    <div x-show="showSetujui" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
         @keydown.escape.window="showSetujui = false">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showSetujui = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" x-transition>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Setujui Usulan</h3>
                    <p class="text-xs text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.usulan.setujui', $usulan) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan (opsional)</label>
                    <textarea name="catatan" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"
                              placeholder="Tambahkan catatan persetujuan..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" @click="showSetujui = false"
                            class="flex-1 border border-gray-200 text-gray-700 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold shadow">
                        <i class="fas fa-check mr-1"></i> Ya, Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div x-show="showTolak" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
         @keydown.escape.window="showTolak = false">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showTolak = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" x-transition>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Tolak Usulan</h3>
                    <p class="text-xs text-gray-500">Wajib isi alasan penolakan</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.usulan.tolak', $usulan) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="catatan" rows="4" required
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"
                              placeholder="Jelaskan alasan penolakan usulan ini..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" @click="showTolak = false"
                            class="flex-1 border border-gray-200 text-gray-700 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-semibold shadow">
                        <i class="fas fa-times mr-1"></i> Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
