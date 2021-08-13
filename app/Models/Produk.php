<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model 
{
    protected $table ='produk';
    protected $primaryKey = 'produk_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'katagori_id','nama', 'harga','warna','kondisi','deskripsi'
    ];
    
    public function katagori()
    {
        return $this->belongsTo(Katagori::class,'katagori_id','produk_id');
    }

    public function galeri()
    {
        return $this->hasMany(Galeri::class,'produk_id','produk_id');
    }
    
}
