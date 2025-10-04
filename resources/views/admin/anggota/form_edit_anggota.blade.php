@extends('layouts.admin')
@section('title', 'Form Edit Anggota Keluarga')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Edit Anggota</h3>
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
        <form action="{{ route('anggotaKeluarga.updateAnggotaKeluargaByNik', $anggota->nik) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card card-success card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Edit Anggota Keluarga</div>
                </div>
                <input type="text" name="no_kk" value="{{ $anggota->no_kk }}" hidden>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input required type="text" class="form-control" id="nama" placeholder="Masukkan Nama..."
                            aria-label="nama" aria-describedby="basic-addon1" name="nama"
                            value="{{ $anggota->nama }}" />
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input required type="date" class="form-control" id="tanggal_lahir" aria-label="tanggal_lahir"
                            aria-describedby="basic-addon1" name="tanggal_lahir"
                            value="{{ $anggota->tanggal_lahir }}" />
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" aria-label="Default select example" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option disabled>Open this select menu</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select class="form-select" aria-label="Default select example" id="agama" name="agama" required>
                            <option disabled>Open this select menu</option>
                            <option value="Islam" {{ old('agama', $anggota->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $anggota->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $anggota->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $anggota->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Budha" {{ old('agama', $anggota->agama) == 'Budha' ? 'selected' : '' }}>Budha</option>
                            <option value="Konghucu" {{ old('agama', $anggota->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                        <select required class="form-select" aria-label="Default select example" id="pendidikan"
                            name="pendidikan">
                            <option disabled>Open this select menu</option>
                            <option value="0" {{ old('pendidikan', $anggota->pendidikan) == 0 ? 'selected' : '' }}>Tidak Sekolah</option>
                            <option value="1" {{ old('pendidikan', $anggota->pendidikan) == 1 ? 'selected' : '' }}>SD</option>
                            <option value="2" {{ old('pendidikan', $anggota->pendidikan) == 2 ? 'selected' : '' }}>SMP</option>
                            <option value="3" {{ old('pendidikan', $anggota->pendidikan) == 3 ? 'selected' : '' }}>SMA</option>
                            <option value="4" {{ old('pendidikan', $anggota->pendidikan) == 4 ? 'selected' : '' }}>Perguruan Tinggi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input required type="text" class="form-control" id="pekerjaan" placeholder="Masukkan pekerjaan..."
                            aria-label="pekerjaan" aria-describedby="basic-addon1" name="pekerjaan" value={{ $anggota->pekerjaan }} />
                    </div>
                    <div class="mb-3">
                        <label for="hubungan" class="form-label">Hubungan</label>
                        <select required class="form-select" aria-label="Default select example" id="hubungan" name="hubungan">
                            <option disabled>Open this select menu</option>
                            <option value="Kepala Keluarga" {{ $anggota->hubungan == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Suami" {{ old('hubungan', $anggota->hubungan) == 'Suami' ? 'selected' : '' }}>Suami</option>
                            <option value="Istri" {{ old('hubungan', $anggota->hubungan) == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('hubungan', $anggota->hubungan) == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Menantu" {{ old('hubungan', $anggota->hubungan) == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                            <option value="Cucu" {{ old('hubungan', $anggota->hubungan) == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                            <option value="Orang Tua" {{ old('hubungan', $anggota->hubungan) == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="Mertua" {{ old('hubungan', $anggota->hubungan) == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                            <option value="Famili Lain" {{ old('hubungan', $anggota->hubungan) == 'Famili Lain' ? 'selected' : '' }}>Famili lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="penghasilan" class="form-label">Penghasilan</label>
                        <input type="number" class="form-control" id="penghasilan" placeholder="Masukkan Penghasilan..."
                            aria-label="penghasilan" aria-describedby="basic-addon1" name="penghasilan" required value="{{ $anggota->penghasilan }}"/>
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
