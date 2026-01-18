<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan sudah install: composer require barryvdh/laravel-dompdf

class SubmissionController extends Controller
{
    /**
     * Menampilkan daftar surat.
     * Admin melihat semua, Warga melihat miliknya sendiri.
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            // Sisi Admin: Ambil semua data surat beserta data penduduknya
            $submissions = Submission::with('resident')->latest()->get();
            return view('pages.submissions.admin_index', compact('submissions'));
        } else {
            // Sisi Warga: Ambil data surat milik warga yang sedang login saja
            $submissions = Submission::where('resident_id', auth()->user()->resident->id)
                                     ->latest()
                                     ->get();
            return view('pages.submissions.index', compact('submissions'));
        }
    }

    public function create()
    {
        return view('pages.submissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'necessity' => 'required|min:10',
        ]);

        Submission::create([
            'resident_id' => auth()->user()->resident->id,
            'type' => $request->type,
            'necessity' => $request->necessity,
            'status' => 'pending'
        ]);

        return redirect()->route('submission.index')->with('success', 'Permohonan surat berhasil dikirim!');
    }

    /**
     * Fungsi khusus Admin untuk memperbarui status surat (Approved/Ready/Rejected)
     */
    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,ready,rejected',
            'admin_note' => 'nullable|string'
        ]);

        $submission = Submission::findOrFail($id);
        $submission->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ]);

        return redirect()->back()->with('success', 'Status permohonan surat berhasil diperbarui!');
    }

    /**
     * Fungsi untuk mencetak surat ke format PDF
     */
    public function generatePDF($id)
    {
        // Load data lengkap termasuk relasi wilayah penduduk
        $submission = Submission::with(['resident.rwUnit', 'resident.rtUnit'])->findOrFail($id);

        // Validasi: Hanya surat yang sudah disetujui atau siap yang bisa dicetak
        if (!in_array($submission->status, ['approved', 'ready'])) {
            return redirect()->back()->with('error', 'Surat belum disetujui untuk dicetak.');
        }

        $data = [
            'title' => 'SURAT KETERANGAN DESA',
            'date'  => now()->translatedFormat('d F Y'),
            'sub'   => $submission
        ];

        // Load view khusus PDF dan set ukuran kertas
        $pdf = Pdf::loadView('pages.submissions.pdf', $data)->setPaper('a4', 'portrait');

        // Stream akan langsung membuka PDF di tab baru browser
        return $pdf->stream('Surat_' . $submission->resident->nik . '.pdf');
    }
}