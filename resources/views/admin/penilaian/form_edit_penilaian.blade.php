@extends('layouts.admin')
@section('title', 'Form Edit Penilaian')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Edit Penilaian</h3>
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
                <div class="card-title">Edit Data Penilaian</div>
            </div>
            <form action="{{ route('penilaianIndikator.updatePenilaianIndikator', $penilaian_indikator->id_penilaian_indikator) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="id_indikator" hidden value="{{ $penilaian_indikator->id_indikator }}">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai Indikator</label>
                        <input type="number" class="form-control" id="nilai" placeholder="Masukkan Nilai..."
                            aria-label="nilai" aria-describedby="basic-addon1" name="nilai" required value="{{ $penilaian_indikator->nilai }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Penilaian</label>
                        <input type="text" class="form-control" id="deskripsi" placeholder="Masukkan Deskripsi..."
                            aria-label="deskripsi" aria-describedby="basic-addon1" name="deskripsi" required value="{{ $penilaian_indikator->deskripsi }}" />
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
