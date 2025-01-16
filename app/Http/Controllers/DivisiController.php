<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Divisi;
use Inertia\Inertia;
class DivisiController extends Controller
{
    public function index(){
        $user = Auth::user();
        $divisi = Divisi::all();
        return Inertia::render('Divisi',[
            'divisi' => $divisi,
            'title' => 'Divisi',
            'user' => $user,
        ]);

    }
    //
}
