<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Masukkan API key langsung di sini
        $apiKey = '26d8fdb81bae0322e067102eb56a57e8';

        // Log API key untuk debugging (opsional)
        Log::info('RAJAONGKIR_API_KEY: ' . $apiKey);

        // Mengambil data dari API RajaOngkir
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'key' => $apiKey
        ])->get('https://api.rajaongkir.com/starter/province');

        // Mengonversi respons JSON menjadi array
        $data = $response->json();

        // Mengecek jika data 'results' ada di dalam respons
        if (isset($data['rajaongkir']['results'])) {
            $provinces = $data['rajaongkir']['results'];

            foreach ($provinces as $province) {
                Province::updateOrCreate(
                    ['id' => $province['province_id']], // Gunakan ID sebagai kunci unik jika ada
                    [
                        'name' => $province['province'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        } else {
            // Menangani kasus jika data 'results' tidak ditemukan
            Log::error('Data province tidak ditemukan di dalam respons API.', ['response' => $data]);
        }
    }

}
