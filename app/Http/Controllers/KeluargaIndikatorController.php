<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use App\Models\Indikator;
use Illuminate\Http\Request;
use App\Models\KeluargaIndikator;
use App\Models\Keluarga;
use App\Models\PenilaianIndikator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class KeluargaIndikatorController extends Controller
{
    public function getAllKeluargaIndikator(Request $request){
        try {
                $query = DB::table('keluarga_indikator as ki')
                ->join('keluarga as k', 'ki.no_kk', '=', 'k.no_kk')
                ->join('anggota_keluarga as ak', 'k.no_kk', '=', 'ak.no_kk')
                ->join('indikator as i', 'ki.id_indikator', '=', 'i.id_indikator')
                ->join('penilaian_indikator as pi', function($join) {
                    $join->on('i.id_indikator', '=', 'pi.id_indikator')
                         ->on('pi.nilai', '=', 'ki.nilai');
                })
                ->where('ak.hubungan', 'Kepala Keluarga')
                ->select(
                    'ki.no_kk',
                    'k.total_penghasilan',
                    'k.luas_lantai',
                    'ak.nama as kepala_keluarga',
                    'i.kode as kode_indikator',
                    'ki.tanggal_update as tanggal_update',
                    'pi.deskripsi as penilaian_deskripsi'
                );

            // Fitur pencarian
            if ($search = $request->query('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('ki.no_kk', 'like', '%' . $search . '%')
                      ->orWhere('ak.nama', 'like', '%' . $search . '%')
                      ->orWhere('k.total_penghasilan', 'like', '%' . $search . '%')
                      ->orWhere('k.luas_lantai', 'like', '%' . $search . '%');
                });
            }

            // Pengurutan berdasarkan tanggal_update
            $query->orderBy('ki.tanggal_update', 'desc');

            // Hitung jumlah grup no_kk unik
            $totalGroups = DB::table('keluarga_indikator as ki')
                ->join('keluarga as k', 'ki.no_kk', '=', 'k.no_kk')
                ->join('anggota_keluarga as ak', 'k.no_kk', '=', 'ak.no_kk')
                ->where('ak.hubungan', 'Kepala Keluarga')
                ->when($search, function ($q) use ($search) {
                    $q->where('ki.no_kk', 'like', '%' . $search . '%')
                      ->orWhere('ak.nama', 'like', '%' . $search . '%')
                      ->orWhere('k.total_penghasilan', 'like', '%' . $search . '%')
                      ->orWhere('k.luas_lantai', 'like', '%' . $search . '%');
                })
                ->distinct('ki.no_kk')
                ->count('ki.no_kk');

            // Ambil data dan proses
            $perPage = 10;
            $keluarga_indikators = $query->get()
                ->groupBy('no_kk')
                ->map(function ($items) {
                    $first = $items->first();
                    $itemIndex2 = $items->get(1);
                    return [
                        'no_kk' => $first->no_kk,
                        'total_penghasilan' => $first->total_penghasilan,
                        'luas_lantai' => $first->luas_lantai,
                        'kepala_keluarga' => $first->kepala_keluarga,
                        'tanggal_update' => $itemIndex2 ? $itemIndex2->tanggal_update : $first->tanggal_update,
                        'indikator' => $items->mapWithKeys(fn($i) => [$i->kode_indikator => $i->penilaian_deskripsi]),
                    ];
                })
                ->sortByDesc(function ($item) {
                    return $item['tanggal_update'];
                })
                ->forPage($request->query('page', 1), $perPage)
                ->values();

            // Buat pagination manual
            $keluarga_indikators = new \Illuminate\Pagination\LengthAwarePaginator(
                $keluarga_indikators,
                $totalGroups, // Gunakan jumlah grup no_kk unik
                $perPage,
                $request->query('page', 1),
                ['path' => $request->url(), 'query' => $request->query()]
            );

            $indikators = Indikator::where('tipe_input', '!=', 'none')->get();
            return view('admin.keluarga_indikator.kelola_data_keluarga_indikator', compact('keluarga_indikators', 'indikators'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data keluarga indikator: ' . $e->getMessage());
        }
    }

    public function formCreateKeluargaIndikator()
    {
        $keluargas = Keluarga::select('no_kk')->with(['anggotaKeluarga' => function ($query) {
                        $query->select('no_kk', 'nama', 'hubungan', 'pendidikan', 'penghasilan'); 
                    }])
                    ->get();
        $keluargas->map(function ($keluarga) {
            // Ambil nama kepala keluarga
            $kepala_keluarga = $keluarga->anggotaKeluarga->firstWhere('hubungan', 'Kepala Keluarga');
            // Hitung jumlah anggota keluarga
            $jumlah_anggota_keluarga = $keluarga->anggotaKeluarga->count();
            // Ambil pendidikan tertinggi anak
            $pendidikan_tertinggi_anak = $keluarga->anggotaKeluarga
                ->where('hubungan', 'Anak')
                ->max('pendidikan');
            
            $total_penghasilan = $keluarga->anggotaKeluarga->sum('penghasilan');

            $keluarga->setAttribute('nama_kepala_keluarga', $kepala_keluarga ? $kepala_keluarga->nama : null);
            $keluarga->setAttribute('jumlah_anggota_keluarga', $jumlah_anggota_keluarga);
            $keluarga->setAttribute('pendidikan_tertinggi_anak', $pendidikan_tertinggi_anak);
            $keluarga->setAttribute('total_penghasilan', $total_penghasilan);
            return $keluarga;
        });

        $indikators = Indikator::with('penilaianIndikator')->get();
        return view('admin.keluarga_indikator.form_tambah_keluarga_indikator', compact(['keluargas', 'indikators']));
    }

    public function setKeluargaIndikator(Request $request)
    {
        try {
            $no_kk = $request->input('no_kk');
            $exists = KeluargaIndikator::where('no_kk', $no_kk)->exists();
            if ($exists) {
                throw new \Exception('Keluarga dengan No KK ' . $no_kk . ' sudah memiliki indikator.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'no_kk' => $e->getMessage()
            ]);
        }

        $validated = $request->validate([   
            '*' => 'required',
        ]);

        $penghasilan_perkapita = $request->input('IND001') / $request->input('jumlah_anggota_keluarga');
        $IND001 = $penghasilan_perkapita <= 591933 ? '0' : '1';
        $luas_lantai = $request->input('IND007') / $request->input('jumlah_anggota_keluarga');
        $IND007 = $luas_lantai < 8 ? '0' : '1';
        
        $validated['IND001'] = $IND001;
        $validated['IND007'] = $IND007;
        unset($validated['jumlah_anggota_keluarga'], $validated['no_kk'], $validated['_token']);
        
        $dataToInsert = [];
        foreach ($validated as $id_indikator => $nilai) {
            $dataToInsert[] = [
                'id_keluarga_indikator' => uniqid('KIND-'),
                'no_kk' => $request->input('no_kk'),
                'id_indikator' => $id_indikator,
                'nilai' => $nilai,
                'tanggal_tambah' => TimeHelper::formatJakarta(),
                'tanggal_update' => TimeHelper::formatJakarta(),
            ];
        }
        
        try {
            $keluarga = Keluarga::findOrFail($request->input('no_kk'));
            $keluarga->update([
                'total_penghasilan' => $request->input('IND001'),
                'luas_lantai' => $request->input('IND007')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data keluarga indikator: ' . $e->getMessage());
        }

        try {
            KeluargaIndikator::insert($dataToInsert);
            return redirect()->route('keluargaIndikator.getAllKeluargaIndikator')->with('success', 'Data keluarga indikator berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data keluarga indikator: ' . $e->getMessage());
        }
    }

    public function formEditKeluargaIndikator($no_kk)
    {
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
                DB::raw('(SELECT COUNT(*) FROM anggota_keluarga WHERE no_kk = ki.no_kk) as jumlah_anggota_keluarga')
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

            $indikators = Indikator::where('tipe_input', '!=', 'none')->get();
            $options = [];
            foreach ($indikators as $data) {
                if (in_array($data['tipe_input'], ['select', 'radio'])) {
                    $options[$data['kode']] = PenilaianIndikator::where('id_indikator', $data['id_indikator'])->get();
                }
            }
            return view('admin.keluarga_indikator.form_edit_keluarga_indikator', compact(['keluarga', 'options', 'indikators']));
        } catch (\Exception $e) {
            return redirect()->route('keluargaIndikator.getAllKeluargaIndikator', $no_kk)->with('error', 'Gagal mengambil data keluarga indikator: ' . $e->getMessage());
        }
    }

    public function updateKeluargaIndikatorByNoKK(Request $request, $no_kk)
    {
        try {
            Keluarga::where('no_kk', $no_kk)->update([
                'total_penghasilan' => $request->IND001,
                'luas_lantai' => $request->IND007
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data keluarga indikator: ' . $e->getMessage());
        }

        $penghasilan_perkapita = $request->IND001/$request->jumlah_anggota_keluarga;
        $luas_lantai = $request->IND007/$request->jumlah_anggota_keluarga;
        $IND001 = $penghasilan_perkapita <= 591933 ? '0' : '1';
        $IND007 = $luas_lantai < 8 ? '0' : '1';

        $indikator = $request->except(['_token', '_method', 'jumlah_anggota_keluarga']);
        $indikator['IND001'] = $IND001;
        $indikator['IND007'] = $IND007;

        try {
            foreach ($indikator as $id_indikator => $nilai) {
                $data = KeluargaIndikator::firstOrNew([
                    'no_kk' => $no_kk,
                    'id_indikator' => $id_indikator,
                ]);

                if (!$data->exists) {
                    $data->id_keluarga_indikator = uniqid('KIND-');
                    $data->tanggal_tambah = TimeHelper::formatJakarta();
                }

                $data->nilai = $nilai;
                $data->tanggal_update = TimeHelper::formatJakarta();
                $data->save();
            }
            return redirect()->route('keluargaIndikator.getAllKeluargaIndikator')->with('success', 'Data keluarga berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data keluarga indikator: ' . $e->getMessage());
        }
    }

    public function deleteKeluargaIndikatorByNoKK($no_kk)
    {
        try {
            KeluargaIndikator::where('no_kk', $no_kk)->delete();
            return redirect()->route('keluargaIndikator.getAllKeluargaIndikator')->with('success', 'Data keluarga berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data keluarga indikator: ' . $e->getMessage());
        }
    }
}
