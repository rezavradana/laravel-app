@extends('layouts.admin')
@section('title', 'Form Tambah Keluarga')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Tambah Indikator</h3>
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
                <div class="card-title">Tambah Data Indikator</div>
            </div>
            <form action="{{ route('indikator.setIndikator') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Indikator</label>
                        <input type="text" class="form-control" id="kode" placeholder="Masukkan Kode..."
                            aria-label="kode" aria-describedby="basic-addon1" name="kode" required />
                    </div>
                    <div class="mb-3">
                        <label for="tipe_input" class="form-label">Tipe Input</label>
                        <select class="form-select" aria-label="Default select example" id="tipe_input" name="tipe_input" required>
                            <option selected>Open this select menu</option>
                            <option value="select">select</option>
                            <option value="number">number</option>
                            <option value="radio">radio</option>
                            <option value="none">none</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_input" class="form-label">Nama Input</label>
                        <input type="text" class="form-control" id="nama_input" placeholder="Masukkan nama input..."
                            aria-label="nama_input" aria-describedby="basic-addon1" name="nama_input" required />
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Indikator</label>
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
