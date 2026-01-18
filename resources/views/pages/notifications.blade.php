@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Semua Notifikasi</h1>

    <div class="row">
        <div class="col-lg-12">
            @forelse(auth()->user()->notifications as $notification)
                <div class="card shadow mb-3 {{ $notification->read_at ? '' : 'border-left-primary' }}" 
                     style="{{ $notification->read_at ? '' : 'background-color: #f8f9fc;' }}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                <span class="{{ $notification->read_at ? 'text-gray-600' : 'font-weight-bold text-dark' }}">
                                    {{ $notification->data['message'] }}
                                </span>
                            </div>
                            <div class="col-auto">
                                @if(!$notification->read_at)
                                    <form action="{{ route('notification.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                            Tandai Dibaca
                                        </button>
                                    </form>
                                @else
                                    <span class="badge badge-light">Sudah Dibaca</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-bell-slash fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-0">Belum ada notifikasi untuk Anda.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection