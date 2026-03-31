<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_usulan'  => Usulan::count(),
            'menunggu'      => Usulan::where('tahapan', 'Menunggu Persetujuan Admin')->count(),
            'disetujui'     => Usulan::where('tahapan', 'Disetujui')->count(),
            'ditolak'       => Usulan::where('tahapan', 'Ditolak')->count(),
            'total_user'    => User::where('role', 'user')->count(),
        ];
        $recentUsulan = Usulan::with('user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentUsulan'));
    }
}
