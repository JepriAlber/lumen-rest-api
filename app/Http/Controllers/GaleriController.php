<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GaleriController extends Controller
{
    public function index()
    {   
        //ambil semua data di tabel galeri dan simpan di tampung varibel gambar
        $gambar     = Galeri::all();
            //kirim data dengan format json
            if ($gambar) {
                return response()->json([
                    'success'   => True,
                    'message'   => 'Data images produk',
                    'data'      => $gambar
                ],200);
            }
    }

    public function show($id)
    {
        //ambil semua data galeri dengan id yang inginkan dan di tampung divariabel gambarproduk
        $gambarProduk   = Galeri::find($id);
            //kemudian sebelum kirim data lakukan pengecekan terlebih dahulu
            if ($gambarProduk) {
                return response()->json([
                        'success'   => True,
                        'message'   => 'Detail images produk',
                        'data'      => $gambarProduk
                    ],200);               
                }else{
                    return response()->json([
                        'success'   => False,
                        'message'   => 'Images produk not found!',
                        'data'      => ''
                    ],404);
                }
    }

    public function create(Request $request)
    {
        //lakukan validasi data yang diinputkan
        $this->validate($request,[
            'produk_id'     => 'required',
            'gambar'        => 'file|mimes:jpg,jpeg,png|max:2280|required'
        ]);
        //tampung data yang sudah di validasi dengan varibel data
        $data   = $request->all();
            //cek apakah ada foto atau tidak
            if ($request->hasFile('gambar')) {
                //nama asli gambar
                $namaAsli      =  $request->file('gambar')->getClientOriginalName();
                //pisahkan nama file dengan extensinya
                $explode        = explode('.',$namaAsli);
                $namaGambar     = $explode[0];
                //ambil extension gambar apakah dia png, jpeg ,dll
                $fileExt       = $request->file('gambar')->getClientOriginalExtension();
                //lakukan perobahan nama gambar
                $namaGambarBaru = $namaGambar.'_'.time().'.'.$fileExt;
                //simpan gambarnya di public/gambar_produk
                $request->file('gambar')->move('gambar_produk',$namaGambarBaru);
                //isi data[gambar] dengan nama gambar yang baru beserta lokasi url dan akan disimpan ke tabel
                $data['gambar'] = url('gambar_produk'.'/'.$namaGambarBaru);    
            }
            //jika user tidak menginputkan gambar maka kirim response
            else{
                return response()->json([
                    'success' => False,
                    'message' => 'Images not found!',
                    'data'    => ''
                ],404);
            }
        //lalu simpan data ditabel galeri
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
            //jika data tidak ditemukan maka beri respon
            if (!$galeri) {
                return response()->json([
                    'status'    => False,
                    'message'   => 'Galeri produk not found!',
                    'data'      => '' 
                ],404);
            }
        //lakukan validasi kepada data yang diinputkan
        $this->validate($request,[
            'produk_id'     => 'required',
            'gambar'        => 'file|mimes:jpg,jpeg,png|max:2280'
        ]);
        //simpan data yang sudah divalidasi ke variabel data
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

                        //pisahkan url gambar untuk mendapatkan lokasi storage dan nama gambarnya
                $urlGambar = explode('/',$galeri['gambar']);
                //maka dapatlat lokasi gambar beserta gambarnya
                $destination = $urlGambar[3].'/'.$urlGambar[4];
                    //cek terlebih dahulu apakah ada file gambar atau tidak
                    if (File::exists($destination)) {
                        //jika ada hapus gambar di storage
                        File::delete($destination);
                    }

                //simpan data baru tampa gambar baru
                $galeri->fill($data);
                $galeri->save();
                    //lakukan pengecekan apakah data berhasil disimpang di tabel atau tidak
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
                    //lakukan pengecekan apakah data berhasil disimpan atau tidak
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
    
    public function destroy($id)
    {
        //ambil data galeri dengan id yang diingkan dan simpan di varibel galeri
        $galeri = Galeri::find($id);
            //jika data tidak ada dengan id yang tidak dinginkan maka beri respon
            if (!$galeri) {
                return response()->json([
                    'success' => False,
                    'message' => 'Data not found!',
                    'data'    => ''
                ],404);
            }
        
        //pisahkan url gambar untuk mendapatkan lokasi storage dan nama gambarnya
        $urlGambar = explode('/',$galeri['gambar']);
        //maka dapatlat lokasi gambar beserta gambarnya
        $destination = $urlGambar[3].'/'.$urlGambar[4];
            //cek terlebih dahulu apakah ada file gambar atau tidak
            if (File::exists($destination)) {
                //jika ada hapus gambar di storage
                File::delete($destination);
            }
        //lakukan delete data
        $galeri->delete();
        return response()->json([
            'success' => True,
            'message' => 'Galeri delete successfully'
        ],200);
    }

}
