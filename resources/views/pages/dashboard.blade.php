@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="font-weight-bold text-dark mb-1">
                {{ auth()->user()->role_id == 1 ? 'Panel Administrator' : 'Layanan Mandiri Warga' }}
            </h2>
            <p class="text-secondary small">Selamat datang kembali, {{ auth()->user()->name }}.</p>
        </div>
        <div class="d-none d-sm-block">
            <span class="badge badge-light shadow-sm px-3 py-2" style="border-radius: 10px;">
                <i class="fas fa-calendar-alt text-primary mr-2"></i> {{ date('d M Y') }}
            </span>
        </div>
    </div>

    <div class="row">
        @if(auth()->user()->role_id == 1)
            {{-- STATS ADMIN --}}
            @php
                $adminStats = [
                    ['title' => 'Total Penduduk', 'value' => $stats['total_resident'], 'icon' => 'fa-users', 'bg' => 'primary'],
                    ['title' => 'Total Pengaduan', 'value' => $stats['total_complain'], 'icon' => 'fa-comments', 'bg' => 'success'],
                    ['title' => 'Pengaduan Baru', 'value' => $stats['pending_complain'], 'icon' => 'fa-exclamation-circle', 'bg' => 'danger'],
                    ['title' => 'Permohonan Surat', 'value' => $stats['pending_submission'], 'icon' => 'fa-file-import', 'bg' => 'info'],
                ];
            @endphp

            @foreach($adminStats as $s)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1 text-secondary" style="letter-spacing: 0.5px;">{{ $s['title'] }}</div>
                                <div class="h4 mb-0 font-weight-bold text-dark">{{ $s['value'] }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-shape bg-soft-{{ $s['bg'] }} rounded-circle" style="width: 45px; height: 45px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas {{ $s['icon'] }} text-{{ $s['bg'] }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            {{-- STATS WARGA --}}
            @php
                $userStats = [
                    ['title' => 'Laporan Saya', 'value' => $stats['total_my_complain'], 'icon' => 'fa-paper-plane', 'bg' => 'primary'],
                    ['title' => 'Pengajuan Surat', 'value' => $stats['total_my_submission'], 'icon' => 'fa-file-alt', 'bg' => 'info'],
                    ['title' => 'Selesai / Clear', 'value' => $stats['my_finished'], 'icon' => 'fa-check-double', 'bg' => 'success'],
                ];
            @endphp

            @foreach($userStats as $s)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1 text-secondary">{{ $s['title'] }}</div>
                                <div class="h4 mb-0 font-weight-bold text-dark">{{ $s['value'] }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-shape bg-soft-{{ $s['bg'] }} rounded-circle" style="width: 45px; height: 45px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas {{ $s['icon'] }} text-{{ $s['bg'] }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <div class="row mt-3">
        @if(auth()->user()->role_id == 1)
            {{-- AREA ADMIN: GRAFIK --}}
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-0">
                        <h6 class="m-0 font-weight-bold text-dark">Sebaran Penduduk Per RW</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar"><canvas id="rwChart" style="height: 320px;"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 font-weight-bold text-dark text-center">Status Pengaduan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-2 pb-2"><canvas id="statusChart"></canvas></div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2"><i class="fas fa-circle text-danger"></i> Baru</span>
                            <span class="mr-2"><i class="fas fa-circle text-warning"></i> Proses</span>
                            <span class="mr-2"><i class="fas fa-circle text-success"></i> Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- AREA WARGA: AKSES CEPAT --}}
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 font-weight-bold text-dark">Akses Cepat Layanan</h6>
                    </div>
                    <div class="card-body text-center py-4">
                        <div class="row">
                            <div class="col-6 col-md-3 mb-3">
                                <a href="{{ route('complain.create') }}" class="btn bg-soft-primary p-3 mb-2 rounded-lg" style="width: 60px; height: 60px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-edit fa-lg text-primary"></i>
                                </a>
                                <p class="small font-weight-bold">Buat Laporan</p>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <a href="{{ route('submission.create') }}" class="btn bg-soft-success p-3 mb-2 rounded-lg" style="width: 60px; height: 60px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file-invoice fa-lg text-success"></i>
                                </a>
                                <p class="small font-weight-bold">Minta Surat</p>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <a href="{{ route('profile.view') }}" class="btn bg-soft-info p-3 mb-2 rounded-lg" style="width: 60px; height: 60px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-cog fa-lg text-info"></i>
                                </a>
                                <p class="small font-weight-bold">Data Profil</p>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <a href="{{ route('submission.index') }}" class="btn bg-soft-warning p-3 mb-2 rounded-lg" style="width: 60px; height: 60px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-history fa-lg text-warning"></i>
                                </a>
                                <p class="small font-weight-bold">Status Surat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm mb-4 border-0 overflow-hidden">
                    <div class="card-header bg-primary py-3 border-0">
                        <h6 class="m-0 font-weight-bold text-white">Info</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-light p-3 rounded-lg mr-3"><i class="fas fa-id-badge text-primary"></i></div>
                            <div>
                                <div class="small text-muted">NIK Anda</div>
                                <div class="font-weight-bold text-dark">{{ auth()->user()->resident->nik ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-0">
                            <div class="bg-light p-3 rounded-lg mr-3"><i class="fas fa-map-marker-alt text-danger"></i></div>
                            <div>
                                <div class="small text-muted">Alamat</div>
                                <div class="font-weight-bold text-dark">RT {{ auth()->user()->resident->rtUnit->number ?? '-' }} / RW {{ auth()->user()->resident->rwUnit->number ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Script Chart.js --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(auth()->user()->role_id == 1)
    new Chart(document.getElementById("rwChart"), {
        type: 'bar',
        data: {
            labels: {!! json_encode($rwDistribution->pluck('number')->map(fn($n) => "RW $n")) !!},
            datasets: [{
                label: "Jumlah Penduduk",
                backgroundColor: "#4f46e5",
                borderRadius: 8,
                data: {!! json_encode($rwDistribution->pluck('total')) !!},
            }],
        },
        options: { 
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, border: { display: false } }, x: { border: { display: false } } }
        }
    });

    new Chart(document.getElementById("statusChart"), {
        type: 'doughnut',
        data: {
            labels: ["Baru", "Proses", "Selesai"],
            datasets: [{
                data: {!! json_encode($statusData) !!},
                backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
                borderWidth: 0,
            }],
        },
        options: { maintainAspectRatio: false, cutout: '80%'}
    });
    @endif
</script>
@endpush
@endsection