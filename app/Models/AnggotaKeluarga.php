<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    use HasFactory;
    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = ['nik', 'no_kk', 'nama', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pendidikan', 'pekerjaan', 'hubungan', 'penghasilan', 'tanggal_tambah', 'tanggal_update'];

    // Mapping angka ke string
    public const PENDIDIKAN = [
        0 => 'Tidak Sekolah',
        1 => 'SD',
        2 => 'SMP',
        3 => 'SMA',
        4 => 'Perguruan Tinggi',
    ];

    // Accessor untuk ubah angka ke label
    public function getPendidikanLabelAttribute()
    {
        return self::PENDIDIKAN[$this->pendidikan] ?? 'Tidak diketahui';
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'no_kk', 'no_kk');
    }
}
