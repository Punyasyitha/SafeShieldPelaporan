<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

// Fix: extends Model supaya bisa menggunakan fitur Eloquent ORM
class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'users';

    // Fix: tambahkan properti untuk mengatur kolom yang bisa diisi
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'remember_token'
    ];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    // Fix: pengecekan password hash
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token ?? null;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
