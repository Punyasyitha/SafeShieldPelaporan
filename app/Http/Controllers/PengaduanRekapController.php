<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanRekapController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari URL query
        $fromDate = request()->get('from_date');
        $toDate   = request()->get('to_date');
        $statusId = request()->get('statusid');

        // Ambil data pengaduan dari API
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'pengaduan',
            'data'  => '*',
            'limit' => 1000,
        ]);

        // Ambil data referensi status pengaduan
        $responseStatus = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_sts_pengaduan',
            'data'  => '*',
        ]);

        $statusList = $statusList = collect($responseStatus['data'] ?? [])->map(fn($item) => (object) $item);
        $statusMap  = $statusList->pluck('NAMA_STATUS', 'IDSTATUS');

        $warnaStatus = [
            'Verifikasi' => 'bg-red-200 text-red-800',
            'Panggilan'  => 'bg-orange-200 text-orange-800',
            'Tinjauan'   => 'bg-yellow-200 text-yellow-800',
            'Final'      => 'bg-blue-200 text-blue-800',
            'Selesai'    => 'bg-green-200 text-green-800',
        ];

        // Jika gagal fetch
        if (!$response->successful()) {
            return view('admin.report.pengaduan.filter', [
                'list'        => collect(),
                'authorize'   => (object)['add' => '1'],
                'url'         => url('admin/report/filter'),
                'warnaStatus' => $warnaStatus,
                'statuses'    => $statusList,
                'error'       => 'Gagal fetch data dari API',
            ]);
        }

        // Olah data dan filter
        $data = collect($response->json()['data'] ?? [])
            ->filter(function ($item) use ($fromDate, $toDate, $statusId) {
                $item = (array) $item;
                $tanggal = $item['TGL_PENGADUAN'] ?? null;

                if ($fromDate && $tanggal < $fromDate) return false;
                if ($toDate && $tanggal > $toDate) return false;
                if ($statusId && $item['STATUSID'] != $statusId) return false;

                return true;
            })
            ->map(function ($item) use ($statusMap) {
                $item = (array) $item;
                $item['NAMA_STATUS'] = $statusMap[$item['STATUSID']] ?? '-';
                return $item;
            })
            ->sortBy(fn($item) => (int) $item['IDPENGADUAN'] ?? 0)
            ->values();

        return view('admin.report.pengaduan.filter', [
            'list'        => $data,
            'authorize'   => (object)['add' => '1'],
            'url'         => url('admin/report/filter'),
            'warnaStatus' => $warnaStatus,
            'statuses'    => $statusList,
        ]);
    }

    public function result()
    {
        $fromDate = request()->input('from_date');
        $toDate   = request()->input('to_date');
        $statusId = request()->input('statusid');

        // Ambil data pengaduan dari API
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'pengaduan',
            'data'  => '*',
            'limit' => 1000,
        ]);

        // Ambil data referensi status pengaduan
        $responseStatus = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'mst_sts_pengaduan',
            'data'  => '*',
        ]);

        $statusList = collect($responseStatus['data'] ?? [])->map(fn($item) => (object) $item);
        $statusMap  = $statusList->pluck('NAMA_STATUS', 'IDSTATUS');

        $warnaStatus = [
            'Verifikasi' => 'bg-red-200 text-red-800',
            'Panggilan'  => 'bg-orange-200 text-orange-800',
            'Tinjauan'   => 'bg-yellow-200 text-yellow-800',
            'Final'      => 'bg-blue-200 text-blue-800',
            'Selesai'    => 'bg-green-200 text-green-800',
        ];

        if (!$response->successful()) {
            return view('admin.report.pengaduan.result', [
                'list'        => collect(),
                'warnaStatus' => $warnaStatus,
                'statuses'    => $statusList,
                'from_date'   => $fromDate,
                'to_date'     => $toDate,
                'statusid'    => $statusId,
                'error'       => 'Gagal fetch data dari API',
            ]);
        }

        $data = collect($response['data'] ?? [])
            ->filter(function ($item) use ($fromDate, $toDate, $statusId) {
                $item = (array) $item;
                $tanggal = $item['TGL_PENGADUAN'] ?? null;

                if ($fromDate && $tanggal < $fromDate) return false;
                if ($toDate && $tanggal > $toDate) return false;
                if ($statusId && $item['STATUSID'] != $statusId) return false;

                return true;
            })
            ->map(function ($item) use ($statusMap) {
                $item = (array) $item;
                $item['NAMA_STATUS'] = $statusMap[$item['STATUSID']] ?? '-';
                return $item;
            })
            ->sortBy(fn($item) => (int) $item['IDPENGADUAN'] ?? 0)
            ->values();

        return view('admin.report.pengaduan.result', [
            'list'        => $data,
            'warnaStatus' => $warnaStatus,
            'statuses'    => $statusList,
            'from_date'   => $fromDate,
            'to_date'     => $toDate,
            'statusid'    => $statusId,
        ]);
    }
}
