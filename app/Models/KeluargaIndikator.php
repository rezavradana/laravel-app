<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluargaIndikator extends Model
{
    use HasFactory;
    protected $table = 'keluarga_indikator';
    protected $primaryKey = 'id_keluarga_indikator';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_keluarga_indikator','no_kk','id_indikator','nilai','tanggal_tambah','tanggal_update'];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'no_kk', 'no_kk');
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'id_indikator', 'id_indikator');
    }
}
