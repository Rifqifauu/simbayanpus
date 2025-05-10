<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Logbook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import yang benar
use Carbon\Carbon;
use Illuminate\Http\Request; 
use Illuminate\Database\QueryException;

class LogbookController extends Controller
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

    public function index()
    {
        $user = Auth::user();
        $logbook = Logbook::where('id_user', $user->id)->get()
            ->map(function($row) {
                return [
                    'id'                 => $row->id,
                    'tanggal'            => Carbon::parse($row->tanggal)->format('d-m-Y'),
                    'aktivitas'         => $row->aktivitas,
                    'verifikasi'         => $row->verifikasi,
                    'catatan_pembimbing' => $row->catatan_pembimbing,
                    'created_at'         => $row->created_at->format('d-m-Y'),
                    'updated_at'         => $row->updated_at->format('d-m-Y'),
                ];
            });
                         
        return Inertia::render('Logbook', [
            'user' => $user,
            'title' => 'Logbook',
            'logbook' => $logbook, // kirim ke Vue
        ]);
    }
        public function store(Request $request){
        $user = Auth::user();
    
        $request->validate([
            'tanggal' => 'required|date',
            'aktivitas' => 'required|string',
        ]);
    
        try {
            Logbook::create([
                'id_user' => $user->id,
                'tanggal' => $request->tanggal,
                'aktivitas' => $request->aktivitas,
                'catatan_pembimbing' => 'Belum ada catatan dari pembimbing',
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Logbook berhasil disimpan.',
            ]);
        } catch (QueryException $qe) {
            Log::error('Database error in Logbook@store: ' . $qe->getMessage());
            return response()->json([
                'error' => 'Database error.',
                'message' => $qe->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Unexpected error in Logbook@store: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unexpected error.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
       public function edit(Request $request, $id) {
    $request->validate([
        'tanggal' => 'required|date',
        'aktivitas' => 'required|string',
    ]);
    
    try {
        // Cari record berdasarkan ID
        $logbook = Logbook::findOrFail($id);
        
        // Update record
        $logbook->update([
            'tanggal' => $request->tanggal,
            'aktivitas' => $request->aktivitas,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil diperbarui.',
        ]);
    } catch (ModelNotFoundException $e) {
        Log::error('Record not found in Logbook@edit: ' . $e->getMessage());
        return response()->json([
            'error' => 'Data tidak ditemukan.',
            'message' => 'Logbook entry tidak ditemukan.'
        ], 404);
    } catch (QueryException $qe) {
        Log::error('Database error in Logbook@edit: ' . $qe->getMessage());
        return response()->json([
            'error' => 'Database error.',
            'message' => $qe->getMessage()
        ], 500);
    } catch (\Exception $e) {
        Log::error('Unexpected error in Logbook@edit: ' . $e->getMessage());
        return response()->json([
            'error' => 'Unexpected error.',
            'message' => $e->getMessage()
        ], 500);
    }
}
public function delete($id){

    try {
        $logbook = Logbook::findOrFail($id);
        $logbook->delete();
         return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil dihapusw.',
        ]);

    }
     catch (ModelNotFoundException $e) {
        Log::error('Record not found in Logbook@delete: ' . $e->getMessage());
        return response()->json([
            'error' => 'Data tidak ditemukan.',
            'message' => 'Logbook entry tidak ditemukan.'
        ], 404);
    } catch (QueryException $qe) {
        Log::error('Database error in Logbook@delete: ' . $qe->getMessage());
        return response()->json([
            'error' => 'Database error.',
            'message' => $qe->getMessage()
        ], 500);
    } catch (\Exception $e) {
        Log::error('Unexpected error in Logbook@delete: ' . $e->getMessage());
        return response()->json([
            'error' => 'Unexpected error.',
            'message' => $e->getMessage()
        ], 500);
    }
}
}

