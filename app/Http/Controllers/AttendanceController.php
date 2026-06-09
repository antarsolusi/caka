<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', $today)
            ->first();

        $isCheckIn = !$attendance || !$attendance->check_in_at;
        $isCheckOut = $attendance && $attendance->check_in_at && !$attendance->check_out_at;

        return view('attendances.create', compact('attendance', 'isCheckIn', 'isCheckOut'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'photo' => ['required', 'string'],
        ]);

        $today = Carbon::today();
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->check_in_at) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah check in hari ini.');
        }

        $photoPath = $this->saveBase64Image($request->photo, 'check_in');

        if (!$attendance) {
            Attendance::create([
                'user_id' => Auth::id(),
                'date' => $today,
                'check_in_at' => now(),
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'check_in_photo' => $photoPath,
            ]);
        } else {
            $attendance->update([
                'check_in_at' => now(),
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'check_in_photo' => $photoPath,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Check in berhasil!');
    }

    public function update(Request $request, Attendance $attendance)
    {
        if ($attendance->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'photo' => ['required', 'string'],
        ]);

        if ($attendance->check_out_at) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah check out hari ini.');
        }

        $photoPath = $this->saveBase64Image($request->photo, 'check_out');

        $attendance->update([
            'check_out_at' => now(),
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
            'check_out_photo' => $photoPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Check out berhasil!');
    }

    private function saveBase64Image(string $base64, string $prefix): string
    {
        $image = str_replace('data:image/jpeg;base64,', '', $base64);
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $prefix . '_' . Auth::id() . '_' . time() . '.jpg';

        Storage::disk('public')->put('attendances/' . $imageName, base64_decode($image));

        return 'attendances/' . $imageName;
    }
}
