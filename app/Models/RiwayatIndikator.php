<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatIndikator extends Model
{
    use HasFactory;
    protected $table = 'riwayat_indikator';
    protected $primaryKey = 'id_riwayat_indikator';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_riwayat_indikator', 'id_prediksi', 'id_indikator', 'nilai', 'tanggal_tambah'];

    public function prediksi()
    {
        return $this->belongsTo(Prediksi::class, 'id_prediksi', 'id_prediksi');
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'id_indikator', 'id_indikator');
    }
}
