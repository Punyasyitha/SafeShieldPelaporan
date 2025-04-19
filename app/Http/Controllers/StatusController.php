<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index()
    {
        $data = [
            'authorize' => (object)['add' => '1'],
            'url' => url('admin/master/status'),
            'list' => DB::table('mst_sts_pengaduan')->orderBy('idstatus', 'asc')->paginate(10),
        ];

        return view('admin.master.status.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('admin.master.status.add', [
            'authorize' => $authorize,
            'url' => 'admin/master/status'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idstatus' => 'nullable',
            'nama_status' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $newId = DB::table('mst_sts_pengaduan')->max('idstatus') + 1;

            DB::table('mst_sts_pengaduan')->insert([
                'idstatus'    => $newId,
                'nama_status' => $request->nama_status,
            ]);

            DB::commit();

            return redirect()->route('admin.master.status.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $idstatus = decrypt($id);
            $status = DB::table('mst_sts_pengaduan')->where('idstatus', $idstatus)->first();

            if (!$status) {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Data tidak ditemukan.');
            }

            return view('admin.master.status.show', [
                'status' => $status,
                'url' => 'admin/master/status'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idstatus = decrypt($id);
            $status = DB::table('mst_sts_pengaduan')->where('idstatus', $idstatus)->first();

            if (!$status) {
                return redirect()->route('admin.master.status.list')->with('error', 'Data tidak ditemukan.');
            }

            return view('admin.master.status.edit', compact('status'));
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
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
                return redirect()->route('admin.master.status.list')
                    ->with('success', 'Status berhasil diperbarui.');
            } else {
                return redirect()->route('admin.master.status.list')
                    ->with('error', 'Data tidak berubah.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $idstatus = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }
        $status = DB::table('mst_sts_pengaduan')->where('idstatus', $idstatus)->first();
        if (!$status) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Data tidak ditemukan.');
        }

        try {
            DB::table('mst_sts_pengaduan')->where('idstatus', $idstatus)->delete();
            return redirect()->route('admin.master.status.list')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.master.status.list')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}