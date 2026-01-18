<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use App\Models\User; // Tambahkan ini
use App\Notifications\ComplainStatusChanged; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplainController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            $complains = Complain::with('resident')->latest()->paginate(10);
        } else {
            $residentId = $user->resident->id ?? 0;
            $complains = Complain::where('resident_id', $residentId)
                        ->latest()
                        ->paginate(10);
        }

        return view('pages.complain.index', compact('complains'));
    }

    public function create()
    {
        if (!auth()->user()->resident) {
            return redirect()->route('complain.index')->with('error', 'Akun Anda belum terhubung dengan data penduduk.');
        }
        return view('pages.complain.create');
    }

    public function store(Request $request)
    {
        $resident = auth()->user()->resident;
        if (!$resident) {
            return redirect()->route('complain.index')->with('error', 'Gagal mengirim aduan. Data penduduk tidak ditemukan.');
        }

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'foto_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $complain = new Complain();
        $complain->resident_id = $resident->id;
        $complain->title = $request->title;
        $complain->content = $request->content;
        $complain->reported_date = now();
        $complain->status = 'new';

        if ($request->hasFile('foto_proof')) {
            $path = $request->file('foto_proof')->store('uploads', 'public');
            $complain->foto_proof = $path;
        }

        $complain->save();

        return redirect()->route('complain.index')->with('success', 'Aduan berhasil dikirim!');
    }

    public function show($id)
    {
        $complain = Complain::with('resident.user')->findOrFail($id);
        $user = auth()->user();

        if ($user->role_id == 1) {
            return view('pages.complain.show', compact('complain'));
        }

        $myResidentId = $user->resident->id ?? 0;
        if ($complain->resident_id != $myResidentId) {
            abort(403, 'Anda tidak memiliki akses ke aduan ini.');
        }

        return view('pages.complain.show', compact('complain'));
    }

    /**
     * Update Status via Dropdown Index (Admin)
     */
    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role_id != 1) { abort(403); }

        $request->validate([
            'status' => 'required|in:new,processing,done'
        ]);

        $complain = Complain::findOrFail($id);
        
        // Simpan status lama (bahasa Indonesia) untuk pesan notifikasi
        $oldStatus = $complain->status_label;

        $complain->status = $request->status;
        $complain->save();

        // KIRIM NOTIFIKASI
        $this->sendNotification($complain, $oldStatus);

        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui!');
    }

    /**
     * Update Status & Response via Halaman Show (Admin)
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role_id != 1) { abort(403); }

        $request->validate([
            'status' => 'required|in:new,processing,done',
            'response' => 'nullable|string'
        ]);

        $complain = Complain::findOrFail($id);
        
        // Simpan status lama
        $oldStatus = $complain->status_label;

        $complain->status = $request->status;
        $complain->response = $request->response;
        $complain->save();

        // KIRIM NOTIFIKASI
        $this->sendNotification($complain, $oldStatus);

        return redirect()->route('complain.show', $id)->with('success', 'Tanggapan berhasil disimpan!');
    }

    /**
     * Fungsi Helper untuk mengirim notifikasi (Ep 13)
     */
    private function sendNotification($complain, $oldStatus)
    {
        // Cari user yang memiliki aduan ini melalui relasi resident
        $userToNotify = User::find($complain->resident->user_id);

        if ($userToNotify) {
            $userToNotify->notify(new ComplainStatusChanged(
                $complain, 
                $oldStatus, 
                $complain->status_label // Status yang baru
            ));
        }
    }

    public function destroy($id)
    {
        $complain = Complain::findOrFail($id);

        if (auth()->user()->role_id == 2 && $complain->status !== 'new') {
            return redirect()->back()->with('error', 'Aduan sedang diproses atau sudah selesai.');
        }

        if ($complain->foto_proof) {
            Storage::disk('public')->delete($complain->foto_proof);
        }

        $complain->delete();

        return redirect()->route('complain.index')->with('success', 'Aduan berhasil dihapus.');
    }
}