<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penilaian_indikator')->truncate(); // Reset tabel dulu biar bersih

        // Data indikator dan penilaiannya
        $data = [
            'IND001' => [
                'Total pengeluaran makanan kurang dari atau sama dengan Rp 591.933/kapita/bulan. Berdasarkan Garis Kemiskinan Jakarta per Maret 2025.',
                'Total pengeluaran makanan lebih dari Rp 591.933/kapita/bulan. Berdasarkan Garis Kemiskinan Jakarta per Maret 2025.'
            ],
            'IND002' => [
                'Tidak sekolah',
                'SD',
                'SMP',
                'SMA',
                'Perguruan Tinggi',
                'Tidak ada anak / Sudah pisah Kartu Keluarga',
            ],
            'IND003' => [
                'Dinding dari bambu/kayu/tembok dengan kondisi tidak baik/berkualitas rendah',
                'Dinding dari tembok yang sudah usang/berlumut',
                'Dinding dari tembok tidak diplester',
                'Dinding dari bambu/kayu dengan kondisi baik/berkualitas tinggi',
                'Dinding dari tembok diplester, dicat, dan dalam kondisi prima',
            ],
            'IND004' => [
                'Tanah tanpa pelapis kondisi tidak baik/berkualitas rendah',
                'Kayu/semen dengan kondisi tidak baik/berkualitas rendah',
                'Keramik dengan kondisi tidak baik/berkualitas rendah',
                'Keramik dengan kondisi baik dan stabil',
                'Marmer/granit',
            ],
            'IND005' => [
                'Atap dari ijuk/rumbia dengan kondisi tidak baik/berkualitas rendah',
                'Atap dari seng/asbes dengan kondisi tidak baik/berkualitas rendah',
                'Atap dari genteng dengan kondisi tidak baik/berkualitas rendah',
                'Atap dari genteng/seng/asbes dengan kondisi baik dan stabil',
                'Atap dari material premium seperti genteng metal/beton',
            ],
            'IND006' => [
                'Tidak ada penerangan listrik, hanya menggunakan lampu minyak/lilin',
                'Menggunakan listrik tanpa meteren/melalui sambungan ilegal/tidak resmi',
                'Menggunakan listrik genset/diesel',
                'Menggunakan listrik dengan meteran daya 450-900VA',
                'Menggunakan listrik dengan meteran daya >900VA',
            ],
            'IND007' => [
                'Luas lantai rumah kurang dari 8m2 / orang',
                'Luas lantai rumah lebih dari atau sama dengan 8m2/orang',
            ],
            'IND008' => [
                'Mata air tak terlindungi/air sungai/air hujan',
                'Sumur tak terlindung',
                'Air mesin bor pompa',
                'Air PDAM',
                'Air isi ulang/kemasan',
            ],
            'IND009' => [
                '>90%',
                '70% - <90%',
                '50% - <70%',
                '30% - <50%',
                '<30%',
            ],
            'IND010' => [
                'Tidak mampu berobat sama sekali, bahkan ke puskesmas',
                'Hanya mampu berobat ke puskesmas atau layanan bersubsidi dengan kesulitan',
                'Mampu berobat ke puskesmas atau layanan bersubsidi',
                'Mampu berobat ke tenaga medis berbayar',
                'Selalu mampu berobat ke dokter/klinik swasta berkualitas tinggi',
            ],
            'IND011' => [
                'Tidak mampu membeli pakaian baru sama sekali untuk semua anggota',
                'Hanya mampu membeli pakaian bekas untuk beberapa anggota',
                'Mampu membeli pakaian baru minimal sekali setahun untuk sebagian anggota',
                'Mampu membeli pakaian baru sekali setahun untuk semua anggota',
                'Mampu membeli pakaian baru lebih dari sekali setahun dengan kualitas baik',
            ],
        ];

        $insertData = [];
        foreach ($data as $indikatorId => $deskripsiList) {
            // Ambil huruf kode indikator dari nomor indikator (IND001 -> A, IND002 -> B, dst)
            $kode = chr(64 + intval(substr($indikatorId, 4, 3))); 

            foreach ($deskripsiList as $index => $deskripsi) {
                $insertData[] = [
                    'id_penilaian_indikator' => 'INDVAL' . $kode . $index,
                    'id_indikator' => $indikatorId,
                    'nilai' => $index,
                    'deskripsi' => $deskripsi,
                ];
            }
        }

        DB::table('penilaian_indikator')->insert($insertData);
    }
}
