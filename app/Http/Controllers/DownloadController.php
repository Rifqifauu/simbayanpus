<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller {

    public function downloadCv($userId)
    {
        $user = Auth::user();
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->cv; // Use user_id to find the record
        return Storage::download($file);
    }

    public function downloadSuratPengantar($userId)
    {
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->surat_pengantar; // Use user_id to find the record
        return Storage::download($file);
    }

    public function downloadProposal($userId)
    {
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->proposal; // Use user_id to find the record
        return Storage::download($file);
    }

    public function downloadPedomanMagang($userId)
    {
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->pedoman_magang; // Use user_id to find the record
        return Storage::download($file);
    }
}
