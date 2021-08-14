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

    public function create(Request $request)
    {
        $this->validate($request,[
            'produk_id'     => 'required',
            'gambar'        => 'file|mimes:jpg,jpeg,png|max:2280|required'
        ]);

        $data   = $request->all();
            //cek apakah ada foto atau tidak
            if ($request->hasFile('gambar')) {
                //nama asli gambar
                $namaAsli      =  $request->file('gambar')->getClientOriginalName();
                //pisahkan nama file dengan extensinya
                $explode        = explode('.',$namaAsli);
                $namaGambar     = $explode[1];
                $fileExt       = $request->file('gambar')->getClientOriginalExtension();
                $namaGambarBaru = $namaGambar.'_'.time().'.'.$fileExt;
                //simpan gambarnya di public/gambar_produk
                $request->file('gambar')->move('gambar_produk',$namaGambarBaru);
                //isi data[gambar] dengan nama gambar produk baru beserta lokasi tempat penyimpanan gambar
                $data['gambar'] = url('gambar_produk/'.$namaGambarBaru);
                
                    //cek terespon data apakah sudah sesuai dengan keinginan atau tidak
                    // return response()->json($data['gambar']);
            }else{
                return response()->json([
                    'success' => False,
                    'message' => 'Gambar not found!',
                    'data'    => ''
                ],404);
            }

        $gambarProduk   = Galeri::create($data);
            if ($gambarProduk) {
                return response()->json([
                    'success' => True,
                    'message' => 'Data save successfully',
                    'data'    => $data
                ],201);
            }else{
                return response()->json([
                    'success'   => False,
                    'message'   => 'Gambar failed to save',
                    'data'      => ''
                ],400);
            }
    }

}
