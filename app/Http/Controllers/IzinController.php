<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index(Request $request)
    {
        $query = Izin::query()->with(['user' => function ($q) {
            $q->select('id', 'nama');
        }]);
        if ($request->filled('status')) {
            $query = $query->where('status', $request->status);
        }
        $data = $query->latest()->paginate(10, ['id', 'user_id', 'tanggal_mulai', 'tanggal_selesai', 'jenis_izin', 'status']);

        return response()->json($data);
    }

    public function indexByUser(Request $request)
    {
        $data = Izin::with(['user' => function ($q) {
            $q->select('id', 'nama');
        }])->where('user_id', auth()
        ->user()->id)
        ->latest()
        ->paginate(10, ['id', 'user_id', 'tanggal_mulai', 'tanggal_selesai', 'jenis_izin', 'status']);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'jenis_izin' => 'required',
            'alasan' => 'required',
        ]);

        Izin::create([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_izin' => $request->jenis_izin,
            'alasan' => $request->alasan,
            'user_id' => auth()->user()->id,
            'status' => 'diajukan'
        ]);

        return response()->json(['message' => 'Izin created  successfully']);
    }

    public function show(string $id)
    {
        $data = Izin::find($id);

        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
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
        $izin = Izin::find($id);
        $izin->delete();

        return response()->json(['message' => 'Izin deleted successfully']);
    }

    public function accept(string $id, Request $request)
    {
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
}
