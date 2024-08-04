<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Masukkan API key langsung di sini
        $apiKey = '26d8fdb81bae0322e067102eb56a57e8';

        // Mendapatkan semua provinsi dari database
        $provinces = Province::all();

        foreach ($provinces as $province) {
            // Mengambil data kota dari API RajaOngkir
            $response = Http::withOptions(['verify' => false])->withHeaders([
                'key' => $apiKey
            ])->get('https://api.rajaongkir.com/starter/city?province=' . $province->id);

            // Mengonversi respons JSON menjadi array
            $data = $response->json();

            // Mengecek apakah data 'results' ada di dalam respons
            if (isset($data['rajaongkir']['results'])) {
                $cities = $data['rajaongkir']['results'];

                // Menyimpan data kota
                $insert_city = [];

                foreach ($cities as $city) {
                    $insert_city[] = [
                        'province_id' => $province->id,
                        'type' => $city['type'],
                        'name' => $city['type'] . ' ' . $city['city_name'],
                        'postal_code' => $city['postal_code'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Membagi data kota menjadi chunk untuk efisiensi
                $city_chunks = collect($insert_city)->chunk(100);

                foreach ($city_chunks as $chunk) {
                    City::insert($chunk->toArray());
                }
            } else {
                // Menangani kasus jika data 'results' tidak ditemukan
                Log::error('Data kota tidak ditemukan di dalam respons API.', ['response' => $data]);
            }
        }
    }
}
