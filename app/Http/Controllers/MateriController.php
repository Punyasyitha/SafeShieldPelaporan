<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/materi'),
            'list' => DB::table('materi')
                ->join('mst_modul', 'materi.modulid', '=', 'mst_modul.idmodul')
                ->join('mst_kategori', 'materi.kategoriid', '=', 'mst_kategori.idkategori')
                ->select('materi.*', 'mst_modul.nama_modul', 'mst_modul.deskripsi', 'mst_kategori.nama_kategori')
                ->orderBy('materi.idmateri', 'asc')
                ->paginate(10),
        ];
        // dd($data['list']);

        return view('admin.materi.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        $modul = DB::table('mst_modul')->get();
        $kategori = DB::table('mst_kategori')->get();

        return view('admin.materi.add', [
            'authorize' => $authorize,
            'url' => 'admin/materi',
            'modul' => $modul,
            'kategori' => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idmateri'      => 'nullable',
            'modulid'      => 'required|exists:mst_modul,idmodul',
            'kategoriid'      => 'required|exists:mst_kategori,idkategori',
            'judul_materi'  => 'required|string|max:255',
            'sumber' => 'required|url',
        ]);

        DB::beginTransaction();
        try {
            $newId = DB::table('materi')->max('idmateri') + 1;

            DB::table('materi')->insert([
                'idmateri'     => $newId,
                'modulid'     => $request->modulid,
                'kategoriid' => $request->kategoriid,
                'judul_materi' => $request->judul_materi,
                'sumber'        => $request->sumber,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.materi.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.materi.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idmateri = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Materi tidak ditemukan');
        }

        $materi = DB::table('materi')
            ->join('mst_modul', 'materi.modulid', '=', 'mst_modul.idmodul')
            ->join('mst_kategori', 'materi.kategoriid', '=', 'mst_kategori.idkategori')
            ->select('materi.*', 'mst_modul.nama_modul', 'mst_modul.deskripsi', 'mst_kategori.nama_kategori')
            ->where('materi.idmateri', $idmateri)
            ->first();

        if (!$materi) {
            abort(404, 'Materi tidak ditemukan');
        }

        return view('admin.materi.show', compact('materi'));
    }

    public function edit($id)
    {
        try {
            $idmateri = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Materi tidak ditemukan');
        }

        $materi = DB::table('materi')
            ->join('mst_modul', 'materi.modulid', '=', 'mst_modul.idmodul')
            ->join('mst_kategori', 'materi.kategoriid', '=', 'mst_kategori.idkategori')
            ->select('materi.*', 'mst_modul.nama_modul', 'mst_modul.deskripsi', 'mst_kategori.nama_kategori')
            ->where('materi.idmateri', $idmateri)
            ->first();

        if (!$materi) {
            abort(404, 'Materi tidak ditemukan');
        }

        $modul = DB::table('mst_modul')->get();
        $kategori = DB::table('mst_kategori')->get();

        return view('admin.materi.edit', compact('materi', 'modul', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'modulid'      => 'required|exists:mst_modul,idmodul',
            'kategoriid'   => 'required|exists:mst_kategori,idkategori',
            'judul_materi' => 'required|string|max:255',
            'sumber'       => 'required|url',
        ]);

        DB::beginTransaction();
        try {
            $idmateri = decrypt($id); // Dekripsi ID jika dienkripsi

            DB::table('materi')
                ->where('idmateri', $idmateri)
                ->update([
                    'modulid'      => $request->modulid,
                    'kategoriid'   => $request->kategoriid,
                    'judul_materi' => $request->judul_materi,
                    'sumber'       => $request->sumber,
                    'updated_at'   => now(),
                ]);

            DB::commit();

            return redirect()->route('admin.materi.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.materi.list')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idmateri = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Materi tidak ditemukan');
        }

        $materi = DB::table('materi')->where('idmateri', $idmateri)->first();
        if (!$materi) {
            return redirect()->route('admin.materi.list')
                ->with('error', 'Materi tidak ditemukan.');
        }

        try {
            DB::table('materi')->where('idmateri', $idmateri)->delete();
            return redirect()->route('admin.materi.list')
                ->with('success', 'Materi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.materi.list')
                ->with('error', 'Terjadi kesalahan saat menghapus materi: ' . $e->getMessage());
        }
    }
}
