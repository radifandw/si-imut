@extends('layouts.app')

@section('title', 'Dashboard User')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Beranda / Dashboard')

@section('sidebar-menu')
    <a href="{{ route('user.dashboard') }}" class="sidebar-link {{ request()->routeIs('user.dashboard') ? 'active' : 'text-white' }}">
        <i class="fas fa-home w-5"></i> Dashboard
    </a>
    <div class="mt-4 mb-2 px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider">Usulan</div>
    <a href="{{ route('user.usulan.index') }}" class="sidebar-link {{ request()->routeIs('user.usulan.*') || request()->routeIs('user.berkas.*') ? 'active' : 'text-white' }}">
        <i class="fas fa-file-alt w-5"></i> Daftar Usulan
    </a>
@endsection

@section('content')
<div class="mt-4">
    {{-- Welcome --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 text-white mb-6 shadow">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="text-blue-100 text-sm">Selamat datang,</div>
                <div class="font-bold text-xl">{{ auth()->user()->name }}</div>
                <div class="text-blue-200 text-sm">{{ auth()->user()->instansi }}</div>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
        $cards = [
            ['label'=>'Total Usulan','value'=>$stats['total'],'icon'=>'fa-file-alt','color'=>'blue'],
            ['label'=>'Menunggu','value'=>$stats['proses'],'icon'=>'fa-clock','color'=>'yellow'],
            ['label'=>'Disetujui','value'=>$stats['disetujui'],'icon'=>'fa-check-circle','color'=>'green'],
            ['label'=>'Ditolak','value'=>$stats['ditolak'],'icon'=>'fa-times-circle','color'=>'red'],
        ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-{{ $card['color'] }}-100 rounded-xl flex items-center justify-center">
                <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }}-600 text-lg"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</div>
                <div class="text-xs text-gray-500">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Recent usulan --}}
    <div class="bg-white rounded-xl shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800">Usulan Terbaru</h3>
            <a href="{{ route('user.usulan.index') }}" class="text-blue-600 text-sm hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y">
            @forelse($recentUsulan as $u)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <div class="font-medium text-sm text-gray-800">{{ $u->nomor_surat }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">{{ $u->perihal }}</div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium text-white {{ $u->tahapan_badge }}">
                    {{ $u->tahapan }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">
                <i class="fas fa-inbox text-3xl mb-2 block text-gray-200"></i>
                Belum ada usulan
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
