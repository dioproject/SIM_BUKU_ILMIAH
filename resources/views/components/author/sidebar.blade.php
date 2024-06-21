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
            <li class="{{ Request::is('author/books') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/books') }}"><i
                    class="fas fa-solid fa-book"></i><span>Books</span></a>
            </li>
            <li class="{{ Request::is('author/reviews') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/reviews') }}"><i
                    class="fas fa-solid fa-comment"></i><span>Reviews</span></a>
            </li>
            <li class="{{ Request::is('author/royalty') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/royalty') }}"><i
                        class="fas fa-solid fa-box"></i><span>Royalty</span></a>
            </li>
            <li class="{{ Request::is('author/history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('author/history') }}"><i
                        class="fas fa-solid fa-clock-rotate-left"></i><span>History</span></a>
            </li>
        </ul>
    </aside>
</div>
