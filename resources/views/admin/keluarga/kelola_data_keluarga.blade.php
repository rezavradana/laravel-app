@extends('layouts.admin')
@section('title', 'Kelola Data Keluarga')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Kelola Data Keluarga</h3>
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
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Tabel Data Keluarga</h3>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between mx-3 mt-3">
                <div>
                    <a href="/kelola-data-keluarga/tambah" type="button" class="btn btn-primary btn-md">Tambah Data
                        Keluarga</a>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('keluarga.getAllKeluarga') }}" method="GET" class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Cari No. KK/Nama Kepala Keluarga..." aria-label="Search" name="search" value="{{ $search ? $search : '' }}" />
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. KK</th>
                            <th>Nama Kepala Keluarga</th>
                            <th>Jumlah Anggota Keluarga</th>
                            <th>Total Penghasilan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keluargas as $keluarga)
                        <tr class="align-middle">
                            <td>{{ $keluarga->no_kk }}</td>
                            <td>{{ $keluarga->nama_kepala_keluarga ?? '-' }}</td>
                            <td>{{ $keluarga->anggotaKeluarga->count() }}</td>
                            <td>Rp{{ number_format($keluarga->total_penghasilan, 0, ',', '.') ?? '0' }}</td>
                            <td class="col-1 max-width-100 text-center">
                                <div class="btn-group d-inline-flex justify-content-center gap-2">
                                    <a href="/kelola-data-keluarga/{{ $keluarga->no_kk }}"
                                        class="btn btn-success btn-sm" title="Detail Data Keluarga">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="/kelola-data-keluarga/{{ $keluarga->no_kk }}/edit"
                                        class="btn btn-primary btn-sm" title="Edit Data Keluarga">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form
                                        action="{{ route('keluarga.deleteKeluargaByNoKK', ['no_kk' => $keluarga->no_kk]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data keluarga ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data Keluarga">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
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
