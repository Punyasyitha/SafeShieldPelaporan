<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenulisController extends Controller
{
    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/penulis'),
            'list' => DB::table('mst_penulis')->orderBy('idpenulis', 'asc')->paginate(10),
        ];

        return view('admin.master.penulis.list', $data);
    }

    public function add()
    {
        return view('admin.master.penulis.add', [
            'authorize' => (object)['add' => '1'],
            'url' => 'admin/master/penulis'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpenulis' => 'nullable',
            'nama_penulis' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $newId = DB::table('mst_penulis')->max('idpenulis') + 1;

            DB::table('mst_penulis')->insert([
                'idpenulis'    => $newId,
                'nama_penulis' => $request->nama_penulis,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.master.penulis.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idpenulis = decrypt($id);
            $penulis = DB::table('mst_penulis')->where('idpenulis', $idpenulis)->first();

            if (!$penulis) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Data tidak ditemukan.');
            }

            return view('admin.master.penulis.show', [
                'penulis' => $penulis,
                'url' => 'admin/master/penulis'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idpenulis = decrypt($id);
            $penulis = DB::table('mst_penulis')->where('idpenulis', $idpenulis)->first();

            if (!$penulis) {
                return redirect()->route('admin.master.penulis.list')->with('error', 'Data tidak ditemukan.');
            }

            return view('admin.master.penulis.edit', compact('penulis'));
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_penulis' => 'required|string|max:100',
            ]);

            $idpenulis = decrypt($id);

            $updated = DB::table('mst_penulis')
                ->where('idpenulis', $idpenulis)
                ->update([
                    'nama_penulis' => $request->nama_penulis,
                    'updated_at'   => now(),
                ]);

            if ($updated) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('success', 'Penulis berhasil diperbarui.');
            } else {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Data tidak berubah.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idpenulis = decrypt($id);
            $penulis = DB::table('mst_penulis')->where('idpenulis', $idpenulis)->first();
            if (!$penulis) {
                return redirect()->route('admin.master.penulis.list')
                    ->with('error', 'Data tidak ditemukan.');
            }

            DB::table('mst_penulis')->where('idpenulis', $idpenulis)->delete();

            return redirect()->route('admin.master.penulis.list')
                ->with('success', 'Penulis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
        try {
            $idpenulis = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }

        $penulis = DB::table('mst_penulis')->where('idpenulis', $idpenulis)->first();
        if (!$penulis) {
            return redirect()->route('admin.master.penulis.list')
                ->with('error', 'Data tidak ditemukan.');
        }

        try {
            DB::table('mst_penulis')->where('idpenulis', $idpenulis)->delete();
            return redirect()->route('admin.master.penulis.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.penulis.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}