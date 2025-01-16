<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Mengembalikan response Inertia yang valid
        return Inertia::render('Home', [
            'user' => $user,
            'title' => 'Home',
        ]);
    }
    public function kontak()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Mengembalikan response Inertia yang valid
        return Inertia::render('Kontak', [
            'user' => $user,
            'title' => 'Kontak',
        ]);
    }
}

