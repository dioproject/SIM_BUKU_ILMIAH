<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">AE Publishing</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AE</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('editor/dashboard') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('editor/dashboard') }}"><i class="fas fa-regular fa-house"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'data' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-solid fa-table"></i> <span>Data</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('editor/user-data') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('editor/userdata') }}">User Data</a>
                    </li>
                    <li class="{{ Request::is('editor/bookdata') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('editor/bookdata') }}">Book Data</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('editor/history') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('editor/history') }}"><i class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
        </ul>
    </aside>
</div>