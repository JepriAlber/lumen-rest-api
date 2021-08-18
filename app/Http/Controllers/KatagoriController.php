<?php

namespace App\Http\Controllers;

use App\Models\Katagori;
use Illuminate\Http\Request;

class KatagoriController extends Controller
{
    public function index()
    {
        //mengambil semua data pada tabel katagori
        $katagori   = Katagori::all();
        //menghirim data yang terdapat pada variabel katagori dengan format json
        return response()->json([
            'success' => True,
            'message' => 'Data Katagori',
            'data'    => $katagori
        ],200);

    }

    public function show($id)
    {
        //cari katagori berdasarkan id yang ditentukan
        $katagori   = Katagori::find($id);
            //jika terdapat data maka kirim data yang berisi data katagori dengan format json
            if ($katagori) {
                return response()->json([
                    'success' => True,
                    'message' => 'Detail Katagori',
                    'data'    => $katagori
                ],200);
            }
            //jika tidak ditemui katagori dengan id yang diinginkan maka kirim data kosong
            else{
                return response()->json([
                    'success' => False,
                    'message' => 'Katagori not found!',
                    'data'    => ''
                ],404);
            }
    }
    
    public function create(Request $request)
    {
        //lakukan validasi terlebih dahulu, apakah inputan jenis katagori  sesuai validasi atau tidak 
        $this->validate($request,[
            'jenis_katagori' => 'string|required'
        ]);
        //tampung data inputan di varibel data
        $data   = $request->all();
            //simpan data di tabel katagori dengan data yang dinputkan
            $katagori   = Katagori::create($data);
            //cek kondisi apakan penyimpanan ketabel katagori berhasil atau tidak jika berhasil beri respon
            if ($katagori) {
                return response()->json([
                    'success' => True,
                    'messager'=> 'Data save successfully!',
                    'data'    => $katagori
                ],201);
            }
            //jika penyimpanan data gagal maka kirim respon dan data kosong
            else{
                return response()->json([
                    'success'   => False,
                    'message'   => 'Data failed to save!',
                    'data'      => ''
                ],400);
            }
    }

    public function update(Request $request, $id)
    {
        //cek terlebih dahulu apakah data dengan id yang di inginkan ada atau tidak jika tidak ada kasih respon jika ada lanjutkan proses
        $katagori   = Katagori::find($id);
            //cek apakah data katagori dengan id diingikan ada atau tidak, jika tidak ada kirim respon dengan data kosong
            if (!$katagori) {
                return response()->json([
                    'success' => False,
                    'message' => 'Data Katagori not found!',
                    'data'    => ''
                ],404);
            }
        //lakukan validasi data yang dinputkan terlebih dahulu apakah data yang inputan untuk di edit sudah sesuai format atau tidak
        $this->validate($request,[
            'jenis_katagori' => 'string|required'
        ]);
        //simpan data inputan di variabel data
        $data   = $request->all();
        //isi data sesuai model
        $katagori->fill($data);
        //simpan kedatabase
        $katagori->save();
            //beri respon kalau data berhasil atau gagal
            if ($katagori) {
                return response()->json([
                    'success' => True,
                    'message' => 'Data changed successfully!',
                    'data'    => $katagori,
                ],201);
            }else{
                return response()->json([
                    'success'   => False,
                    'message'   => 'Data failed to changed!',
                    'data'      => ''
                ],400);
            }
            
    }

    public function destroy($id)
    {
        //cek data dengan id yang diinginkan apakah datanya ada atau tidak
        $katagori   = Katagori::find($id);
        //cek apakah data dengan id diinginkan ada atau tidak
            if (!$katagori) {
                return response()->json([
                    'success' => False,
                    'message' => 'Data katagori not found!',
                    'data'    => ''
                ],200);
            }
        //jika  data ditemukan lanjutkan proses delete data
        $katagori->delete();
        return response()->json([
            'success'   => True,
            'message'   => 'Produk delete successfully'
        ],200);    
    }
}
