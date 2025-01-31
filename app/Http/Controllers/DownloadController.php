<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller {

    public function downloadCv($userId)
    {
        $file = Permohonan::where('user_id', $userId)->firstOrFail()->cv; // Use user_id to find the record
        return Storage::download($file);
    }
    public function downloadSKDiterima($userId)
    {
        $file = Dokumen::where('id_user', $userId)
        ->where('keterangan', 'diterima')->firstOrFail()->dokumen; 
            return Storage::download($file);
    }


public function pedomanMagang()
{
    try {
        $file = 'Pedoman_Magang.docx';
        
        // Mengecek apakah file ada
        if (!Storage::exists($file)) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }

        // Mengunduh file jika ditemukan
        return Storage::download($file);

    } catch (\Exception $e) {
        // Menangani kesalahan lain
        return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
    }
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

   
}
