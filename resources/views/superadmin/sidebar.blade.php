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
                <span class="text-muted">Drive Prima</span>
            </h6>
            <li class="nav-item">
                <a class="text-white text-decoration-none nav-link {{ Request::is('document/arsip*') ? 'active' : '' }}"
                    aria-current="page" href="/document/arsip">
                    <span data-feather="mail"></span>
                    Arsip Perpustakaan
                </a>
            </li>
            <li class="nav-item">
                <a class="text-white text-decoration-none nav-link {{ Request::is('document/my*') ? 'active' : '' }}"
                    aria-current="page" href="/document/my">
                    <span data-feather="file"></span>
                    File Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="text-white text-decoration-none nav-link {{ Request::is('document/shared*') ? 'active' : '' }}"
                    aria-current="page" href="/document/shared">
                    <span data-feather="share-2"></span>
                    File Shared
                </a>
            </li>
            @can('is_admin')
                <hr style="color: beige">
                <h6 class="sidebar-headign d-flex justify-content-between align-items-center px-3 mt-2 mb-1">
                    <span class="text-muted">Administrator</span>
                </h6>
                <li class="text-white nav-item">
                    <a class="text-white nav-link {{ Request::is('documents*') ? 'active' : '' }}" href="/documents">
                        <span data-feather="folder"></span>
                        Documents
                    </a>
                </li>
                <li class="text-white nav-item">
                    <a class="text-white nav-link {{ Request::is('roles*') ? 'active' : '' }}" href="/roles">
                        <span data-feather="briefcase"></span>
                        Jabatan
                    </a>
                </li>
                <li class="text-white nav-item">
                    <a class="text-white nav-link {{ Request::is('categories*') ? 'active' : '' }}" href="/categories">
                        <span data-feather="book"></span>
                        Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="text-white nav-link {{ Request::is('users*') ? 'active' : '' }}" href="/users">
                        <span data-feather="users"></span>
                        User
                    </a>
                </li>
                <li class="text-white nav-item">
                    <a class="text-white nav-link {{ Request::is('units*') ? 'active' : '' }}" href="/units">
                        <span data-feather="box"></span>
                        Unit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="text-white nav-link {{ Request::is('reports*') ? 'active' : '' }}" href="/reports">
                        <span data-feather="bar-chart-2"></span>
                        Laporan
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
        </ul>
    </div>
</nav>
