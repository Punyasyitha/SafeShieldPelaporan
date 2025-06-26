<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function fetchData()
    {
        // Data yang akan dikirim ke API
        $payload = [
            'table'  => 'mst_kategori',
            'data'   => '*',
            'limit'  => 20
        ];

        // API key yang diberikan oleh penyedia layanan
        $apiKey = env('API_KEY');

        // Kirim POST request dengan header x-api-key
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'Accept' => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', $payload);

        // Cek apakah request berhasil
        if ($response->successful()) {
            $json = $response->json();
            $data = $json['data'] ?? []; // Kirim langsung array isi data
        } else {
            $data = [
                'error' => 'Gagal mengakses API eksternal. Status: ' . $response->status(),
                'message' => $response->body(),
            ];
        }
        //dd($data);
        // Kirim data ke view Blade
        return view('admin.pages.result', compact('data'));
    }
}