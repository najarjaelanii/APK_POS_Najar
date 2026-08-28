<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory as FactoriesHasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use FactoriesHasFactory;
    protected $table = 'penjualan';
     protected $fillable = [
        'user_id',
        'total_pembayaran',
        'metode_pembayaran',
        'status',
       
    ];

    public function role()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
      public function itemPenjualan()
    {
        return $this->hasMany(itemPenjualan::class, 'penjualan_id');
    }
}
