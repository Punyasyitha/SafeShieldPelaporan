<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FormPengaduanController extends Controller
{
    function pengaduan()
    {
        return view('user.pengaduan');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validasi data
        $request->validate([
            'nama_pengadu'   => 'required|string|max:100',
            'no_telepon'     => 'required|string|max:20',
            'email'          => 'required|email|unique:pengaduan,email',
            'nama_terlapor'  => 'required|string|max:100',
            'tmp_kejadian'   => 'required|string|max:300',
            'tanggal_kejadian' => 'required|date',
            'detail'         => 'required|string',
            'bukti'          => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mp3,wav|max:20480',
            'keterangan'     => '',
            'captcha'        => '',
        ]);

        DB::beginTransaction();
        try {
            // Generate ID baru (pastikan formatnya sesuai kebutuhan)
            $newId = DB::table('pengaduan')->max('idpengaduan') + 1;

            // Simpan file bukti jika ada
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                $originalName = pathinfo($request->file('bukti')->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $request->file('bukti')->getClientOriginalExtension();
                $filename = $originalName . '_' . time() . '.' . $extension;

                $buktiPath = $request->file('bukti')->storeAs('bukti_pengaduan', $filename, 'public');
            }

            // Simpan data ke database
            DB::table('pengaduan')->insert([
                'idpengaduan'    => $newId,
                'statusid'       => '1', // Default status awal
                'nama_pengadu'   => $request->nama_pengadu,
                'no_telepon'     => $request->no_telepon,
                'email'          => $request->email,
                'nama_terlapor'  => $request->nama_terlapor,
                'tmp_kejadian'   => $request->tmp_kejadian,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'detail'         => $request->detail,
                'bukti'          => $buktiPath,
                'keterangan'     => '',
                'captcha'        => '',
            ]);

            DB::commit();

            // ✅ Redirect dengan pesan sukses
            return redirect()->route('user.pengaduan')
                ->with('success', 'Data berhasil dikirim!');
        } catch (\Exception $e) {
            // ❌ Redirect dengan pesan error
            return redirect()->route('user.pengaduan')
                ->with('error', 'Gagal mengirimkan data: ' . $e->getMessage());
        }
    }
}
