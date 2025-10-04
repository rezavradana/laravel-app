<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $deskripsiList = [
            'Tidak mempunyai sumber mata pencarian dan atau mempunyai sumber mata pencarian tetapi tidak mempunyai kemampuan memenuhi kebutuhan dasar.',
            'Mempunyai kemampuan hanya menyekolahkan anaknya sampai jenjang pendidikan Sekolah Lanjutan Tingkat Pertama',
            'Mempunyai dinding rumah terbuat dari bamboo/kayu/tembok dengan kondisi tidak baik/berkualitas rendah, termasuk tembok yang sudah usang/berlumut atau tembok tidak diplester.',
            'Kondisi lantai terbuat dari tanah atau kayu/semen/keramik dengan kondisi tidak baik/berkualitas rendah.',
            'Atap terbuat dari ijuk/rumbia atau genteng/seng/asbes dengan kondisi tidak baik/ berkualitas rendah.',
            'Mempunyai penerangan bangunan tempat tinggal bukan dari listrik atau listrik tanpa meteran.',
            'Luas lantai rumah kecil kurang dari 8m2 / orang',
            'Mempunyai sumber air minum berasal dari sumur atau mata air tak terlindungi/ air sungai / air hujan/ lainnya.',
            'Mempunyai pengeluaran sebagian besar digunakan untuk memenuhi konsumsi makanan pokok dengan sangat sederhana.',
            'Tidak mampu atau mengalami kesulitan untuk berobat ke tenaga medis, kecuali Puskesmas atau yang disubsidi pemerintah.',
            'Tidak mampu membeli pakaian satu kali dalam satu tahun untuk setiap anggota rumah tangga.',
        ];

        $data = [];
        foreach ($deskripsiList as $index => $deskripsi) {
            // Tentukan tipe input
            $tipeInput = 'select';
            if ($index === 0) {
                $tipeInput = 'none';
            } elseif ($index === 6) {
                $tipeInput = 'number';
            }
            
            // Buat nama input dari kependekan deskripsi
            $namaInput = $this->generateNamaInput($deskripsi);
            
            $data[] = [
                'id_indikator' => 'IND' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'kode' => chr(65 + $index), // A, B, C, ...
                'nama_input' => $namaInput,
                'tipe_input' => $tipeInput,
                'deskripsi' => $deskripsi,
            ];
        }

        DB::table('indikator')->insert($data);
    }

    private function generateNamaInput($deskripsi): string
    {
        // Ambil kata-kata penting dari deskripsi
        $words = explode(' ', $deskripsi);
        
        // Filter kata yang terlalu pendek
        $filteredWords = array_filter($words, function($word) {
            return strlen($word) > 3;
        });
        
        // Ambil maksimal 3 kata pertama
        $selectedWords = array_slice($filteredWords, 0, 3);
        
        // Gabungkan dan format
        if (empty($selectedWords)) {
            return substr($deskripsi, 0, 20);
        }
        
        return implode('_', $selectedWords);
    }
}