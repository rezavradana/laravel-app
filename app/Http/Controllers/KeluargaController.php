<?php
namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use Illuminate\Http\Request;
use App\Models\Keluarga;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KeluargaController extends Controller
{
    public function getAllKeluarga(Request $request)
    {
        try {
            // Ambil query pencarian dari request
            $search = $request->input('search');

            // Query dasar
            $query = Keluarga::with(['anggotaKeluarga'])->orderBy('tanggal_update', 'desc');

            // Kalau ada pencarian, filter berdasarkan kolom
            if (!empty($search)) {
                $query->where('no_kk', 'like', "%{$search}%")
                    ->orWhereHas('anggotaKeluarga', function ($q) use ($search) {
                        $q->where('hubungan', 'Kepala Keluarga')
                          ->where('nama', 'like', "%{$search}%");
                    });
            }

            // Pagination
            $keluargas = $query->paginate(10);

            // Loop untuk tambahin nama kepala keluarga
            foreach ($keluargas as $keluarga) {
                $kepala = $keluarga->anggotaKeluarga->firstWhere('hubungan', 'Kepala Keluarga');
                $keluarga->nama_kepala_keluarga = $kepala ? $kepala->nama : null;
                
                $total_penghasilan = $keluarga->anggotaKeluarga->sum('penghasilan');
                $keluarga->total_penghasilan = $total_penghasilan;
            }

            // Return view
            return view('admin.keluarga.kelola_data_keluarga', compact('keluargas', 'search'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data keluarga: ' . $e->getMessage());
        }
    }

    public function formCreateKeluarga()
    {
        return view('admin.keluarga.form_tambah_keluarga');
    }

    public function setKeluarga(Request $request){
        $validated = $request->validate([
            'no_kk' => 'required|string|max:100|unique:keluarga',
            'alamat' => 'required|string|max:100',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
        ]);
        try {
            $rt = (string)$request['rt'];
            $rw = (string)$request['rw'];
            $validated['rt_rw'] = $rt . '/' . $rw;
            $validated['tanggal_tambah'] = TimeHelper::formatJakarta();
            $validated['tanggal_update'] = TimeHelper::formatJakarta();
            Keluarga::create($validated);
            return redirect()->route('keluarga.getAllKeluarga')->with('success', 'Data keluarga berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data keluarga: ' . $e->getMessage());
        }
    }

    public function getKeluargaByNoKK($no_kk){
        try {
            $keluargas = Keluarga::with(['anggotaKeluarga' => function($query) {
                $query->orderBy('tanggal_update', 'desc');
            }])->findOrFail($no_kk);
            $kepala_keluarga = $keluargas->anggotaKeluarga->firstWhere('hubungan', 'Kepala Keluarga');
            return view('admin.keluarga.detail_data_keluarga', compact('keluargas', 'kepala_keluarga'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('keluarga.getAllKeluarga')->with('error', 'Data keluarga tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data keluarga: ' . $e->getMessage());
        }
    }

    public function formEditKeluarga($no_kk)
    {
        try {
            $keluargas = Keluarga::where('no_kk', $no_kk)->first();
            $rt = null;
            $rw = null;
            
            if ($keluargas->rt_rw && strpos($keluargas->rt_rw, '/') !== false) {
                $parts = explode('/', $keluargas->rt_rw);
                $rt = $parts[0];
                $rw = count($parts) > 1 ? $parts[1] : null;
            }

            return view('admin.keluarga.form_edit_keluarga', compact('keluargas', 'rt', 'rw'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('keluarga.getAllKeluarga')->with('error', 'Data keluarga tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data keluarga: ' . $e->getMessage());
        }
    }

    public function updateKeluargaByNoKK(Request $request, $no_kk){
        $validated = $request->validate([
            'alamat' => 'required|string|max:100',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
        ]);

        try {
            $keluarga = Keluarga::findOrFail($no_kk);

            $rt = (string)$request['rt'];
            $rw = (string)$request['rw'];
            $validated['rt_rw'] = $rt . '/' . $rw;
            $validated['tanggal_update'] = TimeHelper::formatJakarta();
            
            $keluarga->update($validated);
            return redirect()->route('keluarga.getKeluargaByNoKK', $no_kk)->with('success', 'Data keluarga berhasil diperbarui');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data keluarga: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data keluarga: ' . $e->getMessage());
        }
    }

    public function deleteKeluargaByNoKK($no_kk){
        try {
            $keluarga = Keluarga::findOrFail($no_kk);
            $keluarga->delete();
             return redirect()->route('keluarga.getAllKeluarga')->with('success', 'Data keluarga berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data keluarga: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data keluarga: ' . $e->getMessage());
        }
    }
}
