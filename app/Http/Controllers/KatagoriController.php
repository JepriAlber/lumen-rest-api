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
                    'success'   => True,
                    'message'   => 'Data failed to save',
                    'data'      => ''
                ],400);
            }


    }
}
