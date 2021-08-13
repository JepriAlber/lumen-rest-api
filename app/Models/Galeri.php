<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table        = 'galeri';
    protected $primaryKey   = 'galeri_id';

        protected $fillable = [
            'produk_id','gambar'
        ];
    
    public function produk()
    {
        $this->belongsTo(Produk::class,'produk_id','galeri_id');
    }
}
