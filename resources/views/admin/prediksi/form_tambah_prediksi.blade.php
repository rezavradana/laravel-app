@extends('layouts.admin')
@section('title', 'Form Edit Indikator')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Indikator Keluarga {{ $keluarga['kepala_keluarga'] }}</h3>
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
                <div class="card-title">Tabel Indikator Keluarga</div>
            </div>
            <form action="{{ route('prediksi.storePrediksi', $keluarga['no_kk']) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="jumlah_anggota_keluarga" class="form-label fw-bold">Jumlah Anggota Keluarga</label>
                        <input type="text" class="form-control" id="jumlah_anggota_keluarga"
                            aria-label="jumlah_anggota_keluarga" aria-describedby="basic-addon1" name="jumlah_anggota_keluarga" required style="pointer-events: none; background-color: #e9ecef;" value="{{ $keluarga['jumlah_anggota_keluarga'] }}"/>
                    </div>
                    
                    <div class="mb-3">
                        <label for="total_penghasilan" class="form-label fw-bold">Total Penghasilan Keluarga</label>
                        <input type="number" class="form-control" id="total_penghasilan" aria-label="total_penghasilan"
                            aria-describedby="basic-addon1" name="IND001" value="{{ $keluarga['total_penghasilan'] }}" style="pointer-events: none; background-color: #e9ecef;"/>
                    </div>

                    <div class="mb-3">
                        <label for="jenjang_pendidikan_tertinggi" class="form-label fw-bold">Jenjang Pendidikan Tertinggi Yang
                            Ditempuh Anak Di Dalam Keluarga</label>
                        <select class="form-select" aria-label="Default select example" id="jenjang_pendidikan_tertinggi" name="IND002" style="pointer-events: none; background-color: #e9ecef;">
                            <option>Open this select menu</option>
                            <option value="0" {{ $keluarga['pendidikan_tertinggi_anak'] == '0' ? 'selected' : '' }}>Tidak Sekolah</option>
                            <option value="1" {{ $keluarga['pendidikan_tertinggi_anak'] == '1' ? 'selected' : '' }}>SD</option>
                            <option value="2" {{ $keluarga['pendidikan_tertinggi_anak'] == '2' ? 'selected' : '' }}>SMP</option>
                            <option value="3" {{ $keluarga['pendidikan_tertinggi_anak'] == '3' ? 'selected' : '' }}>SMA</option>
                            <option value="4" {{ $keluarga['pendidikan_tertinggi_anak'] == '4' ? 'selected' : '' }}>Perguruan Tinggi</option>
                            <option value="5" {{ $keluarga['pendidikan_tertinggi_anak'] == '5' ? 'selected' : '' }}>Tidak ada anak/Sudah pisah Kartu Keluarga</option>
                        </select>
                    </div>

                    @foreach($keluarga['indikator'] as $kode => $data)
                        @switch($data['tipe_input'])
                            @case('select')
                                <div class="mb-3">
                                    <label for="{{ $data['id_indikator'] }}" class="form-label fw-bold">{{ $data['nama_input'] }}</label>
                                    <select name="{{ $data['id_indikator'] }}" id="{{ $data['id_indikator'] }}" class="form-select" required style="pointer-events: none; background-color: #e9ecef;">
                                        <option value="">Open this select menu</option>
                                        @foreach($options[$kode] as $option)
                                            <option value="{{ $option->nilai }}" {{ $data['nilai'] == $option->nilai ? 'selected' : '' }}>
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
                                                <input class="form-check-input" type="radio" 
                                                    name="{{ $data['id_indikator'] }}" 
                                                    id="{{ $data['id_indikator'] }}_{{ $loop->iteration }}" 
                                                    value="{{ $option->nilai }}" {{ $data['nilai'] == $option->nilai ? 'checked' : '' }}
                                                    required>
                                                <label class="form-check-label" for="{{ $data['id_indikator'] }}_{{ $loop->iteration }}">
                                                    {{ $option->deskripsi }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                                @break
                                
                            @case('number')
                                <div class="mb-3">
                                    <label for="{{ $data['id_indikator'] }}" class="form-label fw-bold">{{ $data['nama_input'] }}</label>
                                    <input type="number" name="{{ $data['id_indikator'] }}" 
                                        id="{{ $data['id_indikator'] }}" 
                                        class="form-control" 
                                        placeholder="Masukkan penilaian..." 
                                        required value="{{ $data['id_indikator'] == 'IND007' ? $keluarga['luas_lantai'] : '' }}" style="pointer-events: none; background-color: #e9ecef;">
                                </div>
                                @break
                        @endswitch
                    @endforeach
                        
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="bi bi-person-fill-gear"></i> Prediksi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('click', function(e) {
        e.preventDefault();
    });
    
    radio.addEventListener('mousedown', function(e) {
        e.preventDefault();
    });
    
    // Style untuk menunjukkan readonly
    radio.style.pointerEvents = 'none';
    radio.nextElementSibling.style.opacity = '0.7';
});
</script>
@endsection
