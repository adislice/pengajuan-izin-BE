<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data = [];

        if (auth()->user()->level == 0) {
            $data['user_count'] = User::count();
        }

        switch (auth()->user()->level) {
            case 0:
                $data['user_count'] = User::count();
                $data['izin_count'] = Izin::count();
                break;
            case 1:
                $data['user_count'] = User::whereNull('verified_at')->count();
                $data['izin_count'] = Izin::where('status', 'diajukan')->orWhere('status', 'direvisi')->count();
                break;
            case 2:
                $data['izin_count'] = Izin::where('user_id', auth()->user()->id)->count();
                break;
            
            default:
                break;
        }

        return response()->json($data);
    }
}
