@extends('layouts.app')

@section('title', 'Kelola Usulan')
@section('page-title', 'Kelola Semua Usulan')
@section('breadcrumb', 'Admin / Usulan')

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
<div class="mt-4">

    {{-- Statistik singkat --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
        @php
        $badges = [
            ['label'=>'Total','value'=>$stats['total'],'color'=>'blue'],
            ['label'=>'Menunggu','value'=>$stats['menunggu'],'color'=>'yellow'],
            ['label'=>'Disetujui','value'=>$stats['disetujui'],'color'=>'green'],
            ['label'=>'Ditolak','value'=>$stats['ditolak'],'color'=>'red'],
        ];
        @endphp
        @foreach($badges as $b)
        <div class="bg-white rounded-xl shadow-sm px-4 py-3 flex items-center gap-3">
            <div class="w-2 h-10 bg-{{ $b['color'] }}-500 rounded-full"></div>
            <div>
                <div class="text-xl font-bold text-gray-800">{{ $b['value'] }}</div>
                <div class="text-xs text-gray-500">{{ $b['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-40">
                <label class="text-xs font-medium text-gray-500 mb-1 block">Nomor Surat</label>
                <input type="text" name="nomor_surat" value="{{ request('nomor_surat') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Cari nomor surat...">
            </div>
            <div class="min-w-40">
                <label class="text-xs font-medium text-gray-500 mb-1 block">Tahapan</label>
                <select name="tahapan" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="Input Berkas PERTEK/Rekomendasi" {{ request('tahapan') === 'Input Berkas PERTEK/Rekomendasi' ? 'selected' : '' }}>Input Berkas</option>
                    <option value="Menunggu Persetujuan Admin" {{ request('tahapan') === 'Menunggu Persetujuan Admin' ? 'selected' : '' }}>Menunggu Review</option>
                    <option value="Disetujui" {{ request('tahapan') === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('tahapan') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="min-w-40">
                <label class="text-xs font-medium text-gray-500 mb-1 block">Kewenangan</label>
                <select name="kewenangan" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="Admin Kabupaten" {{ request('kewenangan') === 'Admin Kabupaten' ? 'selected' : '' }}>Admin Kabupaten</option>
                    <option value="BKN Pusat" {{ request('kewenangan') === 'BKN Pusat' ? 'selected' : '' }}>BKN Pusat</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('admin.usulan.index') }}" class="border border-gray-200 text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-medium transition">
                Reset
            </a>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b text-left">
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-10">No</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Nomor / Tanggal / Perihal</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Instansi</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kewenangan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tahapan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-center">ASN</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($usulan as $i => $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 text-gray-500">{{ $usulan->firstItem() + $i }}</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-blue-700">{{ $u->nomor_surat }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $u->tanggal_surat->format('d M Y') }}</div>
                            <div class="text-xs text-gray-600 mt-1 max-w-xs truncate">{{ $u->perihal }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-700 font-medium">{{ $u->user->instansi ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $u->user->name ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $u->kewenangan === 'BKN Pusat' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white' }}">
                                {{ $u->kewenangan }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white {{ $u->tahapan_badge }}">
                                {{ $u->tahapan }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center gap-1 bg-gray-800 text-white px-3 py-1 rounded-lg text-xs font-medium">
                                <i class="fas fa-users text-xs"></i> {{ $u->jumlah_asn ?? 0 }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('admin.usulan.show', $u) }}"
                               class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                <i class="fas fa-eye"></i> Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <i class="fas fa-inbox text-5xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 text-sm">Tidak ada usulan ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($usulan->hasPages())
        <div class="px-6 py-4 border-t">{{ $usulan->links() }}</div>
        @endif
    </div>
</div>
@endsection
