@extends('layouts.admin')
@section('title', 'Form Tambah Keluarga')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Edit Indikator</h3>
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
                <div class="card-title">Tambah Edit Indikator</div>
            </div>
            <form action="{{ route('indikator.updateIndikatorById', $indikator->id_indikator) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Indikator</label>
                        <input type="text" class="form-control" id="kode" placeholder="Masukkan Kode..."
                            aria-label="kode" aria-describedby="basic-addon1" name="kode" required value="{{ $indikator->kode }}"/>
                    </div>
                     <div class="mb-3">
                        <label for="tipe_input" class="form-label">Tipe Input</label>
                        <select class="form-select" aria-label="Default select example" id="tipe_input" name="tipe_input" required>
                            <option disabled>Open this select menu</option>
                            <option value="select" {{ old('tipe_input', $indikator->tipe_input) == 'select' ? 'selected' : '' }}>select</option>
                            <option value="number" {{ old('tipe_input', $indikator->tipe_input) == 'number' ? 'selected' : '' }}>number</option>
                            <option value="radio" {{ old('tipe_input', $indikator->tipe_input) == 'radio' ? 'selected' : '' }}>radio</option>
                            <option value="none" {{ old('tipe_input', $indikator->tipe_input) == 'none' ? 'selected' : '' }}>none</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_input" class="form-label">Nama Input</label>
                        <input type="text" class="form-control" id="nama_input" placeholder="Masukkan nama input..."
                            aria-label="nama_input" aria-describedby="basic-addon1" name="nama_input" required value="{{ $indikator->nama_input }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Indikator</label>
                        <input type="text" class="form-control" id="deskripsi" placeholder="Masukkan Deskripsi..."
                            aria-label="deskripsi" aria-describedby="basic-addon1" name="deskripsi" required value="{{ $indikator->deskripsi }}"/>
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
