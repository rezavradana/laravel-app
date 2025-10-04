@extends('layouts.admin')
@section('title', 'Form Tambah Indikator')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Form Tambah Keluarga Indikator</h3>
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
        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Tambah Data Keluarga Indikator</div>
            </div>
            <form action="{{ route('keluargaIndikator.setKeluargaIndikator') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_kepala_keluarga" class="form-label fw-bold">Nama Kepala Keluarga</label>
                        <select class="form-select" aria-label="Default select example" id="nama_kepala_keluarga" name="no_kk" required>
                            <option selected>Open this select menu</option>
                            @forelse ($keluargas as $keluarga)
                                <option value="{{ $keluarga->no_kk }}" 
                                        data-anggota="{{ $keluarga->jumlah_anggota_keluarga }}"
                                        data-pendidikan="{{ $keluarga->pendidikan_tertinggi_anak }}"
                                        data-totalPenghasilan="{{ $keluarga->total_penghasilan }}" >
                                    {{ $keluarga->nama_kepala_keluarga ?? 'N/A  ' }} - {{ $keluarga->no_kk }}
                                </option>
                            @empty
                                <option value="">Tidak ada data keluarga tersedia</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_anggota_keluarga" class="form-label fw-bold">Jumlah Anggota Keluarga</label>
                        <input type="text" class="form-control" id="jumlah_anggota_keluarga"
                            aria-label="jumlah_anggota_keluarga" aria-describedby="basic-addon1" name="jumlah_anggota_keluarga" required style="pointer-events: none; background-color: #e9ecef;"/>
                    </div>
                    <div class="mb-3">
                        <label for="total_penghasilan" class="form-label fw-bold">Total Penghasilan Keluarga</label>
                        <input type="number" class="form-control" id="total_penghasilan" aria-label="total_penghasilan"
                            aria-describedby="basic-addon1" name="IND001" required 
                            style="pointer-events: none; background-color: #e9ecef;"/>
                    </div>
                    <div class="mb-3">
                        <label for="jenjang_pendidikan_tertinggi" class="form-label fw-bold">Jenjang Pendidikan Tertinggi Yang
                            Ditempuh Anak Di Dalam Keluarga</label>
                        <select class="form-select" aria-label="Default select example" id="jenjang_pendidikan_tertinggi" name="IND002" style="pointer-events: none; background-color: #e9ecef;">
                            <option selected>Open this select menu</option>
                            <option value="0">Tidak Sekolah</option>
                            <option value="1">SD</option>
                            <option value="2">SMP</option>
                            <option value="3">SMA</option>
                            <option value="4">Perguruan Tinggi</option>
                            <option value="5">Tidak ada anak/Sudah pisah Kartu Keluarga</option>
                        </select>
                    </div>

                    {{-- <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Kondisi Dinding Rumah</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND003" id="dinding_rumah_1"
                                    value="0" required />
                                <label class="form-check-label" for="dinding_rumah_1"> Dinding dari bambu/kayu/tembok dengan kondisi tidak baik/berkualitas rendah </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND003" id="dinding_rumah_2"
                                    value="1" />
                                <label class="form-check-label" for="dinding_rumah_2"> Dinding dari tembok yang sudah usang/berlumut </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND003" id="dinding_rumah_3"
                                    value="2" />
                                <label class="form-check-label" for="dinding_rumah_3"> Dinding dari tembok tidak diplester </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND003" id="dinding_rumah_4"
                                    value="3" />
                                <label class="form-check-label" for="dinding_rumah_4"> Dinding dari bambu/kayu dengan kondisi baik/berkualitas tinggi </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND003" id="dinding_rumah_5"
                                    value="4" />
                                <label class="form-check-label" for="dinding_rumah_5"> Dinding dari tembok diplester, dicat, dan dalam kondisi prima </label>
                            </div>
                        </div>
                    </fieldset>
    
                    <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Kondisi Lantai Rumah</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND004" id="lantai_rumah_1"
                                    value="0" required />
                                <label class="form-check-label" for="lantai_rumah_1"> Tanah tanpa pelapis kondisi tidak baik/berkualitas rendah </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND004" id="lantai_rumah_2"
                                    value="1" />
                                <label class="form-check-label" for="lantai_rumah_2"> Kayu/semen dengan kondisi tidak baik/berkualitas rendah </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND004" id="lantai_rumah_3"
                                    value="2" />
                                <label class="form-check-label" for="lantai_rumah_3"> Keramik dengan kondisi tidak baik/berkualitas rendah </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND004" id="lantai_rumah_4"
                                    value="3" />
                                <label class="form-check-label" for="lantai_rumah_4"> Keramik dengan kondisi baik dan stabil </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND004" id="lantai_rumah_5"
                                    value="4" />
                                <label class="form-check-label" for="lantai_rumah_5"> Marmer/granit </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Kondisi Atap Rumah</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND005" id="atap_rumah_1"
                                    value="0" required />
                                <label class="form-check-label" for="atap_rumah_1"> Atap dari ijuk/rumbia dengan kondisi tidak baik/berkualitas rendah </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND005" id="atap_rumah_2"
                                    value="1" />
                                <label class="form-check-label" for="atap_rumah_2"> Atap dari seng/asbes dengan kondisi tidak baik/berkualitas rendah </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND005" id="atap_rumah_3"
                                    value="2" />
                                <label class="form-check-label" for="atap_rumah_3"> Atap dari genteng dengan kondisi tidak baik/berkualitas rendah </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND005" id="atap_rumah_4"
                                    value="3" />
                                <label class="form-check-label" for="atap_rumah_4"> Atap dari genteng/seng/asbes dengan kondisi baik dan stabil </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND005" id="atap_rumah_5"
                                    value="4" />
                                <label class="form-check-label" for="atap_rumah_5"> Atap dari material premium seperti genteng metal/beton </label>
                            </div>
                        </div>
                    </fieldset>
    
                    <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Penerangan Bangunan Tempat Tinggal</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND006" id="penerangan_bangunan_1"
                                    value="0" required />
                                <label class="form-check-label" for="penerangan_bangunan_1"> Tidak ada penerangan listrik, hanya menggunakan lampu minyak/lilin </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND006" id="penerangan_bangunan_2"
                                    value="1" />
                                <label class="form-check-label" for="penerangan_bangunan_2"> Menggunakan listrik tanpa meteran/melalui sambungan ilegal/tidak resmi </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND006" id="penerangan_bangunan_3"
                                    value="2" />
                                <label class="form-check-label" for="penerangan_bangunan_3"> Menggunakan listrik genset/diesel </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND006" id="penerangan_bangunan_4"
                                    value="3" />
                                <label class="form-check-label" for="penerangan_bangunan_4"> Menggunakan listrik dengan meteran daya 450-900VA </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND006" id="penerangan_bangunan_5"
                                    value="4" />
                                <label class="form-check-label" for="penerangan_bangunan_5"> Menggunakan listrik dengan meteran daya >900VA </label>
                            </div>
                        </div>
                    </fieldset>
    
                    <div class="mb-3">
                        <label for="luas_lantai" class="form-label fw-bold">Luas Lantai Rumah (M<sup>2</sup>)</label>
                        <input type="number" class="form-control" id="luas_lantai" aria-label="luas_lantai"
                            aria-describedby="basic-addon1" name="IND007" required />
                    </div>
    
                    <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Sumber Air Minum</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND008" id="air_minum_1"
                                    value="0" required />
                                <label class="form-check-label" for="air_minum_1"> Mata air tak terlindungi/air sungai/air hujan </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND008" id="air_minum_2"
                                    value="1" />
                                <label class="form-check-label" for="air_minum_2"> Sumur tak terlindung </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND008" id="air_minum_3"
                                    value="2" />
                                <label class="form-check-label" for="air_minum_3"> Air mesin bor pompa </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND008" id="air_minum_4"
                                    value="3" />
                                <label class="form-check-label" for="air_minum_4"> Air PDAM </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND008" id="air_minum_5"
                                    value="4" />
                                <label class="form-check-label" for="air_minum_5"> Air isi ulang/kemasan </label>
                            </div>
                        </div>
                    </fieldset>
    
                    <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Pengeluaran Untuk Makanan Pokok</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND009" id="pengeluaran_makanan_1"
                                    value="0" required />
                                <label class="form-check-label" for="pengeluaran_makanan_1"> > 90% </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND009" id="pengeluaran_makanan_2"
                                    value="1" />
                                <label class="form-check-label" for="pengeluaran_makanan_2"> 70% - < 90% </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND009" id="pengeluaran_makanan_3"
                                    value="2" />
                                <label class="form-check-label" for="pengeluaran_makanan_3"> 50% - < 70% </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND009" id="pengeluaran_makanan_4"
                                    value="3" />
                                <label class="form-check-label" for="pengeluaran_makanan_4"> 30% - < 50% </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND009" id="pengeluaran_makanan_5"
                                    value="4" />
                                <label class="form-check-label" for="pengeluaran_makanan_5"> < 30% </label>
                            </div>
                        </div>
                    </fieldset>
    
                    <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Akses Kesehatan Keluarga</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND010" id="akses_kesehatan_1"
                                    value="0" required />
                                <label class="form-check-label" for="akses_kesehatan_1"> Tidak mampu berobat sama sekali, bahkan ke puskesmas </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND010" id="akses_kesehatan_2"
                                    value="1" />
                                <label class="form-check-label" for="akses_kesehatan_2"> Hanya mampu berobat ke puskesmas atau layanan bersubsidi dengan kesulitan </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND010" id="akses_kesehatan_3"
                                    value="2" />
                                <label class="form-check-label" for="akses_kesehatan_3"> Mampu berobat ke puskesmas atau layanan bersubsidi </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND010" id="akses_kesehatan_4"
                                    value="3" />
                                <label class="form-check-label" for="akses_kesehatan_4"> Mampu berobat ke tenaga medis berbayar </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND010" id="akses_kesehatan_5"
                                    value="4" />
                                <label class="form-check-label" for="akses_kesehatan_5"> Selalu mampu berobat ke dokter/klinik swasta berkualitas tinggi </label>
                            </div>
                        </div>
                    </fieldset>
    
                    <fieldset class="row mb-4">
                        <legend class="col-form-label fw-bold">Kemampuan Membeli Pakaian</legend>
                        <div class="col-sm-10 gap-3 d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND011" id="membeli_pakaian_1"
                                    value="0" required />
                                <label class="form-check-label" for="membeli_pakaian_1"> Tidak mampu membeli pakaian baru sama sekali untuk semua anggota </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND011" id="membeli_pakaian_2"
                                    value="1" />
                                <label class="form-check-label" for="membeli_pakaian_2"> Hanya mampu membeli pakaian bekas untuk beberapa anggota </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND011" id="membeli_pakaian_3"
                                    value="2" />
                                <label class="form-check-label" for="membeli_pakaian_3"> Mampu membeli pakaian baru minimal sekali setahun untuk sebagian anggota </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND011" id="membeli_pakaian_4"
                                    value="3" />
                                <label class="form-check-label" for="membeli_pakaian_4"> Mampu membeli pakaian baru sekali setahun untuk semua anggota </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="IND011" id="membeli_pakaian_5"
                                    value="4" />
                                <label class="form-check-label" for="membeli_pakaian_5"> Mampu membeli pakaian baru lebih dari sekali setahun dengan kualitas baik </label>
                            </div>
                        </div>
                    </fieldset> --}}
                    

                    @foreach($indikators as $indikator)
                        @switch($indikator->tipe_input)
                            @case('select')
                                <div class="mb-3">
                                    <label for="{{ $indikator->id_indikator }}" class="form-label fw-bold">{{ $indikator->nama_input }}</label>
                                    <select name="{{ $indikator->id_indikator }}" id="{{ $indikator->id_indikator }}" class="form-select" required>
                                        <option value="">Open this select menu</option>
                                        @foreach($indikator->penilaianIndikator as $penilaian)
                                            <option value="{{ $penilaian->nilai }}">
                                                {{ $penilaian->deskripsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @break
                                
                            @case('radio')
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label fw-bold">{{ $indikator->nama_input }}</legend>
                                    <div class="col-sm-10 gap-3 d-flex flex-column">
                                        @foreach($indikator->penilaianIndikator as $penilaian)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                    name="{{ $indikator->id_indikator }}" 
                                                    id="{{ $indikator->id_indikator }}_{{ $loop->iteration }}" 
                                                    value="{{ $penilaian->nilai }}" required>
                                                <label class="form-check-label" for="{{ $indikator->id_indikator }}_{{ $loop->iteration }}">
                                                    {{ $penilaian->deskripsi }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                                @break
                                
                            @case('number')
                                <div class="mb-3">
                                    <label for="{{ $indikator->id_indikator }}" class="form-label fw-bold">{{ $indikator->nama_input }}</label>
                                    @php
                                        $firstPenilaian = $indikator->penilaianIndikator->first();
                                        $min = $firstPenilaian ? $firstPenilaian->min_nilai : 0;
                                        $max = $firstPenilaian ? $firstPenilaian->max_nilai : 100;
                                    @endphp
                                    <input type="number" name="{{ $indikator->id_indikator }}" 
                                        id="{{ $indikator->id_indikator }}" 
                                        class="form-control" 
                                        min="{{ $min }}" 
                                        max="{{ $max }}" 
                                        placeholder="Masukkan penilaian..." 
                                        required>
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

@section('scripts')
<script>
document.getElementById('nama_kepala_keluarga').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const jumlahAnggota = selected.getAttribute('data-anggota') || '';
    const pendidikanAttr = selected.getAttribute('data-pendidikan');
    const totalPenghasilan = selected.getAttribute('data-totalPenghasilan');

    // Set jumlah anggota
    document.getElementById('jumlah_anggota_keluarga').value = jumlahAnggota;
    
    // Set total penghasilan
    document.getElementById('total_penghasilan').value = totalPenghasilan;

    // Default value pendidikan = 5
    let pendidikanValue = "5"; 

    // Kalau ada nilai valid (0-4), pakai itu
    if (pendidikanAttr !== null && pendidikanAttr !== '') {
        const pendidikan = parseInt(pendidikanAttr, 10);
        if (!isNaN(pendidikan) && pendidikan >= 0 && pendidikan <= 4) {
            pendidikanValue = pendidikan.toString();
        }
    }

    // Set langsung value select
    const selectPendidikan = document.getElementById('jenjang_pendidikan_tertinggi');
    selectPendidikan.value = pendidikanValue;
});

</script>
@endsection
