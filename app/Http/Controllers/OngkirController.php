<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{

    public function index()
    {
        return view('user.ongkir');
    }
    // API key langsung di sini
    private $apiKey = '26d8fdb81bae0322e067102eb56a57e8';

    public function province(Request $request)
    {
        try {
            $provinces = Province::where('name', 'like', '%' . $request->keyword . '%')
                ->select('id', 'name')
                ->get();
            $data = [];
            foreach ($provinces as $province) {
                $data[] = [
                    'id' => $province->id,
                    'text' => $province->name
                ];
            }

            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Data Fetch Failed',
                'data' => []
            ]);
        }
    }

    public function city(Request $request)
    {
        try {
            $cities = Province::find($request->province_id)
                ->cities()
                ->where('name', 'like', '%' . $request->keyword . '%')
                ->select('id', 'name')
                ->get();

            $data = [];
            foreach ($cities as $city) {
                $data[] = [
                    'id' => $city->id,
                    'text' => $city->name
                ];
            }

            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Data Fetch Failed',
                'data' => []
            ]);
        }
    }

    public function checkOngkir(Request $request)
    {
        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => $this->apiKey])
                ->post('https://api.rajaongkir.com/starter/cost', [
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'weight' => $request->weight,
                    'courier' => $request->courier
                ])
                ->json();

            // Memeriksa apakah 'rajaongkir' ada di dalam respons
            if (isset($response['rajaongkir']['results'][0]['costs'])) {
                return response()->json($response['rajaongkir']['results'][0]['costs']);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid API Response',
                    'data' => []
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'data' => []
            ]);
        }
    }
}
