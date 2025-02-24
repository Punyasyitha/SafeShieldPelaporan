<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstStatus extends Model
{
    use HasFactory;

    protected $table = 'mst_sts_pengaduan';
    protected $primaryKey = 'idstatus';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_status',
        'user_create',
        'user_update',
    ];
}