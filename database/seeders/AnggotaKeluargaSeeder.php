<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AnggotaKeluargaSeeder extends Seeder
{
    public function run(): void
{
    $faker = Faker::create('id_ID');
    $noKks = DB::table('keluarga')->pluck('no_kk')->toArray();

    $jenisKelamin = ['Laki-laki', 'Perempuan'];
    $agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    $pendidikan = ['0', '1', '2', '3'];
    $pekerjaan = ['Pelajar', 'Mahasiswa', 'Petani', 'Karyawan Swasta', 'PNS', 'Wiraswasta', 'Buruh', 'Ibu Rumah Tangga', 'Tidak Bekerja'];
    $hubungan = ['Kepala Keluarga', 'Istri', 'Anak', 'Orang Tua', 'Menantu', 'Cucu', 'Lainnya'];

    foreach (range(1, 30) as $index) {
        $jenisKelaminRandom = $faker->randomElement($jenisKelamin);
        $pekerjaanRandom = $faker->randomElement($pekerjaan);
        
        // Generate penghasilan berdasarkan pekerjaan
        $penghasilan = $this->generatePenghasilan($pekerjaanRandom, $faker);

        DB::table('anggota_keluarga')->insert([
            'nik' => $faker->unique()->numerify('317405##########'),
            'no_kk' => $faker->randomElement($noKks),
            'nama' => $faker->name,
            'tanggal_lahir' => $faker->date('Y-m-d'),
            'jenis_kelamin' => $jenisKelaminRandom,
            'agama' => $faker->randomElement($agama),
            'pendidikan' => $faker->randomElement($pendidikan),
            'pekerjaan' => $pekerjaanRandom,
            'hubungan' => $faker->randomElement($hubungan),
            'penghasilan' => $penghasilan,
            'tanggal_tambah' => now(),
            'tanggal_update' => now(),
        ]);
    }
}

    /**
     * Generate penghasilan berdasarkan pekerjaan
     */
    private function generatePenghasilan(string $pekerjaan, $faker): int
    {
        return match($pekerjaan) {
            'Pelajar', 'Mahasiswa', 'Tidak Bekerja', 'Ibu Rumah Tangga' => 0,
            'Petani', 'Buruh' => $faker->numberBetween(500000, 2000000),
            'Karyawan Swasta' => $faker->numberBetween(2500000, 6000000),
            'PNS' => $faker->numberBetween(3000000, 8000000),
            'Wiraswasta' => $faker->numberBetween(3000000, 10000000),
            default => $faker->numberBetween(1000000, 5000000)
        };
    }
}
