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

    public function show($id)
    {
        $gambarProduk   = Galeri::find($id);
        if ($gambarProduk) {
            return response()->json([
                    'success'   => True,
                    'message'   => 'Detail gambar produk',
                    'data'      => $gambarProduk
                ],200);               
            }else{
                return response()->json([
                    'success'   => False,
                    'message'   => 'Gambar produk not found!',
                    'data'      => ''
                ],404);
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
                //isi data[gambar] dengan nama gambar yang baru beserta lokasi
                $data['gambar'] = url('gambar_produk'.'/'.$namaGambarBaru);
                
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

    public function update(Request $request, $id)
    {
        //lakukan pengecekan data terlebih dahulu apakah data ada dengan id yang diinginkan
        $galeri    = Galeri::find($id);
            if (!$galeri) {
                return response()->json([
                    'status'    => False,
                    'message'   => 'Galeri produk not found!',
                    'data'      => '' 
                ],404);
            }

        $this->validate($request,[
            'produk_id'     => 'required',
            'gambar'        => 'file|mimes:jpg,jpeg,png|max:2280'
        ]);
    

        $data       = $request->all();

        return response()->json($data);
            // lakukan pengecekan terlebih dahulu apakah data baru menggunakan gambar yang baru atau gambar lama
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
                //isi data[gambar] dengan nama gambar yang baru beserta lokasi
                $data['gambar'] = url('gambar_produk'.'/'.$namaGambarBaru);

                //simpan data baru tampa gambar baru
                $galeri->fill($data);
                $galeri->save();

                    if ($galeri) {
                        return response()->json([
                            'success'   => True,
                            'message'   => 'Data changed successfully!',
                            'data'      => $galeri
                        ],201);
                    }else{
                        return response()->json([
                            'success'   => True,
                            'message'   => 'Data failed to changed!',
                            'data'      => ''
                        ],400);
                    }

            }else{
                //simpan data baru tampa gambar baru
                $galeri->fill($data);
                $galeri->save();

                    if ($galeri) {
                        return response()->json([
                            'success'   => True,
                            'message'   => 'Data changed successfully!',
                            'data'      => $galeri
                        ],201);
                    }else{
                        return response()->json([
                            'success'   => True,
                            'message'   => 'Data failed to changed!',
                            'data'      => ''
                        ],400);
                    }
            }
        
    }
    

}
