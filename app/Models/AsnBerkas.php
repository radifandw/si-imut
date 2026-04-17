<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsnBerkas extends Model
{
    protected $table = 'asn_berkas';

    protected $fillable = [
        'berkas_id', 'nip', 'nama', 'pangkat_golongan',
        'jabatan_saat_ini', 'jabatan_tujuan', 'unit_kerja_saat_ini',
        'status_pegawai', 'kedudukan_hukum',
    ];

    public function berkas()
    {
        return $this->belongsTo(Berkas::class);
    }
}
