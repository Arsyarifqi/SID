<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm border-0 px-4">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars text-primary"></i>
    </button>

    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group" style="background: #f1f5f9; border-radius: 10px; padding: 2px 8px;">
            <input type="text" class="form-control bg-transparent border-0 small" placeholder="Cari layanan desa..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-link text-secondary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="position-relative p-1">
                    <i class="fas fa-bell fa-fw text-secondary"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge badge-danger badge-counter" style="top: 0; right: 0; border: 2px solid white;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </div>
            </a>
            
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow border-0 animated--grow-in mt-3"
                aria-labelledby="alertsDropdown" style="border-radius: 15px; overflow: hidden;">
                <h6 class="dropdown-header bg-primary border-0 py-3 font-weight-bold">
                    Notifikasi Pengaduan
                </h6>
                
                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <form action="{{ route('notification.read', $notification->id) }}" method="POST" id="form-read-{{ $notification->id }}">
                            @csrf
                            <a class="dropdown-item d-flex align-items-center py-3 border-bottom" href="#" 
                               onclick="event.preventDefault(); document.getElementById('form-read-{{ $notification->id }}').submit();">
                                <div class="mr-3">
                                    <div class="icon-circle bg-soft-primary">
                                        <i class="fas fa-file-alt text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                    <span class="text-dark" style="font-size: 13px; line-height: 1.2;">{{ $notification->data['message'] }}</span>
                                </div>
                            </a>
                        </form>
                    @empty
                        <div class="dropdown-item text-center py-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/3602/3602145.png" width="40" class="mb-2 opacity-50">
                            <p class="small text-gray-500 mb-0">Tidak ada notifikasi baru</p>
                        </div>
                    @endforelse
                </div>

                <a class="dropdown-item text-center small text-primary font-weight-bold py-3" href="{{ route('notifications.index') }}">
                    Lihat Semua Notifikasi
                </a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block" style="border-right: 1px solid #e2e8f0;"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="d-flex flex-column align-items-end mr-3 d-none d-lg-inline">
                    <span class="text-dark font-weight-bold small mb-0">{{ Auth::user()->name }}</span>
                    <span class="text-muted" style="font-size: 10px; text-transform: uppercase;">
                        {{ auth()->user()->role_id == 1 ? 'Administrator' : 'Warga' }}
                    </span>
                </div>
                <div class="position-relative">
                    <img class="img-profile rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover; border: 2px solid #eef2ff;"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff">
                    <div class="bg-success position-absolute" style="width: 10px; height: 10px; border-radius: 50%; bottom: 0; right: 0; border: 2px solid white;"></div>
                </div>
            </a>
            
            <div class="dropdown-menu dropdown-menu-right shadow border-0 animated--grow-in mt-3"
                aria-labelledby="userDropdown" style="border-radius: 12px; min-width: 200px;">
                <a class="dropdown-item py-2 px-4" href="{{ route('profile.view') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-3 text-gray-400"></i>
                    Profil Saya
                </a>
                <a class="dropdown-item py-2 px-4" href="{{ route('password.view') }}">
                    <i class="fas fa-key fa-sm fa-fw mr-3 text-gray-400"></i>
                    Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item py-2 px-4 text-danger font-weight-bold" href="#" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-3"></i> 
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>