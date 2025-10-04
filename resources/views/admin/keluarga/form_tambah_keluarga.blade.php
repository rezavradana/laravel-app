@extends('layouts.admin')
@section('title', 'Form Tambah Keluarga')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Tambah Keluarga</h3>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@if(session('error'))
<div class="alert alert-danger mx-4">
    {{ session('error') }}
</div>
@endif
<div class="app-content">
    <div class="container-fluid">
        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Tambah Data Keluarga</div>
            </div>
            <form action="{{ route('keluarga.setKeluarga') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="no_kk" class="form-label">No. Kartu Keluarga</label>
                        <input type="number" class="form-control" id="no_kk" placeholder="Masukkan No.Kartu Keluarga..."
                            aria-label="no_kk" aria-describedby="basic-addon1" name="no_kk" required />
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat..."
                            aria-label="alamat" aria-describedby="basic-addon1" name="alamat" required />
                    </div>
                    <div class="mb-3">
                        <label for="rt" class="form-label">RT/RW</label>
                        <div class="input-group" style="max-width: 180px;">
                            <input type="number" class="form-control" id="rt" placeholder="RT..." name="rt"
                                min="1" max="999" required />
                            <span class="input-group-text bg-light">/</span>
                            <input type="number" class="form-control" id="rw" placeholder="RW..." name="rw"
                                min="1" max="999" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="desa_kelurahan" class="form-label">Desa/Kelurahan</label>
                        <input type="text" class="form-control" id="desa_kelurahan"
                            placeholder="Masukkan Desa/Kelurahan..." aria-label="desa_kelurahan"
                            aria-describedby="basic-addon1" name="desa_kelurahan" required />
                    </div>
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" id="kecamatan" placeholder="Masukkan Kecamatan..."
                            aria-label="kecamatan" aria-describedby="basic-addon1" name="kecamatan" required />
                    </div>
                    <div class="mb-3">
                        <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                        <input type="text" class="form-control" id="kabupaten_kota"
                            placeholder="Masukkan Kabupaten/Kota..." aria-label="kabupaten_kota"
                            aria-describedby="basic-addon1" name="kabupaten_kota" required />
                    </div>
                    <div class="mb-3">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="number" class="form-control" id="kode_pos" placeholder="Masukkan Kode Pos..."
                            aria-label="kode_pos" aria-describedby="basic-addon1" name="kode_pos" required />
                    </div>
                    <div class="mb-3">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="provinsi" placeholder="Masukkan Provinsi..."
                            aria-label="provinsi" aria-describedby="basic-addon1" name="provinsi" required />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
