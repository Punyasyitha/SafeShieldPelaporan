<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MstKategori extends Model
{
    use HasFactory;

    protected $table = 'mst_kategori';
    protected $primaryKey = 'idkategori';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_kategori',
    ];

    public function materis()
    {
        return $this->hasMany(Materi::class, 'kategoriid', 'idkategori');
    }
}
