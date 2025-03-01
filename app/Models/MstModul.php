<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstModul extends Model
{
    use HasFactory;

    protected $table = 'mst_modul';
    protected $primaryKey = 'idmodul';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_modul',
        'deskripsi',
        'tahun_terbit',
    ];
}
