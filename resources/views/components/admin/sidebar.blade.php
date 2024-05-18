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
                    <li class="{{ Request::is('admin/user-data') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('admin/userdata') }}">User Data</a>
                    </li>
                    <li class="{{ Request::is('admin/bookdata') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('admin/bookdata') }}">Book Data</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('admin/katalog') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('admin/katalog') }}"><i class="fas fa-solid fa-address-book"></i><span>Katalog</span></a>
            </li>
            <li class="{{ Request::is('admin/royalty') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('admin/royalty') }}"><i class="fas fa-solid fa-crown"></i><span>Royalty</span></a>
            </li>
            <li class="{{ Request::is('admin/history') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('admin/history') }}"><i class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
        </ul>
    </aside>
</div>
