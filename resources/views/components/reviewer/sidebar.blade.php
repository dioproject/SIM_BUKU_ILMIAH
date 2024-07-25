<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">AE Publishing</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AE</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('reviewer/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('reviewer/dashboard') }}"><i
                        class="fas fa-regular fa-house"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('reviewer/users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('reviewer/users') }}"><i
                    class="fas fa-solid fa-feather"></i><span>Authors</span></a>
            </li>
            <li class="{{ Request::is('reviewer/books') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('reviewer/books') }}"><i
                    class="fas fa-solid fa-book"></i><span>Books</span></a>
            </li>
            {{-- <li class="nav-item dropdown {{ Request::is('books') ? 'active' : '' }}">
                <a href="{{ url('reviewer/books') }}"
                    class="nav-link has-dropdown"><i class="fas fa-solid fa-book"></i><span>Data Book</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('reviewer/books') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('reviewer/books') }}">Books</a>
                    </li>
                    <li class="{{ Request::is('reviewer/chapters') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('reviewer/chapters') }}">Chapters</a>
                    </li>
                </ul>
            </li> --}}
            <li class="{{ Request::is('reviewer/history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('reviewer/history') }}"><i
                        class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
        </ul>
    </aside>
</div>
