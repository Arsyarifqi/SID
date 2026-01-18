<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login() 
    {
        return view('pages.auth.login');
    }

    private function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function authenticate(Request $request) 
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Logika Penyesuaian: 
            // Admin (Role 1) tetap bisa login kapan saja.
            // Warga (Role 2) hanya bisa login jika status sudah 'approved'.
            if (!$user->isAdmin() && $user->status !== 'approved') {
                $this->_logout($request); 
                return redirect('/')->with('warning', 'Akun Anda masih dalam proses verifikasi NIK oleh admin.');
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Terjadi kesalahan, periksa kembali email atau password.']);
    }

    public function registerView() 
    {
        return view('pages.auth.register');
    }

    public function register(Request $request) 
    {
        $request->validate([
            'nik'      => 'required|digits:16|unique:users,nik',
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ], [
            'nik.required'      => 'NIK harus diisi.',
            'nik.digits'        => 'NIK harus berjumlah 16 digit.',
            'nik.unique'        => 'NIK ini sudah terdaftar sebagai akun.',
            'name.required'     => 'Nama lengkap harus diisi.',
            'email.required'    => 'Email harus diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min'      => 'Password minimal berjumlah 6 karakter.',
        ]);

        User::create([
            'nik'      => $request->nik,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => 2, // Role Warga
            'status'   => 'submitted', // Menunggu verifikasi
        ]);

        return redirect('/')->with('success', 'Registrasi berhasil! Silakan tunggu admin mencocokkan NIK Anda dengan data penduduk desa.');
    }

    public function logout(Request $request)
    {
        $this->_logout($request);
        return redirect('/');
    }
}