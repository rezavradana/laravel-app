@extends('layouts.admin')
@section('title', 'Detail Data Prediksi')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Prediksi {{ $kepala_keluarga }}</h3>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@if(session('success'))
<div class="alert alert-success mx-4">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger mx-4">
    {{ session('error') }}
</div>
@endif
<div class="app-content">
    <div class="container-fluid">
        <div class="card my-4">
            <div class="card-header">
                <h3 class="card-title">Tabel Data Prediksi</h3>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-start mx-3 mt-3">
                <div>
                    <a href="/prediksi/{{ $no_kk }}/tambah" type="button" class="btn btn-primary btn-md">Tambah Data
                        Prediksi</a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Prediksi</th>
                            <th>Hasil Prediksi</th>
                            <th>Probabilitas</th>
                            <th>Tanggal Prediksi</th>
                            <th>Diprediksi Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prediksi as $pred)                      
                        <tr class="align-middle">
                            <td>{{ $pred->id_prediksi }}</td>
                            <td>
                                <span class="badge text-bg-{{ $pred->hasil_prediksi == 'Miskin' ? 'danger' : 'success' }} fs-7">{{ $pred->hasil_prediksi }}</span>
                            </td>
                            <td>{{ $pred->probabilitas }}</td>
                            <td>{{ $pred->tanggal_prediksi }}</td>
                            <td>{{ $pred->users->nama ?? 'N/A' }} | {{ $pred->users->role ?? 'N/A' }}</td>
                            <td class="col-1 max-width-100 text-center">
                                <div class="btn-group d-flex gap-2 justify-content-center">
                                    <a href="/riwayat-indikator/{{ $pred->id_prediksi }}" class="btn btn-success btn-sm" title="Detail Data Indikator">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <form
                                        action="{{ route('prediksi.deletePrediksi', $pred->id_prediksi) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data indikator ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="text" hidden value="{{ $no_kk }}" name="no_kk">
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus Data Prediksi">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data prediksi tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-end">
                    {{-- {{ $keluargas->links('pagination::bootstrap-4') }} --}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
