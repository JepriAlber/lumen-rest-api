<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk    = Produk::with(['katagori'])->get();
        //kirim data dengan res api get format json untuk menampilkan data produk
        return response()->json([
            'succeess'  => True,
            'message'   => 'Data Produk',
            'data'      => $produk
        ],200);
    }

    public function show($id)
    {
        $produk    = Produk::find($id);
        //jika data ada maka kirim data dengan rest api get format json jika tidak kosongkan data yang ditampilkan
            if ($produk) {
                return response()->json([
                    'success'   => True,
                    'message'   => 'Detail Produk',
                    'data'      => $produk
                ],200);
            }else{
                return response()->json([
                    'success'   => False,
                    'message'   => 'Produk not found!',
                    'data'      => ''
                ],404);
            }
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'nama'      => 'required|string',
            'harga'     => 'required|integer',
            'warna'     => 'required|string',
            'kondisi'   => 'required|in:baru,lama',
            'deskripsi' => 'string'
        ]);
        $data   = $request->all();
        $produk = Produk::create($data);
            //jika data berhasil disimpan maka kirim respon kalau data berhasil dikirimkan dengan status 201
            if ($produk) {
                return response()->json([
                    'success'   => True,
                    'message'   => 'Data save successfully!',
                    'data'      => $produk
                ],201);
            }else{
                return response()->json([
                    'success'   => False,
                    'message'   => 'Data failed to save',
                    'data'      => ''
                ],400);
            }
            
    }
    
    public function update(Request $request,$id){
        
        $produk     = Produk::find($id);
        //cek apakah ada data dengan id yang diinputkan atau tidak
        if (!$produk) {
            return response()->json([
                'success'   => False,
                'message'   =>'Produk not found.!',
                'data'      => ''
            ],404);
        }

        $this->validate($request,[
            'nama'      => 'string',
            'harga'     => 'integer',
            'warna'     => 'string',
            'kondisi'   => 'in:baru,lama',
            'deskripsi' => 'string'
        ]);

        $data       = $request->all();
        //isi data di model
        $produk->fill($data);
        //simpan data yang diset ke databases
        $produk->save();
        //jika produk berhasil di edit maka kirim respon
        if ($produk) {
            return response()->json([
                'success'   => True,
                'message'   => 'Data changed successfully',
                'data'      => $produk
            ],200);
        }else{
            return response()->json([
                'success'   => False,
                'message'   => 'Data failed to changed!',
                'data'      => ''
            ],400);
        }
        
    }
    //method atau fungsi yang digunakan untk menampilkan produk pictures, one to many
    public function images($id)
    {
        $produk     = Produk::with(['galeri'])->where('produk_id','=',$id)->get();
            if ($produk) {
                return response()->json([
                    'success' => True,
                    'message' => 'Product pictures',
                    'data'    => $produk
                ],201);
            }else{
                return response()->json([
                    'success' => False,
                    'message' => 'Data not found',
                    'data'    => ''
                ],404);
            }
    }

    public function destroy($id)
    {
        $produk     = Produk::find($id);
        //jika produk dengan id diinginkan tidak ada maka beri respon produk tidak ada
        if (!$produk) {
            return response()->json([
                'success'   => False,
                'message'   => 'Produk not found!',
                'data'      => ''
            ],404);
        }
        //jika ada produk dengan id yang diinginkan maka hapus produk tersebut dan beri respon
        $produk->delete();
        return response()->json([
            'success'   => True,
            'message'   => 'Produk delete successfully'
        ],200);
    }
}
