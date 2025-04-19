<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    protected $primaryKey = 'idartikel';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'idartikel',
        'penulisid',
        'judul_artikel',
        'tanggal_rilis',
        'gambar',
        'status',
    ];

    /**
     * Relasi ke tabel mst_penulis
     */
    public function penulis()
    {
        return $this->belongsTo(MstPenulis::class, 'penulisid', 'idpenulis');
    }
}
