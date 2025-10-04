@extends('layouts.admin')
@section('title', 'Kelola Data Prediksi')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Prediksi Kesejahteraan</h3>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card my-4">
            <div class="card-header">
                <h3 class="card-title">Tabel Data Prediksi</h3>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-start mx-3 mt-3">
                <div class="col-md-4">
                    <form class="d-flex" role="search" action="{{ route('prediksi.getAllPrediksi') }}" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Cari No. KK/Nama Kepala Keluarga..." aria-label="Search" name="search" />
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead> 
                        <tr>
                            <th>No KK</th>
                            <th>Nama Kepala Keluarga</th>
                            <th>Status Indikator</th>
                            <th>Jumlah Prediksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keluargas as $keluarga)
                            <tr class="align-middle">
                                <td>{{ $keluarga->no_kk }}</td>
                                <td>{{ $keluarga->nama_kepala_keluarga ?? '-' }}</td>
                                <td>{{ $keluarga->keluargaIndikator->count() ?? '-' }} dari {{ $total_indikator }}</td>
                                <td>{{ $keluarga->prediksi->count() ?? '-'}}</td>
                                <td class="col-1 max-width-100 text-center">
                                    <div class="btn-group">
                                        <a href="/prediksi/{{ $keluarga->no_kk }}" class="btn btn-success btn-sm" title="Detail Data Prediksi">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data keluarga tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-end">
                    {{ $keluargas->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
