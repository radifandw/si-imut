<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'    => Usulan::where('user_id', Auth::id())->count(),
            'proses'   => Usulan::where('user_id', Auth::id())->where('tahapan', 'Menunggu Persetujuan Admin')->count(),
            'disetujui'=> Usulan::where('user_id', Auth::id())->where('tahapan', 'Disetujui')->count(),
            'ditolak'  => Usulan::where('user_id', Auth::id())->where('tahapan', 'Ditolak')->count(),
        ];
        $recentUsulan = Usulan::where('user_id', Auth::id())->latest()->take(5)->get();
        return view('user.dashboard', compact('stats', 'recentUsulan'));
    }
}
