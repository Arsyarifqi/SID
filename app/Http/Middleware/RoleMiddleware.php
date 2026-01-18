<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect('/')->withErrors(['email' => 'Silahkan login terlebih dahulu.']);
        }

        $user = Auth::user();

        // 2. Cek Status Akun (PENTING!)
        // Jika akun belum disetujui admin, tendang ke login atau dashboard dengan pesan jelas
        if ($user->status !== 'approved') {
            Auth::logout(); // Paksa keluar jika status tidak aktif
            return redirect('/')->with('warning', 'Akun Anda masih menunggu verifikasi NIK oleh Admin.');
        }

        // 3. Ambil Nama Role
        // Kita gunakan logika yang lebih aman: cek apakah relasi role ada
        $userRole = $user->role ? $user->role->name : null; 

        // 4. Cek Akses Role
        if (!$userRole || !in_array($userRole, $roles)) {
            return redirect('/dashboard')->with('error', 'Role Anda (' . ($userRole ?? 'Tidak Ada') . ') tidak diizinkan mengakses menu ini.');
        }

        return $next($request);
    }
}