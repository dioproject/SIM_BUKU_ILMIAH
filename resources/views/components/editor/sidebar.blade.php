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
                <a class="nav-link" href="{{ url('editor/dashboard') }}"><i
                        class="fas fa-regular fa-house"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('editor/users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('editor/users') }}"><i
                    class="fas fa-solid fa-user-group"></i><span>Authors</span></a>
            </li>
            <li class="{{ Request::is('editor/books') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('editor/books') }}"><i
                    class="fas fa-solid fa-book"></i><span>Books</span></a>
            </li>            
            <li class="{{ Request::is('editor/reviews') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('editor/reviews') }}"><i
                    class="fas fa-solid fa-comment"></i><span>Reviews</span></a>
            </li>
            <li class="{{ Request::is('editor/history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('editor/history') }}"><i
                        class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
        </ul>
    </aside>
</div>
