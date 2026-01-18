@auth
@php
    // Definisikan menu berdasarkan role_id
    // 1 = admin, 2 = user (penduduk)
    $menus = [
        1 => [
            ['title' => 'Dashboard', 'path' => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt'],
            ['title' => 'Master RW', 'path' => 'rw-unit', 'icon' => 'fas fa-fw fa-map-marked-alt'],
            ['title' => 'Master RT', 'path' => 'rt-unit', 'icon' => 'fas fa-fw fa-map-marker-alt'],
            ['title' => 'Data Penduduk', 'path' => 'resident', 'icon' => 'fas fa-fw fa-users'],
            ['title' => 'Layanan Surat', 'path' => 'submission', 'icon' => 'fas fa-fw fa-envelope-open-text'], // Tambahan Admin
            ['title' => 'Pengaduan', 'path' => 'complain', 'icon' => 'fas fa-fw fa-comments'],
            ['title' => 'Daftar Akun', 'path' => 'account-list', 'icon' => 'fas fa-fw fa-user'],
            ['title' => 'Permintaan Akun', 'path' => 'account-request', 'icon' => 'fas fa-fw fa-user-check'],
        ],
        2 => [
            ['title' => 'Dashboard', 'path' => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt'],
            ['title' => 'Status Surat', 'path' => 'submission', 'icon' => 'fas fa-fw fa-file-alt'], // Tambahan Warga
            ['title' => 'Pengaduan', 'path' => 'complain', 'icon' => 'fas fa-fw fa-comments'],
        ]
    ];

    // Ambil menu sesuai role user yang sedang login
    $userMenus = $menus[Auth::user()->role_id] ?? [];
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon">
        <img src="{{ asset('img/logo-desa1.png') }}" alt="Logo SIDesa" style="width: 45px; height: auto;">
    </div>
    <div class="sidebar-brand-text mx-3 text-white" style="text-transform: none; letter-spacing: 1px;">
        <span class="font-weight-bold">SI</span>Desa
        <br>
        <small style="font-size: 9px; opacity: 0.7;">Sistem Informasi</small>
    </div>
</a>
    <hr class="sidebar-divider my-0">

    <div class="sidebar-heading mt-3">
        Menu Utama
    </div>

    @foreach($userMenus as $menu)
    <li class="nav-item {{ request()->is($menu['path'] . '*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url($menu['path']) }}">
            <i class="{{ $menu['icon'] }}"></i>
            <span>{{ $menu['title'] }}</span>
        </a>
    </li>
    @endforeach

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endauth