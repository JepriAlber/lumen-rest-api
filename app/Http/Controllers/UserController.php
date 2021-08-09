<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request,[
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6'
        ]);
        //ambil data dari inputan di body
        $email       = $request->input('email');
        $password    = $request->input('password');
        $hashPassword= Hash::make($password);

        $user       = User::create([
            'email'     => $email,
            'password'  => $hashPassword
        ]);

        return response()->json(['message'=>'Successful Resgistration!'],201);
    }
    
    public function login(Request $request)
    {
        $this->validate($request,[
            'email'     => 'required|email',
            'password'  => 'required|min:6'
        ]);

        $email      = $request->input('email');
        $password   = $request->input('password');
        
        //cek terlebih dahulu apakah user memiliki akun atau tidak
        $user       = User::Where('email',$email)->first();
            if (!$user) {
                return response()->json(['message','Login Failed!'],401);
            }
        //jika user memiliki akun maka lakukan validasi password apakah password sesuai atau tidak
        $isValidPassword = Hash::check($password,$user->password);
            if (!$isValidPassword) {
                return response()->json(['message','Login Failed!'],401);
            }
        //jika user memiliki akun dan password yang sama maka generate token dan berikan token ke users
        $generateToken  = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);
        return response()->json($user);
    }
}