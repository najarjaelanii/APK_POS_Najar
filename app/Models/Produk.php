<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk menentukan nama tabel
    protected $table = 'produk'; 

    protected $fillable = [
        'user_id',
        'jenis_id',
        'foto',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok',
    ];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}