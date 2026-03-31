<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usulan extends Model
{
    protected $table = 'usulan';

    protected $fillable = [
        'nomor_surat', 'tanggal_surat', 'perihal',
        'kewenangan', 'tahapan', 'jenis_usulan',
        'user_id', 'catatan_admin',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }

    public function jumlahASN()
    {
        return $this->berkas()->withCount('asnBerkas')->get()->sum('asn_berkas_count');
    }

    public static function generateNomor(): string
    {
        $bulan  = now()->format('m');
        $tahun  = now()->format('Y');
        $last   = self::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->count() + 1;
        return "P/{$last}/{$bulan}/D/{$tahun}";
    }

    public function getTahapanBadgeAttribute(): string
    {
        return match($this->tahapan) {
            'Draft'                            => 'bg-gray-400',
            'Input Berkas PERTEK/Rekomendasi'  => 'bg-green-500',
            'Menunggu Persetujuan Admin'        => 'bg-yellow-500',
            'Disetujui'                        => 'bg-blue-500',
            'Ditolak'                          => 'bg-red-500',
            default                            => 'bg-gray-400',
        };
    }
}
