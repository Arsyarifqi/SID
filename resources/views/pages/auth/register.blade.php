<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Akun Penduduk - Si Desa</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <style>
        .bg-register-image {
            background-image: url('https://images.unsplash.com/photo-1590060153070-6da763327d3b?q=80&w=1000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        .form-control-user { border-radius: 10px !important; }
        .btn-user { border-radius: 10px !important; font-weight: bold; }
        .invalid-feedback { font-size: 0.75rem; }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Buat Akun Baru!</h1>
                                <p class="mb-4 small text-muted">Pastikan data sesuai KTP untuk verifikasi oleh Admin Desa.</p>
                            </div>

                            <form class="user" action="{{ url('register') }}" method="POST" id="registerForm">
                                @csrf

                                {{-- Input NIK --}}
                                <div class="form-group">
                                    <input type="text" name="nik" 
                                           class="form-control form-control-user @error('nik') is-invalid @enderror" 
                                           placeholder="NIK (16 Digit Sesuai KTP)" 
                                           value="{{ old('nik') }}" maxlength="16" required
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    @error('nik')
                                        <span class="invalid-feedback ml-3"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Input Nama --}}
                                <div class="form-group">
                                    <input type="text" name="name" 
                                           class="form-control form-control-user @error('name') is-invalid @enderror" 
                                           placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback ml-3"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Input Email --}}
                                <div class="form-group">
                                    <input type="email" name="email" 
                                           class="form-control form-control-user @error('email') is-invalid @enderror" 
                                           placeholder="Alamat Email Aktif" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback ml-3"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Input Password --}}
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" 
                                               class="form-control form-control-user @error('password') is-invalid @enderror" 
                                               placeholder="Password" required>
                                        @error('password')
                                            <span class="invalid-feedback ml-3"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" 
                                               class="form-control form-control-user" 
                                               placeholder="Ulangi Password" required>
                                    </div>
                                </div>

                                <button type="submit" id="submit-btn" class="btn btn-primary btn-user btn-block py-2">
                                    Daftar Akun Warga
                                </button>
                            </form>

                            <hr>

                            <div class="text-center">
                                <a class="small font-weight-bold" href="{{ url('/') }}">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        // Efek Loading saat Submit
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submit-btn');

        registerForm.onsubmit = function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        };
    </script>
</body>
</html>