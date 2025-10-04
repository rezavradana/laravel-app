@extends('layouts.admin')
@section('title', 'Form Tambah Penilaian')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Tambah Penilaian</h3>
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
                <div class="card-title">Tambah Data Penilaian</div>
            </div>
            <form action="{{ route('penilaianIndikator.setPenilaianIndikator', $id_indikator) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai Indikator</label>
                        <input type="number" class="form-control" id="nilai" placeholder="Masukkan Nilai..."
                            aria-label="nilai" aria-describedby="basic-addon1" name="nilai" required />
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Penilaian</label>
                        <input type="text" class="form-control" id="deskripsi" placeholder="Masukkan Deskripsi..."
                            aria-label="deskripsi" aria-describedby="basic-addon1" name="deskripsi" required />
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
