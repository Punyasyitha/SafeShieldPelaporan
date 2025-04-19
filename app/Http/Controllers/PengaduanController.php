<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    public function index()
    {
        $data = [
            'url' => url('admin/pengaduan'),
            'list' => DB::table('pengaduan')
                ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
                ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status')
                ->orderBy('pengaduan.idpengaduan', 'asc')
                ->paginate(10),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan' => 'bg-orange-200 text-orange-800',
                'Tinjauan' => 'bg-yellow-200 text-yellow-800',
                'Final' => 'bg-blue-200 text-blue-800',
                'Selesai' => 'bg-green-200 text-green-800',
            ],
        ];

        // dd($data['list']);

        return view('admin.pengaduan.list', $data);
    }

    public function show($id)
    {
        try {
            $idpengaduan = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }

        $pengaduan = DB::table('pengaduan')
            ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
            ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status')
            ->where('pengaduan.idpengaduan', $idpengaduan)
            ->first();

        $warnaStatus = [
            'Verifikasi' => 'bg-red-200 text-red-800',
            'Panggilan' => 'bg-orange-200 text-orange-800',
            'Tinjauan' => 'bg-yellow-200 text-yellow-800',
            'Final' => 'bg-blue-200 text-blue-800',
            'Selesai' => 'bg-green-200 text-green-800',
        ];

        if (!$pengaduan) {
            abort(404, 'Data tidak ditemukan');
        }

        return view('admin.pengaduan.show', compact('pengaduan', 'warnaStatus'));
    }

    public function edit($id)
    {
        try {
            $idpengaduan = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }

        // Ambil data pengaduan dengan relasi status
        $pengaduan = \App\Models\Pengaduan::with('status')->find($idpengaduan);

        if (!$pengaduan) {
            abort(404, 'Data tidak ditemukan');
        }

        $status = \App\Models\MstStatus::all(); // ini model untuk tabel mst_sts_pengaduan

        return view('admin.pengaduan.edit', compact('pengaduan', 'status'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());

        try {
            $idpengaduan = decrypt($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.pengaduan.list')->with('error', 'Data tidak ditemukan');
        }
        // Validasi input
        $request->validate([
            'statusid'   => 'required|integer|exists:mst_sts_pengaduan,idstatus',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $pengaduan = DB::table('pengaduan')->where('idpengaduan', $idpengaduan)->first();
            if (!$pengaduan) {
                return redirect()->route('admin.pengaduan.list')->with('error', 'Data tidak ditemukan.');
            }
            // Update hanya kolom statusid dan keterangan
            DB::table('pengaduan')
                ->where('idpengaduan', $idpengaduan)
                ->update([
                    'statusid'   => $request->statusid,
                    'keterangan' => $request->keterangan,
                    'updated_at' => now(), // jika pakai timestamp
                ]);

            DB::commit();

            return redirect()->route('admin.pengaduan.list')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pengaduan.list')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idpengaduan = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }

        $pengaduan = DB::table('pengaduan')->where('idpengaduan', $idpengaduan)->first();
        if (!$pengaduan) {
            return redirect()->route('admin.pengaduan.list')
                ->with('error', 'Data tidak ditemukan.');
        }

        try {
            DB::table('pengaduan')->where('idpengaduan', $idpengaduan)->delete();
            return redirect()->route('admin.pengaduan.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengaduan.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
