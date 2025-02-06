<?php
namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
class FileController extends Controller
{
    public function viewSuratPernyataan(){
        $user = Auth::user();
        $userDetail = $user->UserDetail;
        $permohonan = $user->Permohonan;

        return Inertia::render('Surat-Pernyataan', [
            'user' => $user,
            'userDetail' => $userDetail,
            'permohonan' => $permohonan,
        ]);
    }
    public function viewCv($userId)
    {
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->cv;
        
        // Get file path and mime type
        $path = Storage::path($file);
        $mimeType = Storage::mimeType($file);
        
        // Return file view
        return Response::file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',        ]);
    }

    public function viewSKDiterima()
    {
        $file = Dokumen::where('id_user', Auth::id())
            ->where('keterangan', 'diterima')
            ->firstOrFail()->dokumen;
        
        $path = Storage::path($file);
        $mimeType = Storage::mimeType($file);
        
        return Response::file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',        ]);
    }

    public function viewPedomanMagang()
    {
        try {
            $file = 'Pedoman_Magang.docx';
            // Check if file exists
            if (!Storage::exists($file)) {
                return response()->view('errors.404', [], 404);
            }
            
            // Get full path and mime type
            $path = Storage::path($file);
            $mimeType = Storage::mimeType($file);
            
            // Return file download response
            return response()->download($path, basename($path), [
                'Content-Type' => $mimeType
            ]);
        } catch (\Exception $e) {
            // Handle other errors
            return response()->view('errors.500', ['error' => $e->getMessage()], 500);
        }
    }
    
    public function viewSuratPengantar($userId)
    {
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->surat_pengantar;
        
        $path = Storage::path($file);
        $mimeType = Storage::mimeType($file);
        
        return Response::file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',        ]);
    }

    public function viewProposal($userId)
    {
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->proposal;
        
        $path = Storage::path($file);
        $mimeType = Storage::mimeType($file);
        
        return Response::file($path, [
 'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',        ]);
    }
}