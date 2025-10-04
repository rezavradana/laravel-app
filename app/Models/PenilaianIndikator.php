<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIndikator extends Model
{
    use HasFactory;
    protected $table = 'penilaian_indikator';
    protected $primaryKey = 'id_penilaian_indikator';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = ['id_penilaian_indikator','id_indikator', 'nilai', 'deskripsi'];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'id_indikator', 'id_indikator');
    }
}
