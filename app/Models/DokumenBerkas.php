<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenBerkas extends Model
{
    protected $table = 'dokumen_berkas';

    protected $fillable = ['berkas_id', 'nama_dokumen', 'file_path', 'jenis_dokumen'];

    public function berkas()
    {
        return $this->belongsTo(Berkas::class);
    }
}
