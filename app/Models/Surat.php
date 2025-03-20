<?php

namespace App\Models;

use App\Models\Lokasi;
use App\Models\JamKerja;
use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surat extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'id_jam_kerja',
    //     'id_lokasi',
    //     'nomor_surat',
    //     'nama_kegiatan',
    //     'nama_PJ',
    //     'jabatan_PJ',
    //     'TTD_PJ',
    //     'narahubung',
    //     'qr_validasi'
    // ];
    protected $guarded = [];

    protected $table = 'surats';

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'id');
    }

    public function jamkerja()
    {
        return $this->belongsTo(JamKerja::class, 'jam_kerja_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id');
    }

    public function CetakSurat()
    {
        return $this->hasMany(CetakSurat::class, 'surat_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($surat) {
            $surat->nomor_surat = self::generateNomorSurat();
        });
    }

    private static function generateNomorSurat()
    {
        $latestSurat = self::whereYear('created_at', now()->year)->latest()->first();
        $nextNumber = $latestSurat ? ((int)substr($latestSurat->nomor_surat, 2, 3) + 1) : 1;

        // Konversi bulan ke format Romawi
        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $bulan = now()->month;
        $tahun = now()->year;

        return 'B/' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . '/' . $bulanRomawi[$bulan] . '/' . $tahun;
    }
}
