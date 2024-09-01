<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('read-user')) {
            abort(403);
        }
        
        $query = User::query();
        if ($request->filter == 'verified') {
            $query = $query->whereNotNull('verified_at');
        }
        if ($request->filter == 'unverified') {
            $query = $query->whereNull('verified_at');
        }

        if (auth()->user()->level == 1) {
            $query = $query->where('level', 2);
        }

        $all = $query->paginate(20, ['id', 'nama', 'email', 'level', 'verified_at'])->withQueryString();

        return response()->json($all);
    }

    public function createVerifikator(Request $request)
    {
        if (!Gate::allows('create-verifikator')) {
            abort(403);
        }
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'password' => 'required'
        ]);

        User::create(array_merge($request->all(), ['level' => 1]));

        return response()->json(['message' => 'Add verifikator success']);
    }

    public function promoteUser(string $id) {
        if (!Gate::allows('promote-user')) {
            abort(403);
        }

        User::find($id)->update([
            'level' => 1
        ]);

        return response()->json(['message' => 'Change user to verifikator success']);
    }

    public function verify(string $id) {
        if (!Gate::allows('verify-user')) {
            abort(403);
        }

        User::find($id)->update([
            'verified_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Verify user success']);
    }

}
