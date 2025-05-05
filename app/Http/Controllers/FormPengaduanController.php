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
        // Validasi data
        //dd($request->all());
        $request->validate([
            'nama_pengadu'     => 'required|string|max:100',
            'no_telepon'       => 'required|string|max:20',
            'email'            => 'nullable|email',
            'nama_terlapor'    => 'required|string|max:100',
            'tmp_kejadian'     => 'required|string|max:300',
            'tanggal_kejadian' => 'required|date',
            'detail'           => 'required|string',
            'bukti'            => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mp3,wav|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // Generate ID baru
            $lastId = DB::table('pengaduan')->max('idpengaduan');
            $newId = $lastId ? $lastId + 1 : 1;

            $buktiPath = null;

            // Simpan file bukti jika ada
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $filename = time() . '_' . $file->getClientOriginalName();

                $buktiPath = $file->storeAs('bukti_pengaduan', $filename, 'public'); // Simpan ke storage/app/public/bukti_pengaduan
            }

            // Simpan data ke database
            DB::table('pengaduan')->insert([
                'idpengaduan'      => $newId,
                'statusid'         => '1',
                'nama_pengadu'     => $request->nama_pengadu,
                'no_telepon'       => $request->no_telepon,
                'email'            => $request->email,
                'nama_terlapor'    => $request->nama_terlapor,
                'tmp_kejadian'     => $request->tmp_kejadian,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'detail'           => $request->detail,
                'bukti'            => $buktiPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('user.pengaduan')->with('success', 'Data berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.pengaduan')->with('error', 'Gagal mengirimkan data: ' . $e->getMessage());
        }
    }
}
