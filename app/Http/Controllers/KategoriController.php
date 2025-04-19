<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/kategori'),
            'list' => DB::table('mst_kategori')->orderBy('idkategori', 'asc')->paginate(10),
        ];

        return view('admin.master.kategori.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('admin.master.kategori.add', [
            'authorize' => $authorize,
            'url' => 'admin/master/kategori'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idkategori' => 'nullable',
            'nama_kategori' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Generate ID baru
            $newId = DB::table('mst_kategori')->max('idkategori') + 1;

            // Simpan data ke database
            DB::table('mst_kategori')->insert([
                'idkategori'    => $newId,
                'nama_kategori' => $request->nama_kategori,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::commit();

            // ✅ Redirect ke list dengan alert sukses
            return redirect()->route('admin.master.kategori.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            // ❌ Redirect dengan alert error
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            // 🔓 Dekripsi ID
            $idkategori = decrypt($id);

            // 🔎 Ambil data berdasarkan idkategori
            $kategori = DB::table('mst_kategori')
                ->where('idkategori', $idkategori)
                ->first();

            // ❌ Jika data tidak ditemukan
            if (!$kategori) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Data tidak ditemukan.');
            }

            // ✅ Tampilkan halaman detail
            return view('admin.master.kategori.show', [
                'kategori' => $kategori,
                'url' => 'admin/master/kategori'
            ]);
        } catch (\Exception $e) {
            // ❌ Jika terjadi kesalahan saat dekripsi atau pengambilan data
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idkategori = decrypt($id);
            $kategori = DB::table('mst_kategori')->where('idkategori', $idkategori)->first();

            if (!$kategori) {
                return redirect()->route('admin.master.kategori.list')->with('error', 'Data tidak ditemukan.');
            }

            return view('admin.master.kategori.edit', compact('kategori'));
        } catch (\Exception $e) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        try {
            $request->validate([
                'nama_kategori' => 'required|string|max:255',
            ]);

            $idkategori = decrypt($id);

            $updated = DB::table('mst_kategori')
                ->where('idkategori', $idkategori)
                ->update([
                    'nama_kategori' => $request->nama_kategori,
                ]);

            if ($updated) {
                return redirect()->route('admin.master.kategori.list')
                    ->with('success', 'Kategori berhasil diperbarui.');
            } else {
                return redirect()->route('admin.master.kategori.list')
                    ->with('error', 'Data tidak berubah.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idkategori = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }
        $kategori = DB::table('mst_kategori')->where('idkategori', $idkategori)->first();
        if (!$kategori) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Data tidak ditemukan.');
        }

        try {
            DB::table('mst_kategori')->where('idkategori', $idkategori)->delete();
            return redirect()->route('admin.master.kategori.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.kategori.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
