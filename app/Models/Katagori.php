<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katagori extends Model
{
    protected $table        = 'katagori';
    protected $primaryKey   = 'katagori_id';

        protected $fillable = [
            'jenis_katagori'
        ];
    
    //untuk relasi tabel produk dengan satu kategori banyak produk
    public function produk()
    {
        return $this->hasMany(Produk::class,'katagori_id','katagori_id');
    }
}
