<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulController extends Controller
{
    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/modul'),
            'list' => DB::table('mst_modul')->orderBy('idmodul', 'asc')->paginate(10),
        ];

        return view('admin.master.modul.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('admin.master.modul.add', [
            'authorize' => $authorize,
            'url' => 'admin/master/modul'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_modul'   => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_terbit' => 'required| date',
        ]);

        DB::beginTransaction();
        try {
            // Generate ID baru (pastikan formatnya sesuai kebutuhan)
            $newId = DB::table('mst_modul')->max('idmodul') + 1;

            // Simpan data ke database
            DB::table('mst_modul')->insert([
                'idmodul'      => $newId,
                'nama_modul'   => $request->nama_modul,
                'deskripsi'    => $request->deskripsi,
                'tahun_terbit' => $request->tahun_terbit,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::commit();

            // ✅ Redirect ke list dengan alert sukses
            return redirect()->route('admin.master.modul.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            // ❌ Redirect dengan alert error
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            // 🔓 Dekripsi ID
            $idmodul = decrypt($id);

            // 🔎 Ambil data berdasarkan idmodul
            $modul = DB::table('mst_modul')
                ->where('idmodul', $idmodul)
                ->first();

            // ❌ Jika data tidak ditemukan
            if (!$modul) {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Data tidak ditemukan.');
            }

            // ✅ Tampilkan halaman detail
            return view('admin.master.modul.show', [
                'modul' => $modul,
                'url' => 'admin/master/modul'
            ]);
        } catch (\Exception $e) {
            // ❌ Jika terjadi kesalahan saat dekripsi atau pengambilan data
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $idmodul = decrypt($id);
            $modul = DB::table('mst_modul')->where('idmodul', $idmodul)->first();

            if (!$modul) {
                return redirect()->route('admin.master.modul.list')->with('error', 'Data tidak ditemukan.');
            }

            return view('admin.master.modul.edit', compact('modul'));
        } catch (\Exception $e) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        try {
            $request->validate([
                'nama_modul'   => 'required|string|max:255',
                'deskripsi'    => 'nullable|string',
                'tahun_terbit' => 'required| date',
            ]);

            $idmodul = decrypt($id);

            $updated = DB::table('mst_modul')
                ->where('idmodul', $idmodul)
                ->update([
                    'nama_modul'   => $request->nama_modul,
                    'deskripsi'    => $request->deskripsi,
                    'tahun_terbit' => $request->tahun_terbit,
                ]);

            if ($updated) {
                return redirect()->route('admin.master.modul.list')
                    ->with('success', 'Modul berhasil diperbarui.');
            } else {
                return redirect()->route('admin.master.modul.list')
                    ->with('error', 'Data tidak berubah.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idmodul = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }
        $modul = DB::table('mst_modul')->where('idmodul', $idmodul)->first();
        if (!$modul) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Data tidak ditemukan.');
        }

        try {
            DB::table('mst_modul')->where('idmodul', $idmodul)->delete();
            return redirect()->route('admin.master.modul.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.modul.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
