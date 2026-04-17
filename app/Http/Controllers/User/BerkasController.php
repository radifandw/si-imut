<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use App\Models\Berkas;
use App\Models\AsnBerkas;
use App\Models\DokumenBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function index(Usulan $usulan)
    {
        if ($usulan->user_id !== Auth::id()) abort(403);
        $berkas = $usulan->berkas()->with(['asnBerkas', 'dokumen'])->get();
        return view('user.berkas.index', compact('usulan', 'berkas'));
    }

    // API: cari PNS by NIP
    public function cariPns(Request $request)
    {
        $pns = \App\Models\Pns::where('nip', $request->nip)->first();
        if (!$pns) return response()->json(['found' => false]);

        return response()->json([
            'found'       => true,
            'nama'        => $pns->nama_lengkap ?: $pns->nama,
            'pangkat'     => trim(($pns->pangkat ?? '') . (' / ' . ($pns->golongan ?? ''))),
            'jabatan'     => $pns->jabatan,
            'unit_kerja'  => $pns->unit_kerja,
            'tempat_lahir'=> $pns->tempat_lahir,
            'tgl_lahir'   => $pns->tanggal_lahir?->format('d-m-Y'),
        ]);
    }

    public function create(Usulan $usulan)
    {
        if ($usulan->user_id !== Auth::id()) abort(403);
        $unitKerjaList = $this->getUnitKerjaList();
        return view('user.berkas.create', compact('usulan', 'unitKerjaList'));
    }

    public function store(Request $request, Usulan $usulan)
    {
        if ($usulan->user_id !== Auth::id()) abort(403);

        $request->validate([
            'kategori'           => 'required',
            'jenis_usulan'       => 'required',
            'unit_kerja'         => 'required',
            'nip'                => 'required',
            'nama'               => 'required',
            'pangkat_golongan'   => 'nullable|string',
            'jabatan_saat_ini'   => 'nullable|string',
            'jabatan_tujuan'     => 'nullable|string',
            'unit_kerja_saat_ini'=> 'nullable|string',
            'status_pegawai'     => 'required|in:PNS,PPPK',
            'kedudukan_hukum'    => 'nullable|string',
            'dokumen.*'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $berkas = Berkas::create([
            'usulan_id'    => $usulan->id,
            'kategori'     => $request->kategori,
            'jenis_usulan' => $request->jenis_usulan,
            'unit_kerja'   => $request->unit_kerja,
        ]);

        AsnBerkas::create([
            'berkas_id'          => $berkas->id,
            'nip'                => $request->nip,
            'nama'               => $request->nama,
            'pangkat_golongan'   => $request->pangkat_golongan,
            'jabatan_saat_ini'   => $request->jabatan_saat_ini,
            'jabatan_tujuan'     => $request->jabatan_tujuan,
            'unit_kerja_saat_ini'=> $request->unit_kerja_saat_ini,
            'status_pegawai'     => $request->status_pegawai,
            'kedudukan_hukum'    => $request->kedudukan_hukum,
        ]);

        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $index => $file) {
                $path = $file->store('dokumen/' . $usulan->id, 'public');
                DokumenBerkas::create([
                    'berkas_id'     => $berkas->id,
                    'nama_dokumen'  => $request->nama_dokumen[$index] ?? $file->getClientOriginalName(),
                    'file_path'     => $path,
                    'jenis_dokumen' => $request->jenis_dokumen[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('user.berkas.index', $usulan)->with('success', 'Berkas berhasil ditambahkan!');
    }

    public function destroy(Usulan $usulan, Berkas $berkas)
    {
        if ($usulan->user_id !== Auth::id()) abort(403);
        foreach ($berkas->dokumen as $dok) {
            Storage::disk('public')->delete($dok->file_path);
        }
        $berkas->delete();
        return back()->with('success', 'Berkas berhasil dihapus.');
    }

    private function getUnitKerjaList(): array
    {
        return [
            'Dinas Pendidikan dan Kebudayaan' => [
                'SDN 1 Panji - Dinas Pendidikan dan Kebudayaan',
                'SDN 2 Panji - Dinas Pendidikan dan Kebudayaan',
                'SDN 4 Jangkar Kec. Jangkar - Dinas Pendidikan dan Kebudayaan',
                'SDN 3 Paowan Kec. Panarukan - Dinas Pendidikan dan Kebudayaan',
                'SDN 5 Paowan Kec. Panarukan - Dinas Pendidikan dan Kebudayaan',
                'SDN 1 Wringin Anom Kec. Panarukan - Dinas Pendidikan dan Kebudayaan',
                'SDN 3 Balung Kec. Kendit - Dinas Pendidikan dan Kebudayaan',
                'SDN 4 Balung Kec. Kendit - Dinas Pendidikan dan Kebudayaan',
                'SDN 5 Tambak Ukir Kec. Kendit - Dinas Pendidikan dan Kebudayaan',
                'SDN 1 Campoan Kec. Mlandingan - Dinas Pendidikan dan Kebudayaan',
                'SDN Tepos Kec. Banyuglugur - Dinas Pendidikan dan Kebudayaan',
                'SDN Gadingan Kec. Jangkar - Dinas Pendidikan dan Kebudayaan',
                'SMPN 1 Situbondo - Dinas Pendidikan dan Kebudayaan',
                'SMPN 2 Situbondo - Dinas Pendidikan dan Kebudayaan',
            ],
            'Dinas Kesehatan' => [
                'RSUD Abdoer Rahem - Dinas Kesehatan',
                'Puskesmas Panji - Dinas Kesehatan',
                'Puskesmas Mlandingan - Dinas Kesehatan',
                'Puskesmas Banyuputih - Dinas Kesehatan',
            ],
            'Sekretariat Daerah' => [
                'Bagian Organisasi - Setda',
                'Bagian Hukum - Setda',
                'Bagian Umum - Setda',
            ],
            'Dinas Lainnya' => [
                'Dinas Perhubungan',
                'Dinas Sosial',
                'Dinas PUPR',
                'Badan Kepegawaian Daerah',
            ],
        ];
    }
}
