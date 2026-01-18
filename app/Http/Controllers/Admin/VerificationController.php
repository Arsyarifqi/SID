<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        // Ambil user yang statusnya masih 'submitted'
        // Kita gunakan eager loading 'resident' agar performa ringan
        $users = User::with('resident')->where('status', 'submitted')->get();

        return view('pages.admin.verification.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        return back()->with('success', 'Akun ' . $user->name . ' telah diaktifkan.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('warning', 'Akun ' . $user->name . ' telah ditolak.');
    }
}