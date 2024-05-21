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
                <a class="nav-link"
                    href="{{ url('admin/dashboard') }}"><i class="fas fa-regular fa-house"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-solid fa-table"></i> <span>Data</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('admin/users') }}">Users</a>
                    </li>
                    <li class="{{ Request::is('admin/books') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('admin/books') }}">Books</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('admin/katalogs') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('admin/katalogs') }}"><i class="fas fa-solid fa-address-book"></i><span>Katalog</span></a>
            </li>
            <li class="{{ Request::is('admin/royalties') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('admin/royalties') }}"><i class="fas fa-solid fa-crown"></i><span>Royalty</span></a>
            </li>
            <li class="{{ Request::is('admin/histories') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('admin/histories') }}"><i class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
        </ul>
    </aside>
</div>
