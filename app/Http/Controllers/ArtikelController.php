<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/artikel'),
            'list' => DB::table('artikel')
                ->join('mst_penulis', 'artikel.penulisid', '=', 'mst_penulis.idpenulis')
                ->select('artikel.*', 'mst_penulis.nama_penulis')
                ->orderBy('artikel.idartikel', 'asc')
                ->paginate(10),
        ];
        // dd($data['list']);

        return view('admin.artikel.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        $penulis = DB::table('mst_penulis')->get();

        return view('admin.artikel.add', [
            'authorize' => $authorize,
            'url' => 'admin/artikel',
            'penulis' => $penulis,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penulisid'      => 'required|exists:mst_penulis,idpenulis',
            'judul_artikel'  => 'required|string|max:255',
            'isi_artikel'    => 'required|string',
            'tanggal_rilis'  => 'required|date',
            'status'         => 'required|in:draft,published,archived',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,svg,webp|max:102400', // 100MB
        ]);

        DB::beginTransaction();
        try {
            $newId = DB::table('artikel')->max('idartikel') + 1;
            $gambarPath = null;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $filename = time() . '-' . $gambar->getClientOriginalName();
                $gambarPath = Storage::disk('public')->putFileAs('artikel', $gambar, $filename);
            }

            DB::table('artikel')->insert([
                'idartikel'     => $newId,
                'penulisid'     => $request->penulisid,
                'judul_artikel' => $request->judul_artikel,
                'isi_artikel'   => $request->isi_artikel,
                'tanggal_rilis' => $request->tanggal_rilis,
                'status'        => $request->status,
                'gambar'        => $gambarPath,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.artikel.list')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.artikel.list')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idartikel = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Artikel tidak ditemukan');
        }

        $artikel = DB::table('artikel')
            ->join('mst_penulis', 'artikel.penulisid', '=', 'mst_penulis.idpenulis')
            ->select('artikel.*', 'mst_penulis.nama_penulis')
            ->where('artikel.idartikel', $idartikel)
            ->first();

        if (!$artikel) {
            abort(404, 'Artikel tidak ditemukan');
        }

        return view('admin.artikel.show', compact('artikel'));
    }

    public function edit($id)
    {
        try {
            $idartikel = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Artikel tidak ditemukan');
        }

        $artikel = DB::table('artikel')
            ->join('mst_penulis', 'artikel.penulisid', '=', 'mst_penulis.idpenulis')
            ->select('artikel.*', 'mst_penulis.nama_penulis')
            ->where('artikel.idartikel', $idartikel)
            ->first();

        if (!$artikel) {
            abort(404, 'Artikel tidak ditemukan');
        }

        $penulis = DB::table('mst_penulis')->get();

        return view('admin.artikel.edit', compact('artikel', 'penulis'));
    }

    public function update(Request $request, $id)
    {
        try {
            $idartikel = decrypt($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.artikel.list')->with('error', 'Artikel tidak ditemukan');
        }

        // dd($request->all()); // Debug: Melihat seluruh input request yang dikirim

        $request->validate([
            'penulisid'      => 'required|exists:mst_penulis,idpenulis',
            'judul_artikel'  => 'required|string|max:255',
            'isi_artikel'    => 'required',
            'tanggal_rilis'  => 'required|date',
            'status'         => 'required|in:draft,published,archived',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,svg,webp|max:102400', // 100MB
        ]);

        DB::beginTransaction();
        try {
            $artikel = DB::table('artikel')->where('idartikel', $idartikel)->first();
            if (!$artikel) {
                return redirect()->route('admin.artikel.list')->with('error', 'Artikel tidak ditemukan.');
            }

            $gambarPath = $artikel->gambar; // Gunakan gambar lama sebagai default

            // **1. Periksa apakah gambar akan dihapus**
            if ($request->has('hapus_gambar') && $artikel->gambar) {
                if (Storage::disk('public')->exists($artikel->gambar)) {
                    Storage::disk('public')->delete($artikel->gambar);
                }
                $gambarPath = null; // Kosongkan gambar di database
                //dd('Gambar dihapus, gambarPath:', $gambarPath); // Debug: Mengecek apakah gambar berhasil dihapus
            }

            // **2. Periksa apakah ada gambar baru yang diupload**
            if ($request->hasFile('gambar')) {
                //dd($request->file('gambar')); // Debug: Cek apakah file gambar masuk dalam request

                $gambar = $request->file('gambar');
                $filename = time() . '-' . $gambar->getClientOriginalName();
                $gambarPath = $gambar->storeAs('artikel', $filename, 'public'); // Simpan di storage/app/public/artikel

                //dd($gambarPath);
                // Hapus gambar lama jika ada
                if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                    Storage::disk('public')->delete($artikel->gambar);
                }
            }

            // dd('Sebelum update ke database', $gambarPath); // Debug: Melihat path gambar sebelum update database

            // **3. Simpan perubahan ke database**
            DB::table('artikel')
                ->where('idartikel', $idartikel)
                ->update([
                    'penulisid'     => $request->penulisid,
                    'judul_artikel' => $request->judul_artikel,
                    'isi_artikel'   => $request->isi_artikel,
                    'tanggal_rilis' => $request->tanggal_rilis,
                    'status'        => $request->status,
                    'gambar'        => $gambarPath, // Update gambar di database
                    'updated_at'    => now(),
                ]);

            DB::commit();
            return redirect()->route('admin.artikel.list')->with('success', 'Artikel berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.artikel.list')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idartikel = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Artikel tidak ditemukan');
        }

        $artikel = DB::table('artikel')->where('idartikel', $idartikel)->first();
        if (!$artikel) {
            return redirect()->route('admin.artikel.list')
                ->with('error', 'Artikel tidak ditemukan.');
        }

        try {
            DB::table('artikel')->where('idartikel', $idartikel)->delete();
            return redirect()->route('admin.artikel.list')
                ->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.artikel.list')
                ->with('error', 'Terjadi kesalahan saat menghapus artikel: ' . $e->getMessage());
        }
    }
}
