@extends('layouts.admin')
@section('title', 'Form Tambah User')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Tambah User</h3>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <h5><i class="bi bi-exclamation-triangle"></i> Terdapat kesalahan:</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="app-content">
    <div class="container-fluid">
        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Tambah Data User</div>
            </div>
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan username..."
                            aria-label="username" aria-describedby="basic-addon1" name="username" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" placeholder="Password minimal 8 karakter..."
                            aria-label="password" aria-describedby="basic-addon1" name="password" required />
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan nama..."
                            aria-label="nama" aria-describedby="basic-addon1" name="nama" required />
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role User</label>
                        <select class="form-select" aria-label="Default select example" id="role" name="role" required>
                            <option selected>Open this select menu</option>
                            <option value="Admin">Admin</option>
                            <option value="RT">RT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email..."
                            aria-label="email" aria-describedby="basic-addon1" name="email"/>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon</label>
                        <input type="number" class="form-control" id="no_telepon" placeholder="Masukkan no_telepon..."
                            aria-label="no_telepon" aria-describedby="basic-addon1" name="no_telepon" />
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status">
                            <option selected value="">Open this select menu</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                        <input type="number" class="form-control" id="tahun_mulai" placeholder="Masukkan tahun mulai..."
                            aria-label="tahun_mulai" aria-describedby="basic-addon1" name="tahun_mulai" />
                    </div>
                    <div class="mb-3">
                        <label for="tahun_selesai" class="form-label">Tahun Selesai</label>
                        <input type="number" class="form-control" id="tahun_selesai" placeholder="Masukkan tahun selesai..."
                            aria-label="tahun_selesai" aria-describedby="basic-addon1" name="tahun_selesai" />
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
