<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SiDesa - Modern Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-desa1.png') }}">
    <link href="{{asset ('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="{{asset ('template/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <style>
        /* Modern UI Overrides */
        :root {
            --primary-indigo: #4f46e5;
            --sidebar-dark: #0f172a;
            --bg-light: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background-color: var(--bg-light) !important;
        }

        /* Sidebar Modernization */
        .sidebar-dark {
            background-color: var(--sidebar-dark) !important;
            background-image: none !important;
        }

        .sidebar .nav-item .nav-link {
            font-weight: 500;
            margin: 0.2rem 0.75rem;
            border-radius: 0.75rem;
        }

        .sidebar .nav-item.active .nav-link {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* Card Modernization */
        .card {
            border: none !important;
            border-radius: 1rem !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        }

        /* Topbar & Buttons */
        .topbar {
            background-color: #ffffff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        .btn-primary {
            background-color: var(--primary-indigo) !important;
            border: none;
            border-radius: 0.6rem;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        }

        /* Custom Scrollbar for modern look */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')

                <div class="container-fluid pb-4">
                    @yield('content')
                </div>
            </div>

            @include('layouts.footer')
        </div>
    </div>

    <a class="scroll-to-top rounded-circle shadow" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow" style="border-radius: 1rem;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body text-secondary">Pilih "Logout" jika Anda ingin mengakhiri sesi ini.</div>
                <div class="modal-footer border-0">
                    <button class="btn btn-light px-4" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary px-4">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset ('template/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset ('template/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset ('template/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset ('template/js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset ('template/vendor/chart.js/Chart.min.js')}}"></script>

    @stack('scripts') {{-- Tempat untuk script tambahan per halaman --}}

</body>
</html>