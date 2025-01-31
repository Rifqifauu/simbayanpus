<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Pesan;
use Illuminate\Support\Facades\Auth;
class PesanController extends Controller
{
    //
    public function index()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();
        
        // Perbaikan: Menambahkan get() untuk mengeksekusi query
        $pesan = Pesan::where('id_user', $user->id)->get();

        // Mengembalikan response Inertia yang valid
        return Inertia::render('Pesan', [
            'user' => $user,
            'title' => 'Pesan',
            'pesan' => $pesan,
        ]);
    }
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'pesan' => 'required',
            'id_user' => 'required',
            'asal' => 'required',
        ]);
    
        try {
            // Save the message
            $pesan = Pesan::create($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil disimpan.',
                'data' => $pesan,
            ], 201); // Using 201 Created status code
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pesan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function delete($id)
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();
    
        // Mencari pesan berdasarkan ID dan memastikan bahwa pesan milik user yang sedang login
        $pesan = Pesan::where('id', $id)->where('id_user', $user->id)->first();
    
        if (!$pesan) {
            return redirect()->back()->with('error', 'Pesan tidak ditemukan atau tidak memiliki akses.');
        }
    
        // Menghapus pesan
        $pesan->delete();
    
        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }
    
}
