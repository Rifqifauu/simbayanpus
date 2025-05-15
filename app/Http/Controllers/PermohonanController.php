<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Divisi;
use App\Models\User;
class PermohonanController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        $status = optional($user->userDetail)->status_pendaftaran ?? null; // Menggunakan optional() untuk menghindari error null
    
        return Inertia::render('Permohonan', [
            'user'=> $user,
            'status' => $status,
            'title' => 'Permohonan',
        ]);
    }

    public function create()
    {
        $divisi = Divisi::all();
        $user = Auth::user();
        $userDetail = $user->userDetail;

        // Jika userDetail belum ada atau belum terisi, arahkan ke halaman profil
        if (!$userDetail) {
            return redirect()->route('profil.index'); // Ganti 'profil' dengan nama rute yang sesuai dengan halaman profil
        }
        return Inertia::render('BuatPermohonan',[
            'title' => 'Buat Permohonan',
            'user' => $user,
            'divisi' => $divisi,
        ]);
    }    public function store(Request $request)
{
    // Check if the user already has a submitted application
    $user = Auth::user();
    $existingApplication = Permohonan::where('id_user', $user->id)->first();

    // If an application already exists, return an error response
    if ($existingApplication) {
        return response()->json([
            'success' => false,
            'error' => 'Anda sudah mengajukan permohonan. Anda tidak bisa mengajukan lagi.',
        ], 400);
    }

    // Validate the request data
    $request->validate([
        'division' => 'required|string',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'cv' => 'nullable|file|mimes:pdf|max:2048',
        'coverLetter' => 'nullable|file|mimes:pdf|max:2048',
        'proposal' => 'nullable|file|mimes:pdf|max:2048',
        'guidelines' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    $uploadPath = 'uploads/internships';

    // Upload files
    $files = [];
    foreach (['cv', 'coverLetter', 'proposal', 'guidelines'] as $fileKey) {
        if ($request->hasFile($fileKey)) {
            $files[$fileKey] = $request->file($fileKey)->store($uploadPath, 'public');
        }
    }

    // Save application data
   $permohonan = Permohonan::create([
        'id_user' => $user->id,
        'divisi' => $request->input('division'),
        'tgl_masuk' => $request->input('startDate'),
        'tgl_keluar' => $request->input('endDate'),
        'cv' => $files['cv'] ?? null,
        'surat_pengantar' => $files['coverLetter'] ?? null,
        'proposal' => $files['proposal'] ?? null,
        'pedoman_magang' => $files['guidelines'] ?? null,
    ]);

    if($permohonan){
        $message = "📬 Permohonan Magang Baru Masuk\n"
            . "Nama: {$user->name}\n"
            . "Email: {$user->email}\n"
            . "Program Studi: {$user->userDetail->program_studi}\n"
            . "Institusi: {$user->userDetail->institusi}\n"
            . "Silahkan cek halaman dashboard admin segera!";
            $telegramToken="7652493380:AAGary1XWXhIiYSD9UkXSJHW69pSivWIA2A";$chatId="7456474633";
             Http::post("https://api.telegram.org/bot{$telegramToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    // Update user details
    $userDetail = $user->userDetail;
    if ($userDetail) {
        $userDetail->status_pendaftaran = 'pending';
        $userDetail->save();
    } else {
        UserDetail::create([
            'id_user' => $user->id,
            'status_pendaftaran' => 'pending',
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Pendaftaran berhasil disimpan.',
    ]);
}
public function action(Request $request, $id) {
    $user = User::find($id);
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan');
        }
        $userDetail = $user->userDetail;
        if ($userDetail) {
            $userDetail->update(['status_pendaftaran' => $request->input('status_pendaftaran')]);
        }
        $user->pesan()->updateOrCreate(
            ['id_user' => $user->id],
            ['pesan' => $request->input('pesan')]
        );

        return back()->with('success', 'Data berhasil diperbarui');
    }
    public function destroy($id)
{
    try {
        // Cek apakah permohonan dengan id_user tersebut ada
        $permohonan = Permohonan::where('id_user', $id);
        
        if (!$permohonan->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Permohonan tidak ditemukan'
            ], 404);
        }

        // Hapus permohonan
        $permohonan->delete();

        // Ambil user detail dan update status jika ditemukan
        $userDetail = UserDetail::where('id_user', $id)->first();
        if ($userDetail) {
            $userDetail->update(['status_pendaftaran' => 'default']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil dihapus'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus permohonan',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
