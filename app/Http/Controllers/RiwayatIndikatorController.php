<?php

namespace App\Http\Controllers;

use App\Models\PenilaianIndikator;
use App\Models\RiwayatIndikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatIndikatorController extends Controller
{
    public function processDataManual($dataArray) {
        $result = [];
        $processedIndikators = [];
        
        foreach ($dataArray as $item) {
            $idIndikator = $item->id_indikator;
            
            // Skip jika sudah diproses (khusus IND001 dan IND007)
            if (in_array($idIndikator, ['IND001', 'IND007']) && 
                in_array($idIndikator, $processedIndikators)) {
                continue;
            }
            
            $decodedNilai = json_decode($item->nilai_riwayat, true);
            
            if ($idIndikator === 'IND001') {
                $result['IND001'] = [
                    'id_riwayat_indikator' => $item->id_riwayat_indikator,
                    'id_prediksi' => $item->id_prediksi,
                    'penghasilan' => $decodedNilai['penghasilan'],
                    'jumlah_anggota' => $decodedNilai['jumlah_anggota'],
                    'tipe_input' => $item->tipe_input,
                    'nama_input' => $item->nama_input,
                ];
                $processedIndikators[] = 'IND001';
                
            } elseif ($idIndikator === 'IND007') {
                $result['IND007'] = [
                    'id_riwayat_indikator' => $item->id_riwayat_indikator,
                    'id_prediksi' => $item->id_prediksi,
                    'luas_lantai' => $decodedNilai['luas_lantai'],
                    'tipe_input' => $item->tipe_input,
                    'nama_input' => $item->nama_input,
                ];
                $processedIndikators[] = 'IND007';
                
            } else {
                // Untuk indikator lainnya, hanya ambil yang nilai match
                if ($decodedNilai['nilai_indikator'] == $item->nilai_penilaian) {
                    $result[$idIndikator] = [
                        'id_riwayat_indikator' => $item->id_riwayat_indikator,
                        'id_prediksi' => $item->id_prediksi,
                        'id_prediksi' => $item->id_prediksi,
                        'nilai_indikator' => $decodedNilai['nilai_indikator'],
                        'nilai_penilaian' => $item->nilai_penilaian,
                        'tipe_input' => $item->tipe_input,
                        'nama_input' => $item->nama_input,
                        'deskripsi' => $item->deskripsi
                    ];
                }
            }
        }
        
        return $result;
    }

public function show($id_prediksi) {
    try {
        $dataArray = DB::table('riwayat_indikator as ri')
            ->join('penilaian_indikator as pi', 'ri.id_indikator', '=', 'pi.id_indikator')
            ->join('indikator as i', 'ri.id_indikator', '=', 'i.id_indikator')
            ->where('ri.id_prediksi', $id_prediksi)
            ->where(function($query) {
                $query->whereNotIn('ri.id_indikator', ['IND001', 'IND007'])
                      ->whereRaw('JSON_EXTRACT(ri.nilai, "$.nilai_indikator") = pi.nilai');
            })
            ->orWhere(function($query) use ($id_prediksi) {
                $query->whereIn('ri.id_indikator', ['IND001', 'IND007'])
                      ->where('ri.id_prediksi', $id_prediksi);
            })
            ->select(
                'ri.id_riwayat_indikator',
                'ri.id_prediksi',
                'ri.id_indikator',
                'ri.nilai as nilai_riwayat',
                'pi.nilai as nilai_penilaian',
                'pi.deskripsi as deskripsi',
                'i.tipe_input as tipe_input',
                'i.nama_input as nama_input',
                'ri.tanggal_tambah'
            )
            ->get();
           
           $riwayatIndikator = $this->processDataManual($dataArray);

            $options = [];
            foreach ($riwayatIndikator as $id_indikator => $data) {
                if (in_array($data['tipe_input'], ['select', 'radio'])) {
                    $options[$id_indikator] = PenilaianIndikator::where('id_indikator', $id_indikator)->get();
                }
            }

            
            // $datas = [];
            // foreach ($riwayatIndikator as $id_indikator => $data) {
            //     if($data['tipe_input'] !== 'none' && $data['tipe_input'] !== 'number'){
            //         foreach ($options[$id_indikator] as $option) {
            //             $datas[] = $option['nilai'];
            //         }
            //     }

            // }

            // return $datas;
            // return response($riwayatIndikator);
           return view('admin.prediksi.data_riwayat_indikator', compact(['riwayatIndikator', 'options']));
        } catch (\Exception $e) {
            return response($e);
            // return redirect()->route('', $no_kk)->with('error', 'Gagal mengambil data keluarga indikator: ' . $e->getMessage());
        }
    }
}
