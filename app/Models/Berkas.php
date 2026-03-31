<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $fillable = ['usulan_id', 'kategori', 'jenis_usulan', 'unit_kerja'];

    public function usulan()
    {
        return $this->belongsTo(Usulan::class);
    }

    public function asnBerkas()
    {
        return $this->hasMany(AsnBerkas::class);
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenBerkas::class);
    }
}
