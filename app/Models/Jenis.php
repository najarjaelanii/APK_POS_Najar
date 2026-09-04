<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;

    // Tambahkan baris ini jika tabel di DB bernama 'jenis'
    protected $table = 'jenis'; 

    protected $fillable = ['nama_jenis'];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'jenis_id');
    }
}