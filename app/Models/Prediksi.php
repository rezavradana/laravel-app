<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;
    protected $table = 'prediksi';
    protected $primaryKey = 'id_prediksi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_prediksi','no_kk', 'username', 'hasil_prediksi','probabilitas','tanggal_prediksi'];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'no_kk', 'no_kk');
    }

    public function riwayatIndikator()
    {
        return $this->hasMany(RiwayatIndikator::class, 'id_prediksi', 'id_prediksi');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
