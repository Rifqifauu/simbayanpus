<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Attendance;
use App\Models\Otp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import yang benar
use Carbon\Carbon;
use Illuminate\Http\Request; 
use Illuminate\Database\QueryException;

class AttendanceController extends Controller
{
    public function index(){
         $user = Auth::user();
         $attendance = Attendance::where('id_user', $user->id)->get()
            ->map(function($row) {
                return [
                    'id'                 => $row->id,
                    'tanggal'            => Carbon::parse($row->tanggal)->format('d-m-Y'),
                    'waktu_masuk'         => $row->waktu_masuk,
                    'waktu_keluar'         => $row->waktu_keluar,
                    'status' => $row->status,
                ];
            });
        return Inertia::render('Attendance',[
            'attendance' => $attendance,
        ]

    );
    }
  public function submitOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|string|size:6',
    ]);

    $otp = Otp::where('otp', $request->otp)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->first();

    if (!$otp) {
        return response()->json(['message' => 'OTP tidak valid atau sudah kedaluwarsa'], 422);
    }

    $userId = Auth::id();
    $today = Carbon::today()->toDateString();

    $attendance = Attendance::firstOrCreate(
        ['id_user' => $userId, 'tanggal' => $today],
    );

    if ($otp->tipe === 'masuk' && !$attendance->waktu_masuk) {
        $attendance->waktu_masuk = now();
        $attendance->save();
    } elseif ($otp->tipe === 'keluar' && !$attendance->waktu_keluar) {
 $attendance->waktu_keluar = now();
        $attendance->save();
    } else {
        return response()->json(['message' => 'Absensi sudah dicatat sebelumnya.'], 409);
    }

    return response()->json([
        'message' => 'Absensi berhasil dicatat.',
        'data' => $attendance,
    ]);
}
}