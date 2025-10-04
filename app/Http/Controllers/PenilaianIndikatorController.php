<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\PenilaianIndikator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PenilaianIndikatorController extends Controller
{
    public function getPenilaianIndikatorById($id_indikator) {
        try {
            $penilaian_indikator = PenilaianIndikator::where('id_indikator', $id_indikator)->get();
            return view('admin.indikator.detail_data_indikator', compact('penilaian_indikator', 'id_indikator'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data penilaian: ' . $e->getMessage()], 500);
        }
    }

    public function formCreatePenilaianIndikator($id_indikator) {
        return view('admin.penilaian.form_tambah_penilaian', compact('id_indikator'));
    }

    public function setPenilaianIndikator(Request $request, $id_indikator) {
        try {
            $validated = $request->validate([
                'nilai' => 'required|numeric',
                'deskripsi' => 'required|string',
            ]);

            $Indikator = Indikator::where('id_indikator', $id_indikator)
                ->select('kode')
                ->first();
            
            $id_penilaian_indikator = 'INDVAL'. $Indikator['kode'] . $validated['nilai'];
            $validated['id_penilaian_indikator'] = $id_penilaian_indikator;
            $validated['id_indikator'] = $id_indikator;
            
            PenilaianIndikator::create($validated);

            return redirect()->route('penilaianIndikator.getPenilaianIndikatorById', $id_indikator)->with('success', 'Data penilaian berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data penilaian: ' . $e->getMessage());
        }
    }

    public function formEditPenilaianIndikator($id_penilaian_indikator) {
        $penilaian_indikator = PenilaianIndikator::where('id_penilaian_indikator', $id_penilaian_indikator)->first();
        return view('admin.penilaian.form_edit_penilaian', compact('penilaian_indikator'));
    }

    public function updatePenilaianIndikator(Request $request, $id_penilaian_indikator) {
        try {
            $validated = $request->validate([
                'nilai' => 'required|numeric',
                'deskripsi' => 'required|string',
            ]);
            
            $penilaian_indikator = PenilaianIndikator::findOrFail($id_penilaian_indikator);
            $penilaian_indikator->update($validated);

            return redirect()->route('penilaianIndikator.getPenilaianIndikatorById', $request['id_indikator'])->with('success', 'Data penilaian berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data penilaian: ' . $e->getMessage());
        }
    }

    public function deletePenilaianIndikator(Request $request, $id_penilaian_indikator) {
        try {
            $penilaian_indikator = PenilaianIndikator::findOrFail($id_penilaian_indikator);
            $penilaian_indikator->delete();
            
            return redirect()->route('penilaianIndikator.getPenilaianIndikatorById', $request['id_indikator'])->with('success', 'Data penilaian berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Penilaian indikator tidak ditemukan: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data penilaian: ' . $e->getMessage());
        }
    }
}
