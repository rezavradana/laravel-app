<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 30; $i++) {
            DB::table('keluarga')->insert([
                'no_kk' => $faker->unique()->numerify('################'), // 16 digit
                'luas_lantai' => $faker->numberBetween(20, 150), // m²
                'alamat' => $faker->streetAddress,
                'rt_rw' => '00' . $faker->numberBetween(1, 9) . '/00' . $faker->numberBetween(1, 9),
                'desa_kelurahan' => $faker->citySuffix,
                'kecamatan' => $faker->city,
                'kabupaten_kota' => $faker->city,
                'kode_pos' => $faker->postcode,
                'provinsi' => $faker->state,
                'tanggal_tambah' => now(),
                'tanggal_update' => now(),
            ]);
        }
    }
}
