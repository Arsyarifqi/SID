<?php

namespace App\Http\Controllers;

use App\Models\Resident; 
use App\Models\RwUnit;
use App\Models\RtUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidentController extends Controller
{
    /**
     * Menampilkan daftar penduduk dengan fitur Filter & Pagination
     */
    public function index(Request $request)
    {
        // 1. Gunakan eager loading 'with' untuk mencegah N+1 Query Problem
        $query = Resident::with(['user', 'rwUnit', 'rtUnit']);

        // 2. Logika Filter RW
        if ($request->filled('rw_id')) {
            $query->where('rw_unit_id', $request->rw_id);
        }

        // 3. Logika Pencarian Nama/NIK
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil data penduduk dengan pagination
        $residence = $query->latest()->paginate(10); 

        // 4. Ambil data RW untuk dropdown filter di view index (MENCEGAH ERROR)
        $rw_units = RwUnit::orderBy('number', 'asc')->get();

        return view('pages.resident.index', [
            'residence' => $residence,
            'rw_units'  => $rw_units
        ]);
    }

    /**
     * Menampilkan form tambah penduduk
     */
    public function create()
    {
        // Ambil data RW untuk dropdown utama
        $rw_units = RwUnit::orderBy('number', 'asc')->get();
        return view('pages.resident.create', compact('rw_units'));
    }

    /**
     * Menyimpan data penduduk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'            => 'required|unique:residents,nik|digits:16',
            'name'           => 'required|max:100',
            'gender'         => ['required', Rule::in(['male', 'female'])],
            'birth_date'     => 'required|date',
            'birth_place'    => 'required|max:100',
            'address'        => 'required|max:700',
            'religion'       => 'nullable|max:50',
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation'     => 'nullable|max:100',
            'phone'          => 'nullable|max:15',
            'status'         => ['required', Rule::in(['active', 'moved', 'deceased'])],
            'rw_unit_id'     => 'required|exists:rw_units,id',
            'rt_unit_id'     => 'required|exists:rt_units,id',
        ], [
            'nik.unique' => 'NIK sudah terdaftar di sistem.',
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'rw_unit_id.required' => 'Pilih RW terlebih dahulu.',
            'rt_unit_id.required' => 'Pilih RT terlebih dahulu.',
        ]);

        Resident::create($validated); 

        return redirect()->route('resident.index')
            ->with('success', 'Data penduduk ' . $request->name . ' berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit penduduk
     */
    public function edit($id)
    {
        $residence = Resident::findOrFail($id); 
        $rw_units = RwUnit::orderBy('number', 'asc')->get();
        
        // Ambil RT yang hanya milik RW si penduduk tersebut agar dropdown sinkron
        $rt_units = RtUnit::where('rw_unit_id', $residence->rw_unit_id)
                          ->orderBy('number', 'asc')
                          ->get();

        return view('pages.resident.edit', [
            'residence' => $residence,
            'rw_units' => $rw_units,
            'rt_units' => $rt_units
        ]);
    }

    /**
     * Memperbarui data penduduk
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nik'            => ['required', 'digits:16', Rule::unique('residents')->ignore($id)],
            'name'           => 'required|max:100',
            'gender'         => ['required', Rule::in(['male', 'female'])],
            'birth_date'     => 'required|date',
            'birth_place'    => 'required|max:100',
            'address'        => 'required|max:700',
            'religion'       => 'nullable|max:50',
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation'     => 'nullable|max:100',
            'phone'          => 'nullable|max:15',
            'status'         => ['required', Rule::in(['active', 'moved', 'deceased'])],
            'rw_unit_id'     => 'required|exists:rw_units,id',
            'rt_unit_id'     => 'required|exists:rt_units,id',
        ]);

        $residence = Resident::findOrFail($id);
        $residence->update($validated);

        return redirect()->route('resident.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Menghapus data penduduk
     */
    public function destroy($id)
    {
        $residence = Resident::findOrFail($id);
        $residence->delete();

        return redirect()->route('resident.index')
            ->with('success', 'Data penduduk berhasil dihapus dari sistem.');
    }

    /**
     * API untuk AJAX: Mengambil data RT berdasarkan ID RW
     */
    public function getRtByRw($rw_id)
    {
        $rt = RtUnit::where('rw_unit_id', $rw_id)->orderBy('number', 'asc')->get();
        return response()->json($rt);
    }
}