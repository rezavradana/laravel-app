@extends('layouts.admin')
@section('title', 'Form Edit Indikator')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Edit Keluarga Indikator</h3>
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
                <div class="card-title">Edit Data Keluarga Indikator</div>
            </div>
            <form action="{{ route('keluargaIndikator.updateKeluargaIndikatorByNoKK', $keluarga['no_kk']) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <input type="hidden" name="jumlah_anggota_keluarga"
                        value="{{ $keluarga['jumlah_anggota_keluarga'] }}">
                    <input type="hidden" name="IND001" value="{{ $keluarga['total_penghasilan'] }}">
                    <input type="hidden" name="IND002" value="{{ $keluarga['indikator']['B']['nilai'] }}">

                    @foreach($indikators as $indikator)
                        @php
                            $kode = $indikator->kode;
                            $data = $keluarga['indikator'][$kode] ?? [
                            'id_indikator' => $indikator->id_indikator,
                            'nama_input' => $indikator->nama_input,
                            'tipe_input' => $indikator->tipe_input,
                            'nilai' => ''
                            ];
                        @endphp

                        @switch($data['tipe_input'])
                            @case('select')
                            <div class="mb-3">
                                <label for="{{ $data['id_indikator'] }}"
                                    class="form-label fw-bold">{{ $data['nama_input'] }}</label>
                                <select name="{{ $data['id_indikator'] }}" id="{{ $data['id_indikator'] }}" class="form-select"
                                    required>
                                    <option value="">Pilih salah satu</option>
                                    @foreach($options[$kode] as $option)
                                    <option value="{{ $option->nilai }}"
                                        {{ $data['nilai'] == $option->nilai ? 'selected' : '' }}>
                                        {{ $option->deskripsi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @break

                            @case('radio')
                            <fieldset class="row mb-3">
                                <legend class="col-form-label fw-bold">{{ $data['nama_input'] }}</legend>
                                <div class="col-sm-10 gap-3 d-flex flex-column">
                                    @foreach($options[$kode] as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{ $data['id_indikator'] }}"
                                            id="{{ $data['id_indikator'] }}_{{ $loop->iteration }}" value="{{ $option->nilai }}"
                                            {{ $data['nilai'] == $option->nilai ? 'checked' : '' }} required>
                                        <label class="form-check-label"
                                            for="{{ $data['id_indikator'] }}_{{ $loop->iteration }}">
                                            {{ $option->deskripsi }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </fieldset>
                            @break

                            @case('number')
                            <div class="mb-3">
                                <label for="{{ $data['id_indikator'] }}"
                                    class="form-label fw-bold">{{ $data['nama_input'] }}</label>
                                <input type="number" name="{{ $data['id_indikator'] }}" id="{{ $data['id_indikator'] }}"
                                    class="form-control" placeholder="Masukkan nilai..." required
                                    value="{{ $data['id_indikator'] == 'IND007' ? $keluarga['luas_lantai'] : '' }}">
                            </div>
                            @break
                        @endswitch
                    @endforeach

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
