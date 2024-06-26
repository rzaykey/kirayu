<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column nav-pills">
            <li class="nav-item">
                <a class="text-white text-decoration-none nav-link {{ Request::is('dashboard*') ? 'active' : '' }}"
                    aria-current="page" href="/dashboard">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <hr style="color: beige">
            <h6 class="sidebar-headign d-flex justify-content-between align-items-center px-3 mt-2 mb-2">
                <span class="text-muted">Kirayu</span>
            </h6>
            <li class="text-white nav-item">
                <a class="text-white nav-link {{ Request::is('products*') ? 'active' : '' }}" href="/products">
                    <span data-feather="tag"></span>
                    Products
                </a>
            </li>
            <li class="text-white nav-item">
                <a class="text-white nav-link {{ Request::is('categories*') ? 'active' : '' }}" href="/categories">
                    <span data-feather="book"></span>
                    Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="text-white nav-link {{ Request::is('reports*') ? 'active' : '' }}" href="/reports">
                    <span data-feather="bar-chart-2"></span>
                    Laporan
                </a>
            </li>
            @can('is_admin')
                <hr style="color: beige">
                <h6 class="sidebar-headign d-flex justify-content-between align-items-center px-3 mt-2 mb-1">
                    <span class="text-muted">Administrator</span>
                </h6>
                <li class="nav-item">
                    <a class="text-white nav-link {{ Request::is('users*') ? 'active' : '' }}" href="/users">
                        <span data-feather="users"></span>
                        User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="text-white nav-link {{ Request::is('users*') ? 'active' : '' }}" href="/users">
                        <span data-feather="settings"></span>
                        Setting
                    </a>
                </li>
            @endcan
            <hr style="color: beige">
            <li class="text-white nav-item">
                <a class="text-white nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="/profile">
                    <span data-feather="user"></span>
                    Profile
                </a>
            </li>
            <li class="text-white nav-item">
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="btn nav-link px-3"><span data-feather="log-out">
                            Logout </span></button>
                </form>
            </li>

        </ul>
    </div>
</nav>
