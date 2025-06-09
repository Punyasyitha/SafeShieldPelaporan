<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    // Nama tabel
    protected $table = 'pengaduan';

    // Primary key
    protected $primaryKey = 'idpengaduan';

    // Karena primary key bukan incrementing integer
    public $incrementing = false;
    protected $keyType = 'string';

    // Mass assignable attributes
    protected $fillable = [
        'idpengaduan',
        'statusid',
        'nama_pengadu',
        'no_telepon',
        'email',
        'nama_terlapor',
        'tmp_kejadian',
        'tanggal_kejadian',
        'detail',
        'bukti',
        'keterangan',
        'captcha',
    ];

    // Relasi ke tabel status
    public function status()
    {
        return $this->belongsTo(MstStatus::class, 'statusid', 'idstatus');
    }

    // Laporan.php
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}