<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FormPengaduanController extends Controller
{
    function add()
    {
        return view('user.pengaduan.add');
    }

    function index()
    {
        $userid = Auth::id();
        $data = [
            'url' => url('user/progress'),
            'list' => DB::table('pengaduan')
                ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
                ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status')
                ->where('pengaduan.userid', $userid)
                ->orderBy('pengaduan.idpengaduan', 'asc')
                ->paginate(10),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan' => 'bg-orange-200 text-orange-800',
                'Tinjauan' => 'bg-yellow-200 text-yellow-800',
                'Final' => 'bg-blue-200 text-blue-800',
                'Selesai' => 'bg-green-200 text-green-800',
            ],
        ];
        //dd($data['list']);

        return view('user.pengaduan.list', $data);
    }

    public function store(Request $request)
    {
        // Validasi data
        //dd($request->all());
        $userid = Auth::id();
        $request->validate([
            'nama_pengadu'     => 'required|string|max:100',
            'no_telepon'       => 'required|string|max:20',
            'email'            => 'nullable|email',
            'nama_terlapor'    => 'required|string|max:100',
            'tmp_kejadian'     => 'required|string|max:300',
            'tanggal_kejadian' => 'required|date',
            'detail'           => 'required|string',
            'bukti'            => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mp3,wav|max:5120',
            'g-recaptcha-response' => 'required|captcha',
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
                'userid'           => $userid,
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

            return redirect()->route('user.pengaduan.add')->with('success', 'Data berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.pengaduan.add')->with('error', 'Gagal mengirimkan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $idpengaduan = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Form tidak ditemukan');
        }

        $pengaduan = DB::table('pengaduan')
            ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
            ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status')
            ->where('pengaduan.idpengaduan', $idpengaduan)
            ->first();

        if (!$pengaduan) {
            abort(404, 'Form tidak ditemukan');
        }

        $data = [
            'pengaduan' => $pengaduan,
            'url' => url('user/progress'),
            'list' => DB::table('pengaduan')
                ->join('mst_sts_pengaduan', 'pengaduan.statusid', '=', 'mst_sts_pengaduan.idstatus')
                ->select('pengaduan.*', 'mst_sts_pengaduan.nama_status')
                ->orderBy('pengaduan.idpengaduan', 'asc')
                ->paginate(10),
            'warnaStatus' => [
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan' => 'bg-orange-200 text-orange-800',
                'Tinjauan' => 'bg-yellow-200 text-yellow-800',
                'Final' => 'bg-blue-200 text-blue-800',
                'Selesai' => 'bg-green-200 text-green-800',
            ],
        ];

        return view('user.pengaduan.edit', $data);
    }

    public function update(Request $request, $id)
    {
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
            $idpengaduan = decrypt($id); // Dekripsi ID

            // Ambil data lama untuk dapatkan file bukti sebelumnya
            $pengaduan = DB::table('pengaduan')->where('idpengaduan', $idpengaduan)->first();

            if (!$pengaduan) {
                abort(404, 'Data tidak ditemukan');
            }

            $buktiPath = $pengaduan->bukti;

            // Jika ada file baru, upload dan timpa path lama
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $filename = time() . '_' . $file->getClientOriginalName();
                $buktiPath = $file->storeAs('bukti_pengaduan', $filename, 'public');
            }

            DB::table('pengaduan')->where('idpengaduan', $idpengaduan)->update([
                'nama_pengadu'     => $request->nama_pengadu,
                'no_telepon'       => $request->no_telepon,
                'email'            => $request->email,
                'nama_terlapor'    => $request->nama_terlapor,
                'tmp_kejadian'     => $request->tmp_kejadian,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'detail'           => $request->detail,
                'bukti'            => $buktiPath,
                'updated_at'       => now(),
            ]);

            DB::commit();

            return redirect()->route('user.pengaduan.list')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.pengaduan.list')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}
