<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $primaryKey = 'idmateri';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'idmateri',
        'modulid',
        'kategoriid',
        'judul_materi',
        'sumber',
    ];

    /**
     * Relasi ke tabel mst_mopdul dan mst_kategori
     */
    public function modul()
    {
        return $this->belongsTo(MstModul::class, 'modulid', 'idmodul');
    }

    public function kategori()
    {
        return $this->belongsTo(MstKategori::class, 'kategoriid', 'idkategori');
    }

    public function submateris()
    {
        return $this->hasMany(SubMateri::class, 'materiid', 'idmateri');
    }
}