<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use Illuminate\Http\Request;
use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
use App\Models\KeluargaIndikator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnggotaKeluargaController extends Controller
{
    public function getAllAnggotaKeluarga()
    {
        try {
            $anggota = AnggotaKeluarga::with('keluarga')->get();
            return response()->json($anggota, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data anggota keluarga: ' . $e->getMessage()], 500);
        }
    }

    public function formCreateAnggotaKeluarga($no_kk)
    {
        return view('admin.anggota.form_tambah_anggota', compact('no_kk'));
    }

    public function setAnggotaKeluarga(Request $request, $no_kk)
    {
        // cek kepala keluarga
        try {
            $exists = AnggotaKeluarga::where('no_kk', $no_kk)
                ->where('hubungan', 'Kepala Keluarga')    
                ->exists();
            if ($exists && $request->hubungan === 'Kepala Keluarga') {
                throw new \Exception('Keluarga dengan No KK ' . $no_kk . ' sudah memiliki Kepala Keluarga.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'no_kk' => $e->getMessage()
            ]);
        }
        
        $validated = $request->validate([
            'nik' => 'required|string|max:100|unique:anggota_keluarga',
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|string|max:100',
            'jenis_kelamin' => 'required|string|max:100',
            'agama' => 'required|string|max:100',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'hubungan' => 'required|string|max:100',
            'penghasilan' => 'required|numeric|min:0',
        ]);

        try {
            // create data anggota baru
            $validated['no_kk'] = $no_kk;
            $validated['tanggal_tambah'] = TimeHelper::formatJakarta();
            $validated['tanggal_update'] = TimeHelper::formatJakarta();
            AnggotaKeluarga::create($validated);

            // update setelah tambah data anggota ke indikator pendidikan
            $pendidikan_tertinggi_anak = AnggotaKeluarga::where('no_kk', $no_kk)
                ->where('hubungan', 'Anak')
                ->max('pendidikan');

            if ($pendidikan_tertinggi_anak) {
                KeluargaIndikator::where('no_kk', $no_kk)
                    ->where('id_indikator', 'IND002')
                    ->update([
                        'nilai' => $pendidikan_tertinggi_anak,
                        'tanggal_update' => TimeHelper::formatJakarta()
                    ]);
            }

            // update total penghasilan
            $totalPenghasilan = AnggotaKeluarga::where('no_kk', $no_kk)->sum('penghasilan');
            Keluarga::where('no_kk', $no_kk)
                ->update([
                    'total_penghasilan' => $totalPenghasilan,
                ]);

            return redirect()->route('keluarga.getKeluargaByNoKK', $no_kk)->with('success', 'Data anggota berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data anggota: ' . $e->getMessage());
        }
    }

    public function getAnggotaKeluargaByNik($nik)
    {
        try {
            $anggota = AnggotaKeluarga::with('keluarga')->findOrFail($nik);
            return response()->json($anggota, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data anggota keluarga tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data anggota keluarga: ' . $e->getMessage()], 500);
        }
    }

    public function formEditAnggotaKeluarga($nik)
    {
        try {
            $anggota = AnggotaKeluarga::with('keluarga')->findOrFail($nik);
            return view('admin.anggota.form_edit_anggota', compact('anggota'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('anggotaKeluarga.getAllAnggotaKeluarga')->with('error', 'Data anggota keluarga tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data anggota keluarga: ' . $e->getMessage());
        }
    }

    public function updateAnggotaKeluargaByNik(Request $request, $nik)
    {
        // cek kepala keluarga
        try {
            $no_kk = $request->no_kk;
            $exists = AnggotaKeluarga::where('no_kk', $no_kk)
                ->where('hubungan', 'Kepala Keluarga')  
                ->where('nik', '!=', $nik)  
                ->exists();
            if ($exists && $request->hubungan === 'Kepala Keluarga') {
                throw new \Exception('Keluarga dengan No KK ' . $no_kk . ' sudah memiliki Kepala Keluarga.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'no_kk' => $e->getMessage()
            ]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|string|max:100',
            'jenis_kelamin' => 'required|string|max:100',
            'agama' => 'required|string|max:100',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'hubungan' => 'required|string|max:100',
            'penghasilan' => 'required|numeric|min:0',
        ]);

        try {
            // update anggota keluarga dengan NIK
            $anggota = AnggotaKeluarga::with('keluarga')->findOrFail($nik);
            $validated['tanggal_update'] = TimeHelper::formatJakarta();
            $anggota->update($validated);
            
            $no_kk = $anggota->keluarga->no_kk;

            // update setelah perubahan data anggota ke indikator pendidikan
            $pendidikan_tertinggi_anak = AnggotaKeluarga::where('no_kk', $no_kk)
                ->where('hubungan', 'Anak')
                ->max('pendidikan');

            if ($pendidikan_tertinggi_anak) {
                KeluargaIndikator::where('no_kk', $no_kk)
                    ->where('id_indikator', 'IND002')
                    ->update([
                        'nilai' => $pendidikan_tertinggi_anak,
                        'tanggal_update' => TimeHelper::formatJakarta()
                    ]);
            }

            // update total penghasilan
            $totalPenghasilan = AnggotaKeluarga::where('no_kk', $no_kk)->sum('penghasilan');
            Keluarga::where('no_kk', $no_kk)
                ->update([
                    'total_penghasilan' => $totalPenghasilan,
                ]);

            return redirect()->route('keluarga.getKeluargaByNoKK', $no_kk)->with('success', 'Data anggota berhasil diperbarui');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data anggota keluarga: ' . $e->getMessage());
        } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Gagal mengupdate data anggota keluarga: ' . $e->getMessage());
        }
    }

    public function deleteAnggotaKeluargaByNik($nik, $no_kk)
    {
        try {
            $anggota = AnggotaKeluarga::findOrFail($nik);
            $anggota->delete();

            // update setelah hapus data anggota ke indikator pendidikan
            $pendidikan_tertinggi_anak = AnggotaKeluarga::where('no_kk', $no_kk)
                ->where('hubungan', 'Anak')
                ->max('pendidikan');

            if ($pendidikan_tertinggi_anak) {
                KeluargaIndikator::where('no_kk', $no_kk)
                    ->where('id_indikator', 'IND002')
                    ->update([
                        'nilai' => $pendidikan_tertinggi_anak,
                        'tanggal_update' => TimeHelper::formatJakarta()
                    ]);
            }

            // update total penghasilan
            $totalPenghasilan = AnggotaKeluarga::where('no_kk', $no_kk)->sum('penghasilan');
            Keluarga::where('no_kk', $no_kk)
                ->update([
                    'total_penghasilan' => $totalPenghasilan,
                ]);

            return redirect()->route('keluarga.getKeluargaByNoKK', $no_kk)->with('success', 'Data anggota berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data anggota keluarga: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data anggota keluarga: ' . $e->getMessage());
        }
    }
}
