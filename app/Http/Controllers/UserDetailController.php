<?php

namespace App\Http\Controllers;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class UserDetailController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $userDetail = $user->userDetail;
            return Inertia::render('Profil', [
                'user' => $user,
                'userDetail' => $userDetail,
                'title' => 'Profil',
            ]);
        } catch (\Exception $e) {
            Log::error('Error in UserDetailController@index: ' . $e->getMessage(), ['exception' => $e]);
            return Inertia::render('Profil', [
                'error' => ['message' => 'An error occurred while loading the profile.']
            ]);
        }
    }
    public function store(Request $request)
    {
        Log::info('Request Data: ', $request->all());
        $validator = Validator::make($request->all(), [
            'panggilan' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:user_details',
            'nik' => 'required|string|size:16|unique:user_details',
            'institusi' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'medsos' => 'required|string|max:100',
            'nomor_hp' => 'required|string|max:15',
            'agama' => 'required|string|max:15',
            'jenis_kelamin' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'domisili' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000'
        ]);
    
        if ($validator->fails()) {
            Log::error('Validation Failed: ', $validator->errors()->toArray());
            return response()->json([
                'error' => 'Validation failed.',
                'messages' => $validator->errors()
            ], 422);  // Mengembalikan status code 422 untuk error validasi
        }
    
        try {
            $user = Auth::user();
    
            if ($user->userDetail) {
                return response()->json([
                    'error' => 'User details already exist. Please use the update option instead.'
                ], 400);  // Mengembalikan error dengan status code 400
            }
    
            $validatedData = $validator->validated();
            $validatedData['id_user'] = $user->id;
    
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('user_photos', $filename, 'public');
                $validatedData['foto'] = $path;
            }
    
            UserDetail::create($validatedData);
            return response()->json([
                'success' => 'Profil Berhasil Dibuat'
            ], 200);  // Mengembalikan status code 200 untuk sukses
        } catch (\Exception $e) {
            Log::error('Error in UserDetailController@store: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'error' => 'An error occurred while creating user details.',
                'message' => $e->getMessage()
            ], 500);  // Mengembalikan status code 500 untuk kesalahan server
        }
    }
    
    public function update(Request $request)
    {
        Log::info('Request Data:', $request->all());
        $user = Auth::user();
    
        if (!$request->all()) {
            return response()->json(['error' => 'FormData kosong'], 400);  // Mengembalikan error jika data kosong
        }
    
        $userDetail = $user->userDetail;
    
        try {
            $rules = [
                'panggilan' => 'nullable|string|max:50',
                'nim' => 'nullable|string|max:20|unique:user_details,nim,' . $userDetail->id,
                'nik' => 'nullable|string|size:16|unique:user_details,nik,' . $userDetail->id,
                'institusi' => 'nullable|string|max:100',
                'agama' => 'nullable|string|max:255',
                'program_studi' => 'nullable|string|max:100',
                'medsos' => 'nullable|string|max:100',
                'nomor_hp' => 'nullable|string|max:15',
                'alamat' => 'nullable|string|max:255',
                'domisili' => 'nullable|string|max:255',
                'jenis_kelamin' => 'nullable|string|max:25',
            ];
    
            if ($request->has('nim')) {
                $rules['nim'] = 'required|string|max:20|unique:user_details,nim,' . $userDetail->id;
            }
    
            if ($request->hasFile('foto')) {
                $rules['foto'] = 'required|image|mimes:jpeg,png,jpg|max:10000';
            }
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                Log::error('Validation Failed:', $validator->errors()->toArray());
                return response()->json([
                    'error' => 'Validation failed.',
                    'messages' => $validator->errors()
                ], 422);  // Mengembalikan error validasi
            }
    
            if (!$userDetail) {
                Log::error('User detail not found.');
                return response()->json([
                    'error' => 'User details not found. Please create them first.'
                ], 404);  // User detail tidak ditemukan
            }
    
            $validatedData = $validator->validated();
    
            if ($request->hasFile('foto')) {
                if ($userDetail->foto) {
                    Storage::disk('public')->delete($userDetail->foto);
                }
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('user_photos', $filename, 'public');
                $validatedData['foto'] = $path;
            } else {
                unset($validatedData['foto']);
            }
    
            $userDetail->update($validatedData);
    
            return response()->json([
                'success' => 'Profil Berhasil Diubah'
            ], 200);  // Status sukses
        } catch (\Exception $e) {
            Log::error('Error in UserDetailController@update: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'error' => 'An error occurred while updating user details.',
                'message' => $e->getMessage()
            ], 500);  // Error server
        }
    }    
}