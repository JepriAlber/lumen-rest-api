<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {   
        $gambar     = Galeri::all();
            
            if ($gambar) {
                return response()->json([
                    'success'   => True,
                    'message'   => 'Data gambar produk',
                    'data'      => $gambar
                ],200);
            }
    }

}
