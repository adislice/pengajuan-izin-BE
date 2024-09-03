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
        Gate::authorize('list-user');
        
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
        Gate::authorize('create-verifikator');

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
        Gate::authorize('promote-user');

        User::find($id)->update([
            'level' => 1
        ]);

        return response()->json(['message' => 'Change user to verifikator success']);
    }

    public function verify(string $id) {
        Gate::authorize('verify-user');

        User::find($id)->update([
            'verified_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Verify user success']);
    }

    public function show(string $id) {
        Gate::authorize('show-user');

        $data = User::find($id);

        return response()->json($data);
    }

}
