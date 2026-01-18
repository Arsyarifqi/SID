@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Ubah Data Penduduk</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/resident/{{ $residence->id }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">NIK (16 Digit)</label>
                            <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                   value="{{ old('nik', $residence->nik) }}">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $residence->name) }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jenis Kelamin</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="male" {{ old('gender', $residence->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $residence->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-primary">Pilih RW</label>
                            <select name="rw_unit_id" id="rw_unit_id" class="form-control @error('rw_unit_id') is-invalid @enderror">
                                <option value="">-- Pilih RW --</option>
                                @foreach($rw_units as $rw)
                                    <option value="{{ $rw->id }}" {{ old('rw_unit_id', $residence->rw_unit_id) == $rw->id ? 'selected' : '' }}>
                                        RW {{ $rw->number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-primary">Pilih RT</label>
                            <select name="rt_unit_id" id="rt_unit_id" class="form-control @error('rt_unit_id') is-invalid @enderror">
                                @foreach($rt_units as $rt)
                                    <option value="{{ $rt->id }}" {{ old('rt_unit_id', $residence->rt_unit_id) == $rt->id ? 'selected' : '' }}>
                                        RT {{ $rt->number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Tempat Lahir</label>
                            <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $residence->birth_place) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $residence->birth_date) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Pekerjaan</label>
                            <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $residence->occupation) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Status Penduduk</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ old('status', $residence->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="moved" {{ old('status', $residence->status) == 'moved' ? 'selected' : '' }}>Pindah</option>
                                <option value="deceased" {{ old('status', $residence->status) == 'deceased' ? 'selected' : '' }}>Meninggal</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Status Perkawinan</label>
                            <select name="marital_status" class="form-control @error('marital_status') is-invalid @enderror">
                                <option value="single" {{ old('marital_status', $residence->marital_status) == 'single' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="married" {{ old('marital_status', $residence->marital_status) == 'married' ? 'selected' : '' }}>Sudah Menikah</option>
                                <option value="divorced" {{ old('marital_status', $residence->marital_status) == 'divorced' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="widowed" {{ old('marital_status', $residence->marital_status) == 'widowed' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Alamat</label>
                    <textarea name="address" rows="3" class="form-control">{{ old('address', $residence->address) }}</textarea>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="/resident" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-warning shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        }
    });
});
</script>
@endsection