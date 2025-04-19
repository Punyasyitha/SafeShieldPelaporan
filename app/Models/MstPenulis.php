<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MstPenulis extends Model
{
    use HasFactory;

    protected $table = 'mst_penulis';
    protected $primaryKey = 'idpenulis';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_penulis',
    ];

    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'penulisid', 'idpenulis');
    }
}
