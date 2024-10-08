<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">AE Publishing</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AE</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('author/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/dashboard') }}"><i
                        class="fas fa-regular fa-house"></i><span>Dashboard</span></a>
            </li>
            {{-- <li class="{{ Request::is('author/books') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/books') }}"><i
                    class="fas fa-solid fa-book"></i><span>Books</span></a>
            </li> --}}
            <li class="nav-item dropdown {{ Request::is('books') ? 'active' : '' }}">
                <a href="{{ url('author/books') }}"
                    class="nav-link has-dropdown"><i class="fas fa-solid fa-book"></i><span>Management Publish</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('author/books') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('author/books') }}">Data Naskah</a>
                    </li>
                    <li class="{{ Request::is('author/chapters') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('author/chapters') }}">Proses Pengajuan</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('author/history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/history') }}"><i
                        class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
            <li class="{{ Request::is('https://docs.google.com/forms/d/e/1FAIpQLSdIplVv4Ft5St178h4cJF09seXgjDk-sJfXXvIVGYUy-PzGfw/viewform') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('https://docs.google.com/forms/d/e/1FAIpQLSdIplVv4Ft5St178h4cJF09seXgjDk-sJfXXvIVGYUy-PzGfw/viewform') }}"><i
                        class="fas fa-solid fa-comments"></i><span>Feedback</span></a>
            </li>
        </ul>
    </aside>
</div>
