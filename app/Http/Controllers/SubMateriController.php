<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubMateriController extends Controller
{
    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/submateri'),
            'list' => DB::table('submateri')
                ->join('materi', 'submateri.materiid', '=', 'materi.idmateri')
                ->select('submateri.*', 'materi.judul_materi')
                ->orderBy('submateri.idsubmateri', 'asc')
                ->paginate(10),
        ];

        // dd($data['list']);

        return view('admin.submateri.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        $materi = DB::table('materi')->get();

        return view('admin.submateri.add', [
            'authorize' => $authorize,
            'url' => 'admin/submateri',
            'materi' => $materi,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idsubmateri'      => 'nullable',
            'materiid'      => 'required|exists:materi,idmateri',
            'judul_submateri'  => 'required|string|max:255',
            'isi'              => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $newId = DB::table('submateri')->max('idsubmateri') + 1;

            DB::table('submateri')->insert([
                'idsubmateri'     => $newId,
                'materiid'     => $request->materiid,
                'judul_submateri' => $request->judul_submateri,
                'isi' => $request->isi,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.submateri.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idsubmateri = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        $submateri = DB::table('submateri')
            ->join('materi', 'submateri.materiid', '=', 'materi.idmateri')
            ->select('submateri.*', 'materi.judul_materi')
            ->where('submateri.idsubmateri', $idsubmateri)
            ->first();

        if (!$submateri) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        return view('admin.submateri.show', compact('submateri'));
    }

    public function edit($id)
    {
        try {
            $idsubmateri = decrypt($id); // Jika ID tidak dienkripsi, langsung pakai $id
        } catch (\Exception $e) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        $submateri = DB::table('submateri')
            ->where('idsubmateri', $idsubmateri) // Pakai hasil dekripsi
            ->first();

        if (!$submateri) {
            abort(404, 'Sub Materi tidak ditemukan');
        }

        $materi = DB::table('materi')->get();

        return view('admin.submateri.edit', compact('submateri', 'materi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materiid'        => 'required|exists:materi,idmateri',
            'judul_submateri' => 'required|string|max:255',
            'isi'             => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $idsubmateri = decrypt($id); // Jika ID dalam URL terenkripsi, dekripsi dulu

            $affectedRows = DB::table('submateri')
                ->where('idsubmateri', $idsubmateri) // Gunakan hasil dekripsi
                ->update([
                    'materiid'        => $request->materiid,
                    'judul_submateri' => $request->judul_submateri,
                    'isi'             => $request->isi,
                    'updated_at'      => now(),
                ]);

            DB::commit();

            // Jika tidak ada baris yang diperbarui, kirim pesan warning
            if ($affectedRows === 0) {
                return redirect()->route('admin.submateri.list')
                    ->with('warning', 'Tidak ada perubahan data!');
            }

            return redirect()->route('admin.submateri.list')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idsubmateri = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Materi tidak ditemukan');
        }

        $submateri = DB::table('submateri')->where('idsubmateri', $idsubmateri)->first();
        if (!$submateri) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Materi tidak ditemukan.');
        }

        try {
            DB::table('submateri')->where('idsubmateri', $idsubmateri)->delete();
            return redirect()->route('admin.submateri.list')
                ->with('success', 'Materi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.submateri.list')
                ->with('error', 'Terjadi kesalahan saat menghapus materi: ' . $e->getMessage());
        }
    }
}
