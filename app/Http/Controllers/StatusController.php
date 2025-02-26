<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index($data)
    {
        // ✅ Set hak akses untuk admin (misalnya, hanya admin yang bisa menambah)
        $data['authorize'] = (object)['add' => '1'];

        $data['list'] = DB::table('mst_sts_pengaduan')
            ->orderBy('idstatus', 'asc') // Mengurutkan berdasarkan idstatus
            ->get();

        return view('master.status.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('master.status.add', [
            'authorize' => $authorize,
            'url' => 'master/status'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idstatus' => 'nullable',
            'nama_status' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Generate ID baru
            $newId = DB::table('mst_sts_pengaduan')->max('idstatus') + 1;

            // Simpan data ke database
            DB::table('mst_sts_pengaduan')->insert([
                'idstatus'    => $newId,
                'nama_status' => $request->nama_status,
            ]);

            DB::commit();

            // ✅ Redirect ke list dengan alert sukses
            return redirect()->route('master.status.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            // ❌ Redirect dengan alert error
            return redirect()->route('master.status.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            // 🔓 Dekripsi ID
            $idstatus = decrypt($id);

            // 🔎 Ambil data berdasarkan idstatus
            $status = DB::table('mst_sts_pengaduan')
                ->where('idstatus', $idstatus)
                ->first();

            // ❌ Jika data tidak ditemukan
            if (!$status) {
                return redirect()->route('master.status.list')
                    ->with('error', 'Data tidak ditemukan.');
            }

            // ✅ Tampilkan halaman detail
            return view('master.status.show', [
                'status' => $status,
                'url' => 'master/status'
            ]);
        } catch (\Exception $e) {
            // ❌ Jika terjadi kesalahan saat dekripsi atau pengambilan data
            return redirect()->route('master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idstatus = decrypt($id);
            $status = DB::table('mst_sts_pengaduan')->where('idstatus', $idstatus)->first();

            if (!$status) {
                return redirect()->route('master.status.list')->with('error', 'Data tidak ditemukan.');
            }

            return view('master.status.edit', compact('status'));
        } catch (\Exception $e) {
            return redirect()->route('master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        try {
            $request->validate([
                'nama_status' => 'required|string|max:255',
            ]);

            $idstatus = decrypt($id);

            $updated = DB::table('mst_sts_pengaduan')
                ->where('idstatus', $idstatus)
                ->update([
                    'nama_status' => $request->nama_status,
                ]);

            if ($updated) {
                return redirect()->route('master.status.list')
                    ->with('success', 'Status berhasil diperbarui.');
            } else {
                return redirect()->route('master.status.list')
                    ->with('error', 'Data tidak berubah.');
            }
        } catch (\Exception $e) {
            return redirect()->route('master.status.list')
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idstatus = decrypt($id); // 🔓 Dekripsi ID

            $status = DB::table('mst_sts_pengaduan')->where('idstatus', $idstatus)->first();
            if (!$status) {
                return redirect()->route('master.status.list')
                    ->with('error', 'Data tidak ditemukan.');
            }

            // 🚀 Hapus data
            DB::table('mst_sts_pengaduan')->where('idstatus', $idstatus)->delete();

            return redirect()->route('master.status.list')
                ->with('success', 'Status berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('master.status.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}