@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Penduduk</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/resident" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">NIK (16 Digit)</label>
                            <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="Masukkan NIK">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jenis Kelamin</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-primary">Pilih RW</label>
                            <select name="rw_unit_id" id="rw_unit_id" class="form-control @error('rw_unit_id') is-invalid @enderror">
                                <option value="">-- Pilih RW --</option>
                                @foreach($rw_units as $rw)
                                    <option value="{{ $rw->id }}" {{ old('rw_unit_id') == $rw->id ? 'selected' : '' }}>
                                        RW {{ $rw->number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rw_unit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-primary">Pilih RT</label>
                            <select name="rt_unit_id" id="rt_unit_id" class="form-control @error('rt_unit_id') is-invalid @enderror">
                                <option value="">-- Pilih RW Terlebih Dahulu --</option>
                            </select>
                            @error('rt_unit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Tempat Lahir</label>
                            <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror" value="{{ old('birth_place') }}" placeholder="Contoh: Mojokerto">
                            @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                            @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Agama</label>
                            <input type="text" name="religion" class="form-control @error('religion') is-invalid @enderror" value="{{ old('religion') }}" placeholder="Contoh: Islam">
                            @error('religion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Status Perkawinan</label>
                            <select name="marital_status" class="form-control @error('marital_status') is-invalid @enderror">
                                <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Sudah Menikah</option>
                                <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Cerai Mati (Janda/Duda)</option>
                            </select>
                            @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Status Penduduk</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="moved" {{ old('status') == 'moved' ? 'selected' : '' }}>Pindah</option>
                                <option value="deceased" {{ old('status') == 'deceased' ? 'selected' : '' }}>Meninggal</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Pekerjaan</label>
                            <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" value="{{ old('occupation') }}" placeholder="Contoh: Karyawan Swasta">
                            @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Contoh: 08123456789">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Alamat Lengkap</label>
                    <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan Alamat Lengkap Sesuai KTP">{{ old('address') }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="/resident" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary shadow-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script AJAX untuk Dropdown Dinamis --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#rw_unit_id').on('change', function() {
        var rwID = $(this).val();
        if(rwID) {
            $.ajax({
                url: '/get-rt/' + rwID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#rt_unit_id').empty();
                    $('#rt_unit_id').append('<option value="">-- Pilih RT --</option>');
                    $.each(data, function(key, value) {
                        $('#rt_unit_id').append('<option value="'+ value.id +'">RT '+ value.number +'</option>');
                    });
                }
            });
        } else {
            $('#rt_unit_id').empty();
            $('#rt_unit_id').append('<option value="">-- Pilih RW Terlebih Dahulu --</option>');
        }
    });
});
</script>
@endsection