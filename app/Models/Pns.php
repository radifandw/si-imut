<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pns extends Model
{
    use HasFactory;

    protected $table = 'pns';

    protected $fillable = [
        'nip', 'nik', 'nama', 'gelar_depan', 'gelar_belakang',
        'nama_lengkap', 'golongan', 'pangkat', 'tmt_golongan',
        'jabatan', 'tmt_jabatan', 'unit_kerja',
        'tempat_lahir', 'tanggal_lahir',
    ];

    protected $casts = [
        'tmt_golongan' => 'date',
        'tmt_jabatan'  => 'date',
        'tanggal_lahir'=> 'date',
    ];

    // Accessor: generate nama_lengkap from parts if not set
    public function getNamaLengkapAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        $parts = [];
        if ($this->gelar_depan) {
            $parts[] = $this->gelar_depan;
        }
        if ($this->nama) {
            $parts[] = $this->nama;
        }
        if ($this->gelar_belakang) {
            $parts[] = $this->gelar_belakang;
        }

        return trim(implode(' ', $parts));
    }
}
