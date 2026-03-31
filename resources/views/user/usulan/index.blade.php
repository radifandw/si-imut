@extends('layouts.app')

@section('title', 'Daftar Usulan')
@section('page-title', 'Daftar Usulan Instansi')
@section('breadcrumb', 'Usulan / Daftar')

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
<div class="mt-4" x-data="usulanPage()">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Usulan Instansi</h2>
            <p class="text-sm text-gray-500">Kelola semua usulan mutasi ASN instansi Anda</p>
        </div>
        <button @click="showModal = true"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow transition">
            <i class="fas fa-plus"></i> Tambah Usul
        </button>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b text-left">
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-10">No</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Nomor / Tanggal / Perihal</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kewenangan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tahapan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Jumlah</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($usulan as $i => $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-blue-700">{{ $u->nomor_surat }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $u->tanggal_surat->format('d M Y') }}</div>
                            <div class="text-xs text-gray-600 mt-1 max-w-xs truncate">{{ $u->perihal }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium
                                {{ $u->kewenangan === 'BKN Pusat' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white' }}">
                                <i class="fas fa-building text-xs"></i> {{ $u->kewenangan }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium text-white {{ $u->tahapan_badge }}">
                                <i class="fas fa-circle text-xs opacity-70"></i> {{ $u->tahapan }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('user.berkas.index', $u) }}"
                               class="inline-flex items-center gap-1 bg-gray-800 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                <i class="fas fa-users text-xs"></i>
                                {{ $u->jumlah_asn ?? 0 }}
                            </a>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if(in_array($u->tahapan, ['Draft', 'Input Berkas PERTEK/Rekomendasi']))
                                <form method="POST" action="{{ route('user.usulan.kirim', $u) }}"
                                      onsubmit="return confirm('Kirim usulan ini ke admin?')">
                                    @csrf
                                    <button type="submit"
                                            class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg transition">
                                        <i class="fas fa-paper-plane mr-1"></i>Kirim
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('user.usulan.destroy', $u) }}"
                                      onsubmit="return confirm('Hapus usulan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition border border-red-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-gray-400 italic">{{ $u->tahapan }}</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center">
                            <i class="fas fa-inbox text-5xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 text-sm">Belum ada usulan. Klik <strong>Tambah Usul</strong> untuk membuat usulan baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Usulan --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
         @keydown.escape.window="showModal = false">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg" x-transition>
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Buat Usul Baru</h3>
                    <p class="text-xs text-gray-500">Isi data usulan mutasi ASN</p>
                </div>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('user.usulan.store') }}" class="px-6 py-5 space-y-4">
                @csrf
                {{-- Nomor Surat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Surat</label>
                    <div class="flex gap-2">
                        <input type="text" name="nomor_surat" x-model="nomorSurat" required
                               class="flex-1 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="P/0001/03/D/2026">
                        <button type="button" @click="generateNomor()"
                                :disabled="loading"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2">
                            <i class="fas fa-magic text-xs" :class="loading && 'animate-spin'"></i>
                            Generate
                        </button>
                    </div>
                </div>

                {{-- Tanggal Surat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" required
                           value="{{ date('Y-m-d') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Perihal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Perihal</label>
                    <textarea name="perihal" rows="3" required
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                              placeholder="Perihal Usulan (contoh: Permohonan Rekomendasi Mutasi ASN)"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showModal = false"
                            class="flex-1 border border-gray-200 text-gray-700 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-semibold transition shadow">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function usulanPage() {
    return {
        showModal: {{ $errors->any() ? 'true' : 'false' }},
        nomorSurat: '{{ old('nomor_surat') }}',
        loading: false,
        async generateNomor() {
            this.loading = true;
            try {
                const res = await fetch('{{ route('user.usulan.generate-nomor') }}');
                const data = await res.json();
                this.nomorSurat = data.nomor;
            } catch(e) {
                alert('Gagal generate nomor');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
