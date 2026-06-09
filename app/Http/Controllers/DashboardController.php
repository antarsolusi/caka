<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        $totalThisMonth = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])
            ->count();

        $totalAll = Attendance::where('user_id', $user->id)
            ->count();

        $recentAttendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('todayAttendance', 'totalThisMonth', 'totalAll', 'recentAttendances'));
    }
}
