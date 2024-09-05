<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'user' => auth()->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    public function register (Request $request) {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'password' => 'required'
        ]);

        $hashed_password = Hash::make($request->password);
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'password' => $hashed_password,
            'level' => 2,
            'verified_at' => null,
        ]);

        return response()->json(['message' => 'Register success']);
    }

    public function getLoggedUser() {
        if (!auth()->user()) {
            return response()->json(['error'=>'Unauthorized'], 401);
        } else {
            return response()->json(auth()->user());
        }
    }

    public function refresh()
    {
        return response()->json([
            'user' => auth()->user(),
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
    
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function changePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $user = auth()->user();

        if (Hash::check($request->old_password, $user->password)) {
            User::find(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json(['message' => 'Password updated successfully']);
        } else {
            return response()->json(['message' => 'Old password you enter does not match in our records'], 400);
        }
    }
}
