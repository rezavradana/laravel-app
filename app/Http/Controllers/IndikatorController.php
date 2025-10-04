<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\PenilaianIndikator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class IndikatorController extends Controller
{
    public function getAllIndikator()
    {
        try {
            $indikators = Indikator::with('keluargaIndikator')->get();
            return view('admin.indikator.kelola_data_indikator', ['indikators' => $indikators]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data indikator: ' . $e->getMessage()], 500);
        }
    }

    public function formCreateIndikator() {
        return view('admin.indikator.form_tambah_indikator');
    }

    public function setIndikator(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode' => 'required|string|max:100|unique:indikator,kode',
                'tipe_input' => 'required|string',
                'nama_input' => 'required|string',
                'deskripsi' => 'required|string',
            ]);

            $unique = strtoupper(substr(uniqid(), -3));
            $validated['id_indikator'] = 'IND'.$unique;
            Indikator::create($validated);

            return redirect()->route('indikator.getAllIndikator')->with('success', 'Data indikator berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data indikator: ' . $e->getMessage());
        }
    }

    public function getIndikatorById($id_indikator)
    {
        try {
            $penilaian_indikator = PenilaianIndikator::where('id_indikator', $id_indikator)->get();
            return view('admin.indikator.detail_data_indikator', ['penilaian_indikator' => $penilaian_indikator]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data indikator: ' . $e->getMessage()], 500);
        }
    }

    public function formEditIndikator($id_indikator) {
        $indikator = Indikator::where('id_indikator', $id_indikator)->first();
        return view('admin.indikator.form_edit_indikator', compact('indikator'));
    }

    public function updateIndikatorById(Request $request, $id_indikator)
    {
        try {
            $validated = $request->validate([
                'kode' => 'sometimes|string|max:100',
                'tipe_input' => 'sometimes|string',
                'nama_input' => 'sometimes|string',
                'deskripsi' => 'sometimes|string',
            ]);

            $indikator = Indikator::findOrFail($id_indikator);
            $indikator->update($validated);

            return redirect()->route('indikator.getAllIndikator')->with('success', 'Data indikator berhasil diperbarui');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data indikator tidak ditemukan: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data indikator: ' . $e->getMessage());
        }
    }

    public function deleteIndikatorById($id_indikator)
    {
        try {
            $indikator = Indikator::findOrFail($id_indikator);
            $indikator->delete();
            return redirect()->route('indikator.getAllIndikator')->with('success', 'Data indikator berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data indikator tidak ditemukan: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data indikator: ' . $e->getMessage());
        }
    }
}