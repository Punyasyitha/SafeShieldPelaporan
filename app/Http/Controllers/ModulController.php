<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulController extends Controller
{
    public function index($data)
    {
        $data['authorize'] = (object)['add' => '1'];

        $data['list'] = DB::table('mst_modul')
            ->orderBy('idmodul', 'asc')
            ->paginate(10);

        return view('master.modul.list', $data);
    }

    public function add()
    {
        $authorize = (object)['add' => '1'];
        return view('master.modul.add', [
            'authorize' => $authorize,
            'url' => 'master/modul'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_modul'   => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        DB::beginTransaction();
        try {
            // Generate ID baru (pastikan formatnya sesuai kebutuhan)
            $newId = str_pad(DB::table('mst_modul')->max('idmodul') + 1, 10, '0', STR_PAD_LEFT);

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

            // Redirect ke list dengan alert sukses
            return redirect()->route('modul.list')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirect dengan alert error
            return redirect()->route('modul.list')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}