<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // --- FITUR ADMIN: MANAGEMENT AKUN ---

    public function accountRequestView()
    {
        $users = User::where('status', 'submitted')->paginate(5);
        
        foreach ($users as $user) {
            // Mencari data di tabel residents yang NIK-nya sama dengan NIK pendaftar
            $user->resident_data = Resident::where('nik', $user->nik)->first();
        }
        
        return view('pages.account-request.index', compact('users'));
    }

    public function accountListView()
    {
        $users = User::where('role_id', 2)
                     ->where('status', '!=', 'submitted')
                     ->paginate(5);
                     
        return view('pages.account-list.index', compact('users'));
    }

    /**
     * PERBAIKAN: Menambahkan parameter $action agar sesuai dengan Route {id}/{action}
     */
    public function accountApproval(Request $request, $id, $action)
    {
        $user = User::findOrFail($id);
        
        // Menggunakan variabel $action dari URL
        if ($action == 'approve') {
            $user->status = 'approved';

            // Sinkronisasi otomatis ke tabel penduduk berdasarkan NIK
            $resident = Resident::where('nik', $user->nik)->first();
            if ($resident) {
                $resident->update([
                    'user_id' => $user->id
                ]);
            }
            $message = 'Akun disetujui dan otomatis terhubung dengan data penduduk!';
            
        } elseif ($action == 'reject') {
            $user->status = 'rejected';
            $message = 'Pendaftaran akun ditolak!';
            
        } elseif ($action == 'activate') {
            $user->status = 'approved';
            $message = 'Berhasil mengaktifkan akun!';
            
        } elseif ($action == 'deactivate') {
            $user->status = 'deactivated';
            $message = 'Berhasil menonaktifkan akun!';
        }

        $user->save();

        return back()->with('success', $message);
    }

    // --- FITUR PROFIL & PASSWORD ---
    
    public function profileView()
    {
        return view('pages.profile.index');
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate(['name' => 'required|min:3|max:100']);
        $user = User::findOrFail($id);
        $user->update(['name' => $request->name]);
        return back()->with('success', 'Berhasil mengubah data profil!');
    }

    public function changePasswordView()
    {
        return view('pages.profile.change-password');
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail($id);
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Gagal mengubah password! Password lama tidak valid.');
        }
        $user->update(['password' => Hash::make($request->new_password)]);
        return back()->with('success', 'Berhasil mengubah password!');
    }
}