<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IzinController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('list-izin');

        $query = Izin::query()->with(['user' => function ($q) {
            $q->select('id', 'nama');
        }]);
        if ($request->filled('status')) {
            $query = $query->where('status', $request->status);
        }

        if (auth()->user()->level == 2) {
            $query = $query->where('user_id', auth()->user()->id);
        }
        $data = $query->latest()->paginate(10, ['id', 'user_id', 'tanggal_mulai', 'tanggal_selesai', 'jenis_izin', 'status']);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        Gate::authorize('create-izin');

        $request->validate([
            'tanggal_mulai' => 'required',
            'jenis_izin' => 'required',
            'alasan' => 'required',
        ]);

        $tglSelesai = $request->tanggal_selesai ?? $request->tanggal_mulai;

        Izin::create([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $tglSelesai,
            'jenis_izin' => $request->jenis_izin,
            'alasan' => $request->alasan,
            'user_id' => auth()->user()->id,
            'status' => 'diajukan'
        ]);

        return response()->json(['message' => 'Izin created  successfully']);
    }

    public function show(string $id)
    {
        Gate::authorize('show-izin');

        $data = Izin::with(['user' => function ($q) {
            $q->select('id', 'nama');
        }])->find($id);

        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        Gate::authorize('update-izin');
        
        $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'jenis_izin' => 'required',
            'alasan' => 'required',
        ]);

        $izin = Izin::find($id);
        $izin->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_izin' => $request->jenis_izin,
            'alasan' => $request->alasan,
        ]);

        return response()->json(['message' => 'Izin updated successfully']);
    }

    public function destroy(string $id)
    {
        Gate::authorize('delete-izin');
        
        $izin = Izin::find($id);
        $izin->delete();

        return response()->json(['message' => 'Izin deleted successfully']);
    }

    public function accept(string $id, Request $request)
    {
        Gate::authorize('accept-izin');
        
        $request->validate([
            'komentar' => 'required'
        ]);

        $izin = Izin::find($id);
        $izin->update([
            'status' => 'diterima',
            'komentar' => $request->komentar
        ]);

        return response()->json(['message' => "Izin status changed to 'diterima'"]);
    }

    public function reject(string $id, Request $request)
    {
        Gate::authorize('reject-izin');
        
        $request->validate([
            'komentar' => 'required'
        ]);

        $izin = Izin::find($id);
        $izin->update([
            'status' => 'ditolak',
            'komentar' => $request->komentar
        ]);

        return response()->json(['message' => "Izin status changed to 'ditolak'"]);
    }

    public function revise(string $id, Request $request)
    {
        Gate::authorize('revise-izin');
        
        $request->validate([
            'komentar' => 'required'
        ]);

        $izin = Izin::find($id);
        $izin->update([
            'status' => 'direvisi',
            'komentar' => $request->komentar
        ]);

        return response()->json(['message' => "Izin status changed to 'direvisi'"]);
    }

    public function cancel(string $id)
    {
        Gate::authorize('cancel-izin');
        
        $izin = Izin::find($id);
        $izin->update([
            'status' => 'dibatalkan',
        ]);

        return response()->json(['message' => "Izin status changed to 'dibatalkan'"]);
    }
}
