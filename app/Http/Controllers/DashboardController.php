<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $jumlah_warga = AnggotaKeluarga::count();
        $jumlah_keluarga = Keluarga::count();
        $jumlah_prediksi = Prediksi::count();
        
        $prediksi_terbaru = Prediksi::with([
                'keluarga', // Relasi ke model Keluarga
                'keluarga.anggotaKeluarga' => function($query) {
                    $query->where('hubungan', 'Kepala Keluarga')
                        ->select('no_kk', 'nama'); // Hambil data yang diperlukan
                }
            ])
            ->latest('tanggal_prediksi')
            ->take(5)
            ->get();

        $hasil_prediksi_terbaru = Prediksi::select('p.hasil_prediksi')
            ->from(DB::raw('(SELECT no_kk, MAX(tanggal_prediksi) as latest_date 
                            FROM prediksi 
                            GROUP BY no_kk) as latest'))
            ->join('prediksi as p', function($join) {
                $join->on('p.no_kk', '=', 'latest.no_kk')
                    ->on('p.tanggal_prediksi', '=', 'latest.latest_date');
            })
            ->get();

        $jumlah_hasil_prediksi = $hasil_prediksi_terbaru->groupBy('hasil_prediksi')->map->count();

        $data_dashboard = [
            'jumlah_warga' => $jumlah_warga, 
            'jumlah_keluarga' => $jumlah_keluarga, 
            'jumlah_prediksi' => $jumlah_prediksi, 
            'prediksi_terbaru' => $prediksi_terbaru,
            'jumlah_hasil_prediksi' => $jumlah_hasil_prediksi,
        ];
        
        return view('admin.dashboard', compact('data_dashboard'));
    }
}
