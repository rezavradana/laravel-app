<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\KeluargaIndikator;
use App\Models\Prediksi;
use App\Services\PredictionService;
use App\Services\RiwayatIndikatorService;
use App\Helpers\TimeHelper;
use App\Models\Indikator;
use App\Models\PenilaianIndikator;
use App\Models\RiwayatIndikator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PrediksiController extends Controller
{
    protected $predictionService;
    protected $riwayatService;
    
    public function __construct(PredictionService $predictionService, RiwayatIndikatorService $riwayatService)
    {
        $this->predictionService = $predictionService;
        $this->riwayatService = $riwayatService;
    }

    private function transformData($databaseData) {
        $mapping = [
            'IND001' => 'Penghasilan',
            'IND002' => 'Pendidikan',
            'IND003' => 'Dinding',
            'IND004' => 'Lantai',
            'IND005' => 'Atap',
            'IND006' => 'Listrik',
            'IND007' => 'Luas_lantai_rumah',
            'IND008' => 'Air_Minum',
            'IND009' => 'Makanan',
            'IND010' => 'Kesehatan',
            'IND011' => 'Pakaian'
        ];
        
        $transformedData = [];
        
        foreach ($databaseData as $item) {
            $indikator = $item['id_indikator'];
            if (isset($mapping[$indikator])) {
                $fieldName = $mapping[$indikator];
                $transformedData[$fieldName] = (int) $item['nilai'];
            }
        }
        
        return $transformedData;
    }

    public function predictSingle(Request $request){
        // Validasi input
        $validator = Validator::make($request->all(), [
            'Penghasilan' => 'required|integer|between:0,1',
            'Pendidikan' => 'required|integer|between:0,4',
            'Dinding' => 'required|integer|between:0,4',
            'Lantai' => 'required|integer|between:0,4',
            'Atap' => 'required|integer|between:0,4',
            'Listrik' => 'required|integer|between:0,4',
            'Luas_lantai_rumah' => 'required|integer|between:0,1',
            'Air_Minum' => 'required|integer|between:0,4',
            'Makanan' => 'required|integer|between:0,4',
            'Kesehatan' => 'required|integer|between:0,4',
            'Pakaian' => 'required|integer|between:0,4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Panggil service untuk prediksi
        $result = $this->predictionService->predictSingle($request->all());

        return response()->json($result);
    }

    public function exampleRequest(){
        return response()->json([
            'example_request' => [
                'Penghasilan' => 1,
                'Pendidikan' => 2,
                'Dinding' => 1,
                'Lantai' => 1,
                'Atap' => 1,
                'Listrik' => 1,
                'Luas_lantai_rumah' => 0,
                'Air_Minum' => 1,
                'Makanan' => 1,
                'Kesehatan' => 1,
                'Pakaian' => 1
            ]
        ]);
    }

    public function getAllPrediksi(Request $request){
        try {
            $search = $request->input('search');
            $query = Keluarga::with(['anggotaKeluarga', 'keluargaIndikator', 'prediksi'])
                ->orderBy('tanggal_update', 'desc');

            if (!empty($search)) {
                $query->where('no_kk', 'like', "%{$search}%")
                    ->orWhereHas('anggotaKeluarga', function ($q) use ($search) {
                        $q->where('hubungan', 'Kepala Keluarga')
                          ->where('nama', 'like', "%{$search}%");
                    });
            }

            $keluargas = $query->paginate(10);

            foreach ($keluargas as $keluarga) {
                $kepala = $keluarga->anggotaKeluarga->firstWhere('hubungan', 'Kepala Keluarga');
                $keluarga->nama_kepala_keluarga = $kepala ? $kepala->nama : null;
            }

            $total_indikator = Indikator::count();
            return view('admin.prediksi.kelola_data_prediksi', compact(['keluargas', 'total_indikator']));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data prediksi: ' . $e->getMessage());
        }
    }

    public function getPrediksiByNoKK($no_kk) {
        $prediksi = Prediksi::with(['users'])
                    ->where('no_kk', $no_kk)
                    ->orderBy('tanggal_prediksi', 'desc')->get();
        $kepala_keluarga = Keluarga::with(['anggotaKeluarga'])->find($no_kk)
                            ->anggotaKeluarga->firstWhere('hubungan', 'Kepala Keluarga')->nama ?? null;
        return view('admin.prediksi.detail_data_prediksi', compact('prediksi', 'no_kk', 'kepala_keluarga'));
    }

    public function formCreatePrediksi($no_kk) {
        try {
            $data = DB::table('keluarga_indikator as ki')
            ->join('keluarga as k', 'ki.no_kk', '=', 'k.no_kk')
            ->join('anggota_keluarga as ak', 'k.no_kk', '=', 'ak.no_kk')
            ->join('indikator as i', 'ki.id_indikator', '=', 'i.id_indikator')
            ->join('penilaian_indikator as pi', function($join) {
                $join->on('i.id_indikator', '=', 'pi.id_indikator')
                     ->on('pi.nilai', '=', 'ki.nilai');
            })
            ->where('ak.hubungan', 'Kepala Keluarga')
            ->where('ki.no_kk', $no_kk)
            ->select(
                'ki.id_keluarga_indikator',
                'ki.no_kk',
                'k.total_penghasilan',
                'k.luas_lantai',
                'ak.nama as kepala_keluarga',
                'i.id_indikator as id_indikator',
                'i.kode as kode_indikator',
                'i.tipe_input as tipe_input',
                'i.nama_input as nama_input',
                'pi.nilai as penilaian_nilai',
                'pi.deskripsi as penilaian_deskripsi',
                DB::raw('(SELECT COUNT(*) FROM anggota_keluarga WHERE no_kk = ki.no_kk) as jumlah_anggota_keluarga'),
                DB::raw('(SELECT IFNULL(MAX(pendidikan), 5) FROM anggota_keluarga WHERE no_kk = ki.no_kk AND hubungan = "Anak") as pendidikan_tertinggi_anak')
            )
            ->get();

            // group jadi satu array per keluarga
            $keluarga = $data->groupBy('no_kk')->map(function($items) {
                $first = $items->first();
                return [
                    'no_kk' => $first->no_kk,
                    'total_penghasilan' => $first->total_penghasilan,
                    'luas_lantai' => $first->luas_lantai,
                    'kepala_keluarga' => $first->kepala_keluarga,
                    'jumlah_anggota_keluarga' => $first->jumlah_anggota_keluarga,
                    'pendidikan_tertinggi_anak' => $first->pendidikan_tertinggi_anak,
                    'indikator' => $items->mapWithKeys(fn($i) => [
                        $i->kode_indikator => [
                            'id_keluarga_indikator' => $i->id_keluarga_indikator,
                            'id_indikator' => $i->id_indikator,
                            'nilai' => $i->penilaian_nilai,
                            'tipe_input' => $i->tipe_input,
                            'nama_input' => $i->nama_input,
                            'deskripsi' => $i->penilaian_deskripsi
                        ]
                    ]),
                ];
            })->first();

            if($keluarga == null) {
                throw new Exception('Indikator Keluarga Tidak Tersedia!');
            }

            $options = [];
            foreach ($keluarga['indikator'] as $kode => $data) {
                if (in_array($data['tipe_input'], ['select', 'radio'])) {
                    $options[$kode] = PenilaianIndikator::where('id_indikator', $data['id_indikator'])->get();
                }
            }

            return view('admin.prediksi.form_tambah_prediksi', compact(['keluarga', 'options']));
        } catch (\Exception $e) {
            return redirect()->route('prediksi.getPrediksiByNoKK', $no_kk)->with('error', 'Gagal mengambil data keluarga indikator: ' . $e->getMessage());
        }
    }

    public function storePrediksi(Request $request, $no_kk) {
        $keluarga_indikator = KeluargaIndikator::where('no_kk', $no_kk)
            ->whereIn('id_indikator', [
                'IND001', 
                'IND002', 
                'IND003', 
                'IND004', 
                'IND005', 
                'IND006', 
                'IND007', 
                'IND008', 
                'IND009', 
                'IND010', 
                'IND011'
            ])
            ->get();
        
        $transformedData = $this->transformData($keluarga_indikator);
        
        // Pastikan semua field required ada
        $requiredFields = [
            'Penghasilan', 'Pendidikan', 'Dinding', 'Lantai', 'Atap',
            'Listrik', 'Luas_lantai_rumah', 'Air_Minum', 'Makanan',
            'Kesehatan', 'Pakaian'
        ];
        
        $missingFields = array_diff($requiredFields, array_keys($transformedData));
        
        if (!empty($missingFields)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing required fields',
                'missing_fields' => array_values($missingFields)
            ], 422);
        }
        try{
            $result = $this->predictionService->predictSingle($transformedData);
            if($result['status'] === 'error') {
                throw new Exception($result['error_message']);
            }
            
            $user = request()->user();
            $resultPrediksi = [
                'id_prediksi' => uniqid('predict-'),
                'no_kk' => $no_kk,
                'username' => $user['username'],
                'hasil_prediksi' => $result['prediction_label'],
                'probabilitas' => $result['confidence'],
                'tanggal_prediksi' => TimeHelper::formatJakarta()
            ];

            Prediksi::create($resultPrediksi);

            $validated = $request->validate([
                '*' => 'required',
            ]);
            unset($validated['_token']);
            
            $idPrediksi = $resultPrediksi['id_prediksi'];
            $this->riwayatService->simpanMultipleIndikator(
                $validated, 
                $idPrediksi
            );

            return redirect()->route('prediksi.getPrediksiByNoKK', $no_kk)->with('success', 'Prediksi Berhasil Diproses');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal prediksi keluarga: ' . $e->getMessage());
        }
    }

    public function deletePrediksi(Request $request, $id_prediksi) {
        try {
            Prediksi::where('id_prediksi', $id_prediksi)->delete();
            return redirect()->route('prediksi.getPrediksiByNoKK', $request['no_kk'])->with('success', 'Data prediksi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data prediksi: ' . $e->getMessage());
        }
    }
}
