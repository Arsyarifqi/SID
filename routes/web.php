<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\RWController; 
use App\Http\Controllers\RtController;
use App\Http\Controllers\SubmissionController; 
// Tambahkan Controller baru jika Anda memisahkan logic verifikasi
use App\Http\Controllers\Admin\VerificationController; 
use App\Models\Complain; 
use App\Models\Resident; 
use App\Models\Submission; 
use App\Models\User; // Tambahkan ini untuk hitung di Dashboard
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN PUBLIK (GUEST) ---
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- HALAMAN TERPROTEKSI (AUTH) ---
Route::middleware('auth')->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role_id == 1) { // ROLE ADMIN
            $stats = [
                'total_resident' => Resident::count(),
                'total_complain' => Complain::count(),
                'pending_complain' => Complain::where('status', 'new')->count(),
                'processing_complain' => Complain::where('status', 'processing')->count(),
                'completed_complain' => Complain::where('status', 'completed')->count(),
                'pending_submission' => Submission::where('status', 'pending')->count(), 
                // Tambahan: Statistik User yang butuh verifikasi NIK
                'pending_account' => User::where('status', 'submitted')->count(),
            ];

            // ... (Data chart dan tabel tetap sama)
            $statusData = [$stats['pending_complain'], $stats['processing_complain'], $stats['completed_complain']];
            $rwDistribution = DB::table('rw_units')
                ->leftJoin('residents', 'rw_units.id', '=', 'residents.rw_unit_id')
                ->select('rw_units.number', DB::raw('count(residents.id) as total'))
                ->groupBy('rw_units.id', 'rw_units.number')
                ->orderBy('rw_units.number', 'asc')
                ->get();
            $latest_residents = Resident::with(['rwUnit', 'rtUnit'])->latest()->take(5)->get();
            $latest_complains = Complain::with('resident')->latest()->take(5)->get();

            return view('pages.dashboard', compact('stats', 'statusData', 'rwDistribution', 'latest_residents', 'latest_complains'));
            
        } else { // ROLE WARGA
            $residentId = $user->resident->id ?? 0;
            $stats = [
                'total_my_complain' => Complain::where('resident_id', $residentId)->count(),
                'my_pending' => Complain::where('resident_id', $residentId)->where('status', 'new')->count(),
                'my_finished' => Complain::where('resident_id', $residentId)->where('status', 'completed')->count(),
                'total_my_submission' => Submission::where('resident_id', $residentId)->count(), 
            ];
            
            return view('pages.dashboard', compact('stats'));
        }
    })->name('dashboard');

    // --- FITUR PROFIL, NOTIFIKASI, COMPLAIN, SUBMISSION ---
    // (Tetap sama seperti kode Anda sebelumnya)
    Route::get('/profile', [UserController::class, 'profileView'])->name('profile.view');
    Route::post('/profile/{id}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [UserController::class, 'changePasswordView'])->name('password.view');
    Route::post('/change-password/{id}', [UserController::class, 'changePassword'])->name('password.update');
    Route::get('/notifications', function () { return view('pages.notifications'); })->name('notifications.index');
    Route::post('/notification/{id}/read', function ($id) { /* logic read */ })->name('notification.read');
    
    Route::resource('complain', ComplainController::class);
    Route::post('/complain/update-status/{id}', [ComplainController::class, 'updateStatus'])->name('complain.updateStatus')->middleware('role:admin');

    Route::resource('submission', SubmissionController::class);
    Route::post('/submission/update-status/{id}', [SubmissionController::class, 'updateStatus'])->name('submission.updateStatus')->middleware('role:admin');
    Route::get('/submission/{id}/pdf', [SubmissionController::class, 'generatePDF'])->name('submission.pdf');

    // --- KHUSUS ROLE ADMIN ---
    Route::middleware('role:admin')->group(function () {
        // Data Penduduk & Wilayah
        Route::resource('resident', ResidentController::class);
        Route::get('/get-rt/{rw_id}', [ResidentController::class, 'getRtByRw']);
        Route::resource('rw-unit', RWController::class); 
        Route::resource('rt-unit', RtController::class); 

        // Manajemen Akun & Verifikasi NIK
        Route::get('/account-list', [UserController::class, 'accountListView'])->name('account.list');
        
        // Menampilkan daftar pendaftar (submitted) untuk diverifikasi NIK-nya
        Route::get('/account-request', [UserController::class, 'accountRequestView'])->name('account.request');
        
        // Proses Approve/Reject (Sesuaikan di UserController)
        Route::post('/account-request/approval/{id}/{action}', [UserController::class, 'accountApproval'])->name('account.approval');
    });

    // --- LOGOUT ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});