@extends('layouts.admin')
@section('title', 'Kelola Data Keluarga Indikator')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Kelola Data Keluarga Indikator</h3>
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
                <h3 class="card-title">Tabel Data Indikator</h3>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between mx-3 mt-3">
                <div >
                    <a href="/kelola-data-indikator/tambah" type="button" class="btn btn-primary btn-md">Tambah Data</a>
                </div>
                <div class="col-md-4">
                    <form class="d-flex" role="search" action="{{ route('keluargaIndikator.getAllKeluargaIndikator') }}" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Cari Data..." aria-label="Search" name="search" />
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" style="white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Nama Kepala Keluarga</th>
                                <th>Total Penghasilan (A)</th>
                                <th>Jenjang Pendidikan Anak Tertinggi (B)</th>
                                @foreach($indikators as $indikator)
                                    @if($indikator->tipe_input !== 'none')
                                        <th>{{ $indikator->nama_input }} ({{ $indikator->kode }})</th>
                                    @endif
                                @endforeach
                                <th>Terakhir Diperbarui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>     
                            @forelse ($keluarga_indikators as $index => $keluarga_indikator)
                            <tr class="align-middle">
                                <td>{{ $keluarga_indikator['kepala_keluarga'] }}</td>
                                <td>Rp{{ number_format($keluarga_indikator['total_penghasilan'], 0, ',', '.') }}</td>
                                <td>{{ $keluarga_indikator['indikator']['B'] }}</td>

                                @foreach($indikators as $indikator)
                                    @if($indikator->tipe_input !== 'none')
                                        @php 
                                            $kode = $indikator->kode;
                                            $value = $keluarga_indikator['indikator'][$kode] ?? '-';
                                        @endphp
                                        @if($kode != 'A' && $kode != 'B')
                                            <td>{{ $value }}</td>
                                        @endif
                                    @endif
                                @endforeach

                                <td>{{ $keluarga_indikator['tanggal_update'] }}</td>
                                <td class="col-1 max-width-100 text-center">
                                    <div class="btn-group d-inline-flex justify-content-center gap-2">
                                        <a href="/kelola-data-indikator/{{ $keluarga_indikator['no_kk'] }}/edit" class="btn btn-primary btn-sm" title="Detail Data Indikator">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('keluargaIndikator.deleteKeluargaIndikatorByNoKK', $keluarga_indikator['no_kk']) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data keluarga ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data Keluarga Indikator">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="14" class="text-center">Tidak ada data indikator tersedia.</td>
                            </tr>
                            @endforelse                                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-end">
                    {{ $keluarga_indikators->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
