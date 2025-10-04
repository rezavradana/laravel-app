@extends('layouts.admin')
@section('title', 'Form Tambah Anggota Keluarga')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Tambah Anggota</h3>
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
@if($errors->has('no_kk'))
    <div class="alert alert-danger mx-4">
        {{ $errors->first('no_kk') }}
    </div>
@endif
<div class="app-content">
    <div class="container-fluid">
        <form action="{{ route('anggotaKeluarga.setAnggotaKeluarga', $no_kk) }}" method="POST">
            @csrf
            <div class="card card-success card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Tambah Anggota Keluarga</div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control" id="nik" placeholder="Masukkan NIK..."
                            aria-label="nik" aria-describedby="basic-addon1" name="nik" required/>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama..."
                            aria-label="nama" aria-describedby="basic-addon1" name="nama" required/>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" aria-label="tanggal_lahir"
                            aria-describedby="basic-addon1" name="tanggal_lahir" required/>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" aria-label="Default select example" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option selected>Open this select menu</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select class="form-select" aria-label="Default select example" id="agama" name="agama" required>
                            <option selected>Open this select menu</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                        <select class="form-select" aria-label="Default select example" id="pendidikan" name="pendidikan" required>
                            <option selected>Open this select menu</option>
                            <option value="0">Tidak Sekolah</option>
                            <option value="1">SD</option>
                            <option value="2">SMP</option>
                            <option value="3">SMA</option>
                            <option value="4">Perguruan Tinggi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" placeholder="Masukkan pekerjaan..." aria-label="pekerjaan"
                            aria-describedby="basic-addon1" name="pekerjaan" required/>
                    </div>
                    <div class="mb-3">
                        <label for="hubungan" class="form-label">Hubungan</label>
                        <select class="form-select" aria-label="Default select example" id="hubungan" name="hubungan" required>
                            <option selected>Open this select menu</option>
                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Menantu">Menantu</option>
                            <option value="Cucu">Cucu</option>
                            <option value="Orang Tua">Orang Tua</option>
                            <option value="Mertua">Mertua</option>
                            <option value="Famili Lain">Famili lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="penghasilan" class="form-label">Penghasilan</label>
                        <input type="number" class="form-control" id="penghasilan" placeholder="Masukkan Penghasilan..."
                            aria-label="penghasilan" aria-describedby="basic-addon1" name="penghasilan" required/>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
