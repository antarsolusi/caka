<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $attendances = Attendance::where('user_id', Auth::id())
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->orderBy('date', 'asc')
            ->get();

        $totalDays = $attendances->count();
        $totalCheckIn = $attendances->whereNotNull('check_in_at')->count();
        $totalCheckOut = $attendances->whereNotNull('check_out_at')->count();

        $avgCheckIn = $attendances->whereNotNull('check_in_at')
            ->avg(fn ($a) => $a->check_in_at->timestamp);
        $avgCheckOut = $attendances->whereNotNull('check_out_at')
            ->avg(fn ($a) => $a->check_out_at->timestamp);

        return view('report.index', compact(
            'attendances',
            'dateFrom',
            'dateTo',
            'totalDays',
            'totalCheckIn',
            'totalCheckOut',
            'avgCheckIn',
            'avgCheckOut'
        ));
    }
}
