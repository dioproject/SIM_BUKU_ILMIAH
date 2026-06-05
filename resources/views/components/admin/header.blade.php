<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @foreach ($notifications as $notification)
                        <div class="dropdown-item">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ is_array($notification->data) ? ($notification->data['chapter'] ?? 'Bab') : 'Bab' }}
                                @if(is_array($notification->data) && isset($notification->data['uploaded_by']))
                                    diunggah oleh {{ $notification->data['uploaded_by'] }}
                                @endif
                                <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">

                <div class="d-sm-none d-lg-inline-block">ADMIN, {{ auth()->user()->username }}</div>

            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item has-icon text-danger" style="border:none;background:none;width:100%;text-align:left;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
