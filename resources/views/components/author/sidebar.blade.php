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
                        class="fas fa-regular fa-house"></i><span>Dasbor</span></a>
            </li>
            <li class="nav-item dropdown {{ Request::is('books') ? 'active' : '' }}">
                <a href="{{ url('author/books') }}"
                    class="nav-link has-dropdown"><i class="fas fa-solid fa-book"></i><span>Manajemen Penerbitan</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('author/books') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('author/books') }}">Data Naskah</a>
                    </li>
                    <li class="{{ Request::is('author/chapters') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('author/chapters') }}">Daftar Bab</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('author/history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/history') }}"><i
                        class="fas fa-solid fa-clock-rotate-left"></i><span>Histori</span></a>
            </li>
        </ul>
    </aside>
</div>
