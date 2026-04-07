@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('breadcrumb', 'Beranda / Dashboard')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-white' }}">
        <i class="fas fa-home w-5"></i> Dashboard
    </a>
    <div class="mt-4 mb-2 px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider">Manajemen</div>
    <a href="{{ route('admin.usulan.index') }}" class="sidebar-link {{ request()->routeIs('admin.usulan.*') ? 'active' : 'text-white' }}">
        <i class="fas fa-file-alt w-5"></i> Kelola Usulan
    </a>
@endsection

@section('content')
<div class="mt-4">
    <div class="bg-gradient-to-r from-orange-500 to-orange-700 rounded-2xl p-6 text-white mb-6 shadow">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div class="text-blue-100 text-sm">Panel Administrator</div>
                <div class="font-bold text-xl">{{ auth()->user()->name }}</div>
                <div class="text-blue-200 text-sm">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        @php
        $cards = [
            ['label'=>'Total Usulan','value'=>$stats['total_usulan'],'icon'=>'fa-file-alt','color'=>'blue'],
            ['label'=>'Menunggu Review','value'=>$stats['menunggu'],'icon'=>'fa-clock','color'=>'yellow'],
            ['label'=>'Disetujui','value'=>$stats['disetujui'],'icon'=>'fa-check-circle','color'=>'green'],
            ['label'=>'Ditolak','value'=>$stats['ditolak'],'icon'=>'fa-times-circle','color'=>'red'],
            ['label'=>'Total Instansi','value'=>$stats['total_user'],'icon'=>'fa-building','color'=>'purple'],
        ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-3">
            <div class="w-11 h-11 bg-{{ $card['color'] }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }}-600"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</div>
                <div class="text-xs text-gray-500 leading-tight">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel usulan terbaru --}}
    <div class="bg-white rounded-xl shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800">Usulan Terbaru</h3>
            <a href="{{ route('admin.usulan.index') }}" class="text-orange-600 text-sm hover:underline">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nomor Surat</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Instansi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Perihal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tahapan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentUsulan as $u)
                    <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('admin.usulan.show', $u) }}'">
                        <td class="px-4 py-3 font-semibold text-orange-600">{{ $u->nomor_surat }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $u->user->instansi ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate">{{ $u->perihal }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium text-white {{ $u->tahapan_badge }}">
                                {{ $u->tahapan }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $u->tanggal_surat->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400 text-sm">
                            Belum ada usulan masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
