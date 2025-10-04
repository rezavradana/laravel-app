@extends('layouts.admin')
@section('title', 'Kelola Data User')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Kelola Data User</h3>
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
@if ($errors->any())
    <div class="alert alert-danger mx-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Tabel Data User</h3>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between mx-3 mt-3">
                <div>
                    <a href="/user/create" type="button" class="btn btn-primary btn-md">Tambah Data
                        User</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Tahun Mulai</th>
                            <th>Tahun Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr class="align-middle">
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->role ?? '-' }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>{{ $user->no_telepon ?? '-' }}</td>
                            <td>{{ $user->status ?? '-' }}</td>
                            <td>{{ $user->tahun_mulai ?? '-' }}</td>
                            <td>{{ $user->tahun_selesai ?? '-' }}</td>
                            <td class="col-1 max-width-100 text-center">
                                <div class="btn-group d-inline-flex justify-content-center gap-2">
                                    <a href="/user/{{ $user->username }}/edit"
                                        class="btn btn-primary btn-sm" title="Edit Data User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form
                                        action="{{ route('user.destroy', $user->username) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data User">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data keluarga tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
