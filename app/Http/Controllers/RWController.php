<?php

namespace App\Http\Controllers;

use App\Models\RwUnit; // Import Model RwUnit
use Illuminate\Http\Request;

class RWController extends Controller
{
    /**
     * Menampilkan daftar RW (Read)
     */
    public function index()
    {
        // Mengambil data RW terbaru dengan pagination 5 data per halaman
        $rw_units = RwUnit::latest()->paginate(5);
        
        return view('pages.rw-unit.index', compact('rw_units'));
    }

    /**
     * Menampilkan form tambah data
     */
    public function create()
    {
        return view('pages.rw-unit.create');
    }

    /**
     * Menyimpan data RW baru ke database (Create)
     */
    public function store(Request $request)
    {
        // Validasi: Harus diisi, minimal 2 karakter, maksimal 3
        $request->validate([
            'number' => 'required|min:2|max:3|unique:rw_units,number',
        ]);

        RwUnit::create([
            'number' => $request->number
        ]);

        return redirect()->route('rw-unit.index')->with('success', 'Berhasil menambahkan data RW!');
    }

    /**
     * Menampilkan form edit data
     */
    public function edit($id)
    {
        $rw_unit = RwUnit::findOrFail($id);
        return view('pages.rw-unit.edit', compact('rw_unit'));
    }

    /**
     * Memperbarui data RW (Update)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required|min:2|max:3|unique:rw_units,number,' . $id,
        ]);

        $rw_unit = RwUnit::findOrFail($id);
        $rw_unit->update([
            'number' => $request->number
        ]);

        return redirect()->route('rw-unit.index')->with('success', 'Berhasil memperbarui data RW!');
    }

    /**
     * Menghapus data RW (Delete)
     */
    public function destroy($id)
    {
        $rw_unit = RwUnit::findOrFail($id);
        $rw_unit->delete();

        return redirect()->route('rw-unit.index')->with('success', 'Berhasil menghapus data RW!');
    }
}