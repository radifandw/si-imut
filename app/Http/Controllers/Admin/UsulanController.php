<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use App\Models\User;
use Illuminate\Http\Request;

class UsulanController extends Controller
{
    public function index(Request $request)
    {
        $query = Usulan::with('user')
            ->withCount(['berkas as jumlah_asn' => function ($q) {
                $q->join('asn_berkas', 'berkas.id', '=', 'asn_berkas.berkas_id');
            }]);

        if ($request->filled('tahapan')) {
            $query->where('tahapan', $request->tahapan);
        }
        if ($request->filled('kewenangan')) {
            $query->where('kewenangan', $request->kewenangan);
        }
        if ($request->filled('nomor_surat')) {
            $query->where('nomor_surat', 'like', '%' . $request->nomor_surat . '%');
        }

        $usulan = $query->latest()->paginate(10);
        $stats = [
            'total'    => Usulan::count(),
            'menunggu' => Usulan::where('tahapan', 'Menunggu Persetujuan Admin')->count(),
            'disetujui'=> Usulan::where('tahapan', 'Disetujui')->count(),
            'ditolak'  => Usulan::where('tahapan', 'Ditolak')->count(),
        ];

        return view('admin.usulan.index', compact('usulan', 'stats'));
    }

    public function show(Usulan $usulan)
    {
        $usulan->load(['user', 'berkas.asnBerkas', 'berkas.dokumen']);
        return view('admin.usulan.show', compact('usulan'));
    }

    public function setujui(Request $request, Usulan $usulan)
    {
        $usulan->update([
            'tahapan'       => 'Disetujui',
            'catatan_admin' => $request->catatan,
        ]);
        return back()->with('success', 'Usulan berhasil disetujui!');
    }

    public function tolak(Request $request, Usulan $usulan)
    {
        $request->validate(['catatan' => 'required|string']);
        $usulan->update([
            'tahapan'       => 'Ditolak',
            'catatan_admin' => $request->catatan,
        ]);
        return back()->with('success', 'Usulan telah ditolak.');
    }
}
