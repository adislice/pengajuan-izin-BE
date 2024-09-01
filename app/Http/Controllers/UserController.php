<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('read-user')) {
            abort(403);
        }
        $all = User::paginate(20, ['id', 'nama', 'email', 'level'])->withQueryString();

        return response()->json($all);
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
