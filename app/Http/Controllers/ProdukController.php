<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk    = Produk::all();
        
        return response()->json($produk);
    }

    public function show($id)
    {
        $produk    = Produk::find($id);

        return response()->json($produk);
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
        return response()->json($produk);
    }
    
    public function update(Request $request,$id){
        
        $produk     = Produk::find($id);
        //cek apakah ada data dengan id yang diinputkan atau tidak
        if (!$produk) {
            return response()->json(['message'=>'Produk not found.!',404]);
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

        return response()->json($produk);
    }

    public function destroy($id)
    {
        $produk     = Produk::find($id);
        //jika produk dengan id diinginkan tidak ada maka beri respon produk tidak ada
        if (!$produk) {
            return response()->json(['message'=>'Produk not found!',404]);
        }
        //jika ada produk dengan id yang diinginkan maka hapus produk tersebut dan beri respon
        $produk->delete();
        return response()->json(['message'=>'Produk delete successfully']);
    }
}
