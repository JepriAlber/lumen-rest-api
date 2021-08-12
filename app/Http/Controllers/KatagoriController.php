<?php

namespace App\Http\Controllers;

use App\Models\Katagori;
use Illuminate\Http\Request;

class KatagoriController extends Controller
{
    public function index()
    {
        $katagori   = Katagori::all();
        
        return response()->json([
            'success' => True,
            'message' => 'Data Katagori',
            'data'    => $katagori
        ],200);

    }

    public function show($id)
    {
        $katagori   = Katagori::find($id);
            if ($katagori) {
                return response()->json([
                    'success' => True,
                    'message' => 'Detail Katagori',
                    'data'    => $katagori
                ],200);
            }else{
                return response()->json([
                    'success' => False,
                    'message' => 'Katagori not found!',
                    'data'    => ''
                ],404);
            }
    }
    
    public function create(Request $request)
    {
        $this->validate($request,[
            'jenis_katagori' => 'string|required'
        ]);
        $data   = $request->all();

            $katagori   = Katagori::create($data);
            if ($katagori) {
                return response()->json([
                    'success' => True,
                    'messager'=> 'Data save successfully',
                    'data'    => $katagori
                ],201);
            }else{
                return response()->json([
                    'success'   => False,
                    'message'   => 'Data failed to save',
                    'data'      => ''
                ],400);
            }
    }

    public function update(Request $request, $id)
    {
        //cek terlebih dahulu apakah data dengan id yang di inginkan ada atau tidak jika tidak ada kasih respon jika ada lanjutkan proses
        $katagori   = Katagori::find($id);
            if (!$katagori) {
                return response()->json([
                    'success' => False,
                    'message' => 'Data Katagori not found!',
                    'data'    => ''
                ],404);
            }
        $this->validate($request,[
            'jenis_katagori' => 'string|required'
        ]);
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
