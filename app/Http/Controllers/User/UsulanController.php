<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsulanController extends Controller
{
    public function index()
    {
        $usulan = Usulan::where('user_id', Auth::id())
            ->withCount(['berkas as jumlah_asn' => function ($q) {
                $q->join('asn_berkas', 'berkas.id', '=', 'asn_berkas.berkas_id');
            }])
            ->latest()
            ->get();

        return view('user.usulan.index', compact('usulan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'   => 'required|unique:usulan,nomor_surat',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required|string|max:500',
        ]);

        Usulan::create([
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal'       => $request->perihal,
            'user_id'       => Auth::id(),
            'tahapan'       => 'Input Berkas PERTEK/Rekomendasi',
            'kewenangan'    => 'Admin Kabupaten',
            'jenis_usulan'  => 'Non Otomasi',
        ]);

        return redirect()->route('user.usulan.index')->with('success', 'Usulan berhasil dibuat!');
    }

    public function generateNomor()
    {
        return response()->json(['nomor' => Usulan::generateNomor()]);
    }

    public function destroy(Usulan $usulan)
    {
        if ($usulan->user_id !== Auth::id()) abort(403);
        if (!in_array($usulan->tahapan, ['Draft', 'Input Berkas PERTEK/Rekomendasi'])) {
            return back()->with('error', 'Usulan tidak bisa dihapus pada tahapan ini.');
        }
        $usulan->delete();
        return redirect()->route('user.usulan.index')->with('success', 'Usulan berhasil dihapus.');
    }

    public function kirim(Usulan $usulan)
    {
        if ($usulan->user_id !== Auth::id()) abort(403);
        if (!in_array($usulan->tahapan, ['Draft', 'Input Berkas PERTEK/Rekomendasi'])) {
            return back()->with('error', 'Usulan tidak bisa dikirim pada tahapan ini.');
        }
        $usulan->update(['tahapan' => 'Menunggu Persetujuan Admin']);
        return redirect()->route('user.usulan.index')->with('success', 'Usulan berhasil dikirim ke admin!');
    }

    /**
     * Revisi usulan yang ditolak — reset ke Input Berkas
     * agar user bisa edit berkas dan kirim ulang
     */
    public function revisi(Usulan $usulan)
    {
        if ($usulan->user_id !== Auth::id()) abort(403);

        if ($usulan->tahapan !== 'Ditolak') {
            return back()->with('error', 'Hanya usulan yang ditolak yang bisa direvisi.');
        }

        $usulan->update([
            'tahapan'       => 'Input Berkas PERTEK/Rekomendasi',
            'catatan_admin' => $usulan->catatan_admin, // simpan catatan admin sebagai referensi
        ]);

        return redirect()
            ->route('user.berkas.index', $usulan)
            ->with('success', 'Usulan siap direvisi. Silakan perbaiki berkas sesuai catatan admin, lalu kirim ulang.');
    }
}