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
                <div class="dropdown-header">
                    Notifikasi
                    @if($unreadCount > 0)
                        <form method="POST" action="{{ route('admin.notification.readAll') }}" class="float-right">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-link p-0" style="color:inherit;">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @foreach ($notifications as $notification)
                        @php
                            $data = $notification->data ?? [];
                            $isUnread = !$notification->is_read;
                            if (isset($data['message'])) {
                                $icon = 'fa-user-plus';
                                $bgColor = 'bg-info';
                            } elseif (isset($data['uploaded_by']) && ($data['status'] ?? '') === 'Reviewer memberikan catatan') {
                                $icon = 'fa-comment';
                                $bgColor = 'bg-secondary';
                            } elseif (isset($data['uploaded_by'])) {
                                $icon = 'fa-upload';
                                $bgColor = 'bg-primary';
                            } elseif (($data['status'] ?? '') === 'Disetujui') {
                                $icon = 'fa-check-circle';
                                $bgColor = 'bg-success';
                            } elseif (($data['status'] ?? '') === 'Revisi') {
                                $icon = 'fa-edit';
                                $bgColor = 'bg-warning';
                            } else {
                                $icon = 'fa-bell';
                                $bgColor = 'bg-info';
                            }
                            $message = $data['message'] ?? '';
                            $chapter = $data['chapter'] ?? 'Bab';
                            $book = $data['book'] ?? '';
                        @endphp
                        <div class="dropdown-item {{ $isUnread ? 'dropdown-item-unread' : '' }}" style="position:relative;">
                            @if($isUnread)
                                <span style="position:absolute;left:8px;top:50%;transform:translateY(-50%);width:6px;height:6px;border-radius:50%;background:#6777ef;"></span>
                            @endif
                            <div class="dropdown-item-icon {{ $bgColor }} text-white" style="margin-left:{{ $isUnread ? '14px' : '0' }}">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                @if($message)
                                    <strong>{{ $message }}</strong><br>
                                @endif
                                <span>{{ $chapter }}</span>
                                @if($book)
                                    <span class="text-muted">· {{ $book }}</span>
                                @endif
                                @if(isset($data['uploaded_by']) && ($data['status'] ?? '') !== 'Reviewer memberikan catatan')
                                    <span class="text-muted"> oleh {{ $data['uploaded_by'] }}</span>
                                @endif
                                <div class="time" style="display:flex;align-items:center;justify-content:space-between;">
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                    @if($isUnread)
                                        <form method="POST" action="{{ route('admin.notification.read', $notification->id) }}" class="d-inline" style="line-height:1;">
                                            @csrf
                                            <button type="submit" class="btn btn-link btn-sm text-muted p-0" style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;text-decoration:none;">
                                                Tandai sudah dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($notifications->isEmpty())
                        <div class="dropdown-item text-center text-muted" style="padding:40px 15px;">
                            <i class="fas fa-bell-slash fa-3x mb-3" style="opacity:0.3;"></i><br>
                            <span style="font-size:14px;font-weight:500;">Tidak ada notifikasi</span><br>
                            <small style="font-size:12px;">Notifikasi akan muncul di sini</small>
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
