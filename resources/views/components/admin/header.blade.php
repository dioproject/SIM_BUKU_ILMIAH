<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg">
                <i class="far fa-bell"></i>
                @if($unreadCount > 0)
                    <span class="badge badge-danger badge-notification">{{ $unreadCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi
                    @if($unreadCount > 0)
                        <form method="POST" action="{{ route('admin.notification.readAll') }}" class="float-right">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-link text-white p-0">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @foreach ($notifications as $notification)
                        <div class="dropdown-item {{ $notification->is_read ? '' : 'bg-light' }}">
                            <div class="dropdown-item-icon {{ $notification->is_read ? 'bg-secondary' : 'bg-info' }} text-white">
                                <i class="fas {{ $notification->is_read ? 'fa-check-circle' : 'fa-info-circle' }}"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ is_array($notification->data) ? ($notification->data['chapter'] ?? 'Bab') : 'Bab' }}
                                @if(is_array($notification->data) && isset($notification->data['uploaded_by']))
                                    diunggah oleh {{ $notification->data['uploaded_by'] }}
                                @endif
                                <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('admin.notification.read', $notification->id) }}" class="mt-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-info">Tandai sudah dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if($notifications->isEmpty())
                        <div class="dropdown-item text-center text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-2"></i><br>
                            Tidak ada notifikasi
                        </div>
                    @endif
                </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">

                <div class="d-sm-none d-lg-inline-block">ADMIN, {{ auth()->user()->username }}</div>

            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item has-icon text-danger" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
