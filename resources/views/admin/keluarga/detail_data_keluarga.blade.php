@extends('layouts.admin')
@section('title', 'Detail Data Keluarga')
@section('content')
<div class="app-content-header">
    @if(session('success'))
    <div class="alert alert-success mx-4">
        {{ session('success') }}
    </div>
    @endif
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Data Keluarga</h3>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-6">
                <div class="mt-2">
                    <span class="kk-label">Nama Kepala Keluarga: </span>
                    <span>{{ $kepala_keluarga->nama ?? '-' }}</span>
                </div>
                <div class="mt-2">
                    <span class="kk-label">Alamat: </span>
                    <span>{{ $keluargas->alamat }}</span>
                </div>
                <div class="mt-2">
                    <span class="kk-label">RT/RW: </span>
                    <span>{{ $keluargas->rt_rw }}</span>
                </div>
                <div class="mt-2">
                    <span class="kk-label">Desa/Kelurahan: </span>
                    <span>{{ $keluargas->desa_kelurahan }}</span>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <div>
                    <div class="mt-2">
                        <span class="kk-label">Kecamatan: </span>
                        <span>{{ $keluargas->kecamatan }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="kk-label">Kabupaten/Kota: </span>
                        <span>{{ $keluargas->kabupaten_kota }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="kk-label">Kode Pos: </span>
                        <span>{{ $keluargas->kode_pos }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="kk-label">Provinsi: </span>
                        <span>{{ $keluargas->provinsi }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Tabel Data Keluarga</h3>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2 mx-3 mt-3">
                <div>
                    <a href="/anggota-keluarga/{{ $keluargas->no_kk }}/tambah" type="button"
                        class="btn btn-primary btn-md">Tambah Anggota
                        Keluarga</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Agama</th>
                                <th>Pendidikan</th>
                                <th>Pekerjaan</th>
                                <th>Hubungan</th>
                                <th>Penghasilan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keluargas->anggotaKeluarga as $anggota)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $anggota->nik ?? '-' }}</td>
                                <td>{{ $anggota->nama ?? '-' }}</td>
                                <td>{{ $anggota->tanggal_lahir ?? '-' }}</td>
                                <td>{{ $anggota->jenis_kelamin ?? '-' }}</td>
                                <td>{{ $anggota->agama ?? '-' }}</td>
                                <td>{{ $anggota->pendidikan_label ?? '-' }}</td>
                                <td>{{ $anggota->pekerjaan ?? '-' }}</td>
                                <td>{{ $anggota->hubungan ?? '-' }}</td>
                                <td>Rp{{ number_format($anggota['penghasilan'], 0, ',', '.') }}</td>
                                <td class="col-1 max-width-100 text-center">
                                    <div class="btn-group d-inline-flex justify-content-center gap-2">
                                        <a href="/anggota-keluarga/{{ $anggota->nik }}/edit"
                                            class="btn btn-primary btn-sm" title="Edit Data Anggota">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('anggotaKeluarga.deleteAnggotaKeluargaByNik', [$anggota->nik, $keluargas->no_kk]) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Hapus Data Anggota">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada data anggota keluarga tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-end">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
