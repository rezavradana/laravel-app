@extends('layouts.admin')
@section('title', 'Form Edit User')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Edit User</h3>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@if ($errors->any())
    <div class="alert alert-danger mx-4">
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
                <div class="card-title">Edit Data User</div>
            </div>
            <form action="{{ route('user.update', $user->username) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password"
                            placeholder="Masukkan password baru..." aria-label="password"
                            aria-describedby="passwordHelp" name="password" />
                        <div id="passwordHelp" class="form-text text-muted">
                            <i class="bi bi-info-circle"></i> Kosongkan jika tidak ingin mengubah password. Minimal 8
                            karakter.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan nama..."
                            aria-label="nama" aria-describedby="basic-addon1" name="nama" required value="{{ $user->nama }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role User</label>
                        <select class="form-select" aria-label="Default select example" id="role" name="role" required>
                            <option selected value="">Open this select menu</option>
                            <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="RT" {{ old('role', $user->role) == 'RT' ? 'selected' : '' }}>RT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email baru..."
                            aria-label="email" aria-describedby="basic-addon1" name="email" />
                        <div id="passwordHelp" class="form-text text-muted">
                            <i class="bi bi-info-circle"></i> Kosongkan jika tidak ingin mengubah email.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon</label>
                        <input type="number" class="form-control" id="no_telepon" placeholder="Masukkan no_telepon..."
                            aria-label="no_telepon" aria-describedby="basic-addon1" name="no_telepon" value="{{ $user->no_telepon }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status">
                            <option selected value="">Open this select menu</option>
                            <option value="Aktif" {{ old('status', $user->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $user->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                        <input type="number" class="form-control" id="tahun_mulai" placeholder="Masukkan tahun mulai..."
                            aria-label="tahun_mulai" aria-describedby="basic-addon1" name="tahun_mulai" value="{{ $user->tahun_mulai }}" />
                    </div>
                    <div class="mb-3">
                        <label for="tahun_selesai" class="form-label">Tahun Selesai</label>
                        <input type="number" class="form-control" id="tahun_selesai" placeholder="Masukkan tahun selesai..."
                            aria-label="tahun_selesai" aria-describedby="basic-addon1" name="tahun_selesai" value="{{ $user->tahun_selesai }}"/>
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
