<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;
    protected $table = 'keluarga';
    protected $primaryKey = 'no_kk';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'no_kk',
        'total_penghasilan',
        'luas_lantai',
        'alamat',
        'rt_rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'kode_pos',
        'provinsi',
        'tanggal_tambah',
        'tanggal_update'
    ];

    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'no_kk', 'no_kk');
    }

    public function keluargaIndikator()
    {
        return $this->hasMany(KeluargaIndikator::class, 'no_kk', 'no_kk');
    }

    public function prediksi()
    {
        return $this->hasMany(Prediksi::class, 'no_kk', 'no_kk');
    }
}
