<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserDetailController extends Controller
{
    public function create(){
        return Inertia::render('EditProfil');
    }
    public function index()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            $userDetail = $user->userDetail;

            // Render the profile page with the user's details
            return Inertia::render('Profil', [
                'user' => $user,
                'userDetail' => $userDetail,
                'title' => 'Profil',
            ]);
        } catch (\Exception $e) {
            Log::error('Error in UserDetailController@index: ' . $e->getMessage(), ['exception' => $e]);
            return Inertia::render('Profil', [
                'errors' => ['message' => 'An error occurred while loading the profile.']
            ]);
        }
    }

    public function edit()
    {
        try {
            // Get the authenticated user and their profile details
            $user = Auth::user();
            $userDetail = $user->userDetail;

            // Render the edit profile page
            return Inertia::render('EditProfil', [
                'user' => $user,
                'userDetail' => $userDetail,
                'title' => 'Edit Profil',
            ]);
        } catch (\Exception $e) {
            Log::error('Error in UserDetailController@edit: ' . $e->getMessage(), ['exception' => $e]);
            return Inertia::render('EditProfil', [
                'errors' => ['message' => 'An error occurred while loading the edit profile page.']
            ]);
        }
    }

    public function store(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Request Data: ', $request->all());
    
        // Menambahkan validasi dengan pesan kesalahan yang lebih rinci
        $validator = Validator::make($request->all(), [
            'panggilan' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:user_details',
            'nik' => 'required|string|size:16|unique:user_details',
            'institusi' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'medsos' => 'required|string|max:100',
            'nomor_hp' => 'required|string|max:15',
            'jenis_kelamin' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000'
        ], [
            'panggilan.required' => 'Nama panggilan harus diisi.',
            'panggilan.string' => 'Nama panggilan harus berupa teks.',
            'panggilan.max' => 'Nama panggilan maksimal 100 karakter.',
            'nim.required' => 'NIM harus diisi.',
            'nim.string' => 'NIM harus berupa teks.',
            'nim.max' => 'NIM maksimal 20 karakter.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nik.required' => 'NIK harus diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.size' => 'NIK harus terdiri dari 16 karakter.',
            'nik.unique' => 'NIK sudah digunakan.',
            'institusi.required' => 'Nama institusi harus diisi.',
            'institusi.string' => 'Nama institusi harus berupa teks.',
            'institusi.max' => 'Nama institusi maksimal 100 karakter.',
            'program_studi.required' => 'Nama program studi harus diisi.',
            'program_studi.string' => 'Nama program studi harus berupa teks.',
            'program_studi.max' => 'Nama program studi maksimal 100 karakter.',
            'medsos.required' => 'Link media sosial harus diisi.',
            'medsos.string' => 'Link media sosial harus berupa teks.',
            'medsos.max' => 'Link media sosial maksimal 100 karakter.',
            'nomor_hp.required' => 'Nomor HP harus diisi.',
            'nomor_hp.string' => 'Nomor HP harus berupa teks.',
            'nomor_hp.max' => 'Nomor HP maksimal 15 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'jenis_kelamin.string' => 'Jenis kelamin harus berupa teks.',
            'jenis_kelamin.max' => 'Jenis kelamin maksimal 50 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar maksimal 1MB.',
        ]);
    
        if ($validator->fails()) {
            Log::error('Validation Failed: ', $validator->errors()->toArray());
            return Inertia::render('EditProfil', [
                'errors' => $validator->errors()
            ]);
        }
    
        try {
            $user = Auth::user();
    
            // Pastikan user belum memiliki detail
            if ($user->userDetail) {
                return Inertia::render('EditProfil', [
                    'errors' => ['message' => 'User details already exist. Please use the update option instead.']
                ]);
            }
    
            $validatedData = $validator->validated();
            $validatedData['id_user'] = $user->id;
    
            // Proses unggah foto jika ada
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('user_photos', $filename, 'public');
                $validatedData['foto'] = $path;
            }
    
            Log::info('Creating user detail: ', $validatedData);
    
            // Simpan data userDetail baru
            UserDetail::create($validatedData);
    
            return Inertia::render('Profil', [
                'success' => 'Profile details created successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in UserDetailController@store: ' . $e->getMessage(), ['exception' => $e]);
            return Inertia::render('EditProfil', [
                'errors' => ['message' => 'An error occurred while creating user details.']
            ]);
        }
    }
    
    
    public function update(Request $request)
    {
        Log::info('Request Data:', $request->all()); // Memeriksa data yang diterima
        $user = Auth::user();
        $userDetail = $user->userDetail;
    
        try {
            // Validasi input data
            $validator = Validator::make($request->all(), [
                'panggilan' => 'required|string|max:50',
                'nim' => 'required|string|max:20|unique:user_details,nim',
                'nik' => 'required|string|size:16|unique:user_details,nik',
                'institusi' => 'required|string|max:100',
                'program_studi' => 'required|string|max:100',
                'medsos' => 'required|string|max:100',
                'nomor_hp' => 'required|string|max:15',
                'alamat' => 'required|string|max:255',
                'jenis_kelamin' => 'required|string|max:25',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
    
            if ($validator->fails()) {
                Log::error('Validation Failed:', $validator->errors()->toArray());
                return Inertia::render('Profil', [
                    'errors' => $validator->errors()
                ]);
            }
    
            // Pastikan data userDetail ada sebelum diupdate
            if (!$userDetail) {
                Log::error('User detail not found.');
                return Inertia::render('Profil', [
                    'errors' => ['message' => 'User details not found. Please create them first.']
                ]);
            }
    
            // Ambil data yang sudah tervalidasi
            $validatedData = $validator->validated();
    
            // Cek apakah foto diupload, jika ada maka proses
            if ($request->hasFile('foto')) {
                if ($userDetail->foto) {
                    // Hapus foto lama
                    Storage::disk('public')->delete($userDetail->foto);
                }
    
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('user_photos', $filename, 'public');
                $validatedData['foto'] = $path;
            }
    
            // Update data userDetail
            $userDetail->update($validatedData);
    
            Log::info('User detail updated successfully:', $validatedData);
    
            return Inertia::render('Profil', [
                'success' => 'Profile details updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in UserDetailController@update: ' . $e->getMessage(), ['exception' => $e]);
            return Inertia::render('EditProfil', [
                'errors' => ['message' => 'An error occurred while updating user details.']
            ]);
        }
        
    }
}
