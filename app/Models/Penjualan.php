<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $guarded = ['id'];

    /**
     * Relasi ke model User (Kasir)
     */
    public function user()
    {
        // Parameter kedua ('user_id') adalah nama kolom foreign key di tabel penjualan.
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model ItemPenjualan
     */
    public function itemPenjualan()
    {
        // Parameter kedua ('penjualan_id') sesuaikan dengan foreign key di tabel item_penjualan
        return $this->hasMany(ItemPenjualan::class, 'penjualan_id');
    }
}