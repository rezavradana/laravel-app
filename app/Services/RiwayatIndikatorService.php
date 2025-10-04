<?php
// app/Services/RiwayatIndikatorService.php

namespace App\Services;

use App\Helpers\TimeHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RiwayatIndikatorService
{
    public function simpanMultipleIndikator($data, $idPrediksi)
    {
        $jumlahAnggota = (int)($data['jumlah_anggota_keluarga'] ?? 0);
        
        $batchData = [];
        
        foreach ($data as $key => $value) {
            if (preg_match('/^IND[A-Z0-9]{3}$/', $key)) {
                $jsonValue = $this->formatNilaiJson($key, (int)$value, $jumlahAnggota);
                
                $batchData[] = [
                    'id_riwayat_indikator' => uniqid('RKIND-'),
                    'id_prediksi' => $idPrediksi,
                    'id_indikator' => $key,
                    'nilai' => json_encode($jsonValue),
                    'tanggal_tambah' => TimeHelper::formatJakarta(),
                ];
            }
        }
        
        if (!empty($batchData)) {
            DB::table('riwayat_indikator')->insert($batchData);
        }
        
        return count($batchData);
    }
    
    private function formatNilaiJson($idIndikator, $nilai, $jumlahAnggota)
    {
        // Mapping khusus untuk IND001 dan IND007
        if ($idIndikator === 'IND001') {
            return ['penghasilan' => $nilai, 'jumlah_anggota' => $jumlahAnggota];
        }
        
        if ($idIndikator === 'IND007') {
            return ['luas_lantai' => $nilai, 'jumlah_anggota' => $jumlahAnggota];
        }
        
        // Untuk semua indikator lainnya, gunakan format standar
        return ['nilai_indikator' => $nilai];
    }
}