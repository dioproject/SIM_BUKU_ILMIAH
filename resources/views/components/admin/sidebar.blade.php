<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">AE Publishing</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AE</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/dashboard') }}"><i
                        class="fas fa-regular fa-house"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/users') }}"><i
                    class="fas fa-solid fa-user-group"></i><span>Users</span></a>
            </li>
            <li class="{{ Request::is('admin/chapters') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/chapters') }}"><i
                    class="fas fa-solid fa-book-open"></i><span>Chapters</span></a>
            </li>
            <li class="{{ Request::is('admin/books') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/books') }}"><i
                    class="fas fa-solid fa-book"></i><span>Books</span></a>
            </li>
            <li class="{{ Request::is('admin/reviews') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/reviews') }}"><i
                    class="fas fa-solid fa-comment"></i><span>Reviews</span></a>
            </li>
            <li class="{{ Request::is('admin/catalogs') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/catalogs') }}"><i
                        class="fas fa-solid fa-book-open"></i><span>Catalogs</span></a>
            </li>
            <li class="{{ Request::is('admin/royalty') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/royalty') }}"><i
                        class="fas fa-solid fa-box"></i><span>Royalty</span></a>
            </li>
            <li class="{{ Request::is('admin/history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/history') }}"><i
                        class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
        </ul>
    </aside>
</div>
