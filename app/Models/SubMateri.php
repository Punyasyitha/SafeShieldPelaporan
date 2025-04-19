<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubMateri extends Model
{
    use HasFactory;

    protected $table = 'submateri';
    protected $primaryKey = 'idsubmateri';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'idsubmateri',
        'materiid',
        'judul_submateri',
        'isi',
    ];

    /**
     * Relasi ke tabel mst_penulis
     */
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materiid', 'idmateri');
    }
}
