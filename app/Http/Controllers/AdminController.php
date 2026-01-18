<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan daftar warga yang baru mendaftar (Status: submitted)
    public function pengajuanAkun()
    {
        // Ambil user yang statusnya masih menunggu (submitted)
        $users = User::where('status', 'submitted')->get();

        foreach ($users as $user) {
            // Cek otomatis apakah NIK pendaftar ada di tabel residents (penduduk)
            $user->is_valid_resident = Resident::where('nik', $user->nik)->exists();
        }

        return view('pages.admin.permintaan_akun', compact('users'));
    }

    // Proses Menyetujui Akun
    public function approveAkun($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Akun warga dengan NIK ' . $user->nik . ' telah disetujui.');
    }

    // Proses Menolak Akun
    public function rejectAkun($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return redirect()->back()->with('warning', 'Pendaftaran akun telah ditolak.');
    }
}