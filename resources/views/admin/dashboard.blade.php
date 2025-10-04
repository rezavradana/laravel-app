@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $data_dashboard['jumlah_warga'] }}</h3>
                        <p>Jumlah Warga</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                        </path>
                    </svg>
                    <a href="#"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 1-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ $data_dashboard['jumlah_keluarga'] }}</h3>
                        <p>Jumlah Keluarga</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                        </path>
                    </svg>
                    <a href="#"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 2-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $data_dashboard['jumlah_prediksi'] }}</h3>
                        <p>Jumlah Prediksi</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                        </path>
                    </svg>
                    <a href="#"
                        class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 3-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        {{-- CHART DIAGRAM --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Diagram Hasil Prediksi Terakhir</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-12">
                            <div id="pie-chart"></div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </div>
                <!-- /.footer -->
            </div>
        </div>
        {{-- END CHART DIAGRAM --}}

        {{-- TABEL --}}
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Data Prediksi Terakhir</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. KK</th>
                            <th>Nama Kepala Keluarga</th>
                            <th>Hasil Prediksi</th>
                            <th>Probabilitas</th>
                            <th>Tanggal Prediksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_dashboard['prediksi_terbaru'] as $prediksi)                            
                            <tr class="align-middle">
                                <td>{{ $prediksi->no_kk }}</td>
                                <td>
                                    {{ $prediksi->keluarga->anggotaKeluarga->first()->nama ?? 'N/A'}}
                                </td>
                                <td>
                                    <span class="badge text-bg-{{ $prediksi->hasil_prediksi == 'Miskin' ? 'danger' : 'success' }} fs-7">{{ $prediksi->hasil_prediksi }}</span>
                                </td>
                                <td>{{ $prediksi->probabilitas }}</td>
                                <td>{{ $prediksi->tanggal_prediksi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data prediksi tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        {{-- END TABEL --}}
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
@endsection
@section('scripts')
    <script>
      //-------------
      // - PIE CHART -
      //-------------

      const pie_chart_options = {
        series: [
            {{ 
                $data_dashboard['jumlah_hasil_prediksi']['Miskin'] ?? 0
            }},
            {{ 
                $data_dashboard['jumlah_hasil_prediksi']['Tidak Miskin'] ?? 0
            }}
        ],
        chart: {
          type: 'pie',
        },
        labels: ['Miskin', 'Tidak Miskin'],
        dataLabels: {
          enabled: true,
        },
        colors: ['#cf0404','#0d6efd'],
      };

      const pie_chart = new ApexCharts(document.querySelector('#pie-chart'), pie_chart_options);
      pie_chart.render();

      //-----------------
      // - END PIE CHART -
      //-----------------
    </script>
@endsection
