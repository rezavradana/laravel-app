@extends('layouts.admin')
@section('title', 'Kelola Data Indikator')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Penilaian Indikator</h3>
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
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Tabel Data Penilaian Indikator {{ $id_indikator }}</h3>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between mx-3 mt-3">
                <div>
                    <a href="/penilaian-indikator/{{ $id_indikator }}/tambah" type="button" class="btn btn-primary btn-md">Tambah Data
                        Penilaian</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap">ID Penilaian Indikator</th>
                                <th>Nilai</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penilaian_indikator as $indikator)
                            <tr class="align-middle">
                                <td>{{ $indikator->id_penilaian_indikator }}</td>
                                <td>{{ $indikator->nilai }}</td>
                                <td style="min-width: 300px">{{ $indikator->deskripsi }}</td>
                                <td class="col-1 max-width-100 text-center">
                                    <div class="btn-group d-inline-flex justify-content-center gap-2">
                                        <a href="/penilaian-indikator/{{ $indikator->id_penilaian_indikator }}/edit"
                                            class="btn btn-primary btn-sm" title="Edit Data Penilaian">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form
                                            action="{{ route('penilaianIndikator.deletePenilaianIndikator', $indikator->id_penilaian_indikator) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penilaian ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" name="id_indikator" hidden value="{{ $penilaian_indikator[0]['id_indikator'] }}">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Hapus Data Penilaian">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Penilaian Indikator Tidak Ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
