<?php

namespace App\Http\Controllers;

use App\Models\RtUnit;
use App\Models\RwUnit;
use Illuminate\Http\Request;

class RtController extends Controller
{
    public function index()
    {
        // Menggunakan with('rwUnit') agar tidak boros query (Eager Loading)
        $rt_units = RtUnit::with('rwUnit')->latest()->paginate(10);
        return view('pages.rt-unit.index', compact('rt_units'));
    }

    public function create()
    {
        $rw_units = RwUnit::all(); // Mengambil data RW untuk dropdown
        return view('pages.rt-unit.create', compact('rw_units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rw_unit_id' => 'required|exists:rw_units,id',
            'number'     => 'required|min:2|max:3',
        ], [
            'rw_unit_id.required' => 'Pilih RW terlebih dahulu!',
            'number.required'     => 'Nomor RT harus diisi!'
        ]);

        RtUnit::create($request->all());

        return redirect()->route('rt-unit.index')->with('success', 'Data RT berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rt_unit = RtUnit::findOrFail($id);
        $rw_units = RwUnit::all();
        return view('pages.rt-unit.edit', compact('rt_unit', 'rw_units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rw_unit_id' => 'required|exists:rw_units,id',
            'number'     => 'required|min:2|max:3',
        ]);

        $rt_unit = RtUnit::findOrFail($id);
        $rt_unit->update($request->all());

        return redirect()->route('rt-unit.index')->with('success', 'Data RT berhasil diubah!');
    }

    public function destroy($id)
    {
        RtUnit::findOrFail($id)->delete();
        return redirect()->route('rt-unit.index')->with('success', 'Data RT berhasil dihapus!');
    }
}