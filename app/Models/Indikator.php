<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;
    protected $table = 'indikator';
    protected $primaryKey = 'id_indikator';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = ['id_indikator', 'kode', 'tipe_input', 'nama_input', 'deskripsi'];

    public function keluargaIndikator()
    {
        return $this->hasMany(KeluargaIndikator::class, 'id_indikator', 'id_indikator');
    }

    public function penilaianIndikator()
    {
        return $this->hasMany(PenilaianIndikator::class, 'id_indikator', 'id_indikator');
    }

    public function riwayatIndikator()
    {
        return $this->hasMany(RiwayatIndikator::class, 'id_indikator', 'id_indikator');
    }
}
