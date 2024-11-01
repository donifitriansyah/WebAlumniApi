<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Brand Section -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">
            @if (session('user'))
                @switch(session('role'))
                    @case('admin')
                        Admin
                    @break

                    @case('perusahaan')
                        Perusahaan
                    @break

                    @case('alumni')
                        Alumni
                    @break

                    @default
                        Polnep
                @endswitch
            @endif
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Role-Based Navbar -->
    @if (session('user'))
        @switch(session('role'))
            @case('admin')
                <!-- Navbar for Admin -->
                <li class="nav-item {{ Route::is('dashboardAdmin') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboardAdmin') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('berita.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('berita.index') }}">
                        <i class="fas fa-newspaper"></i>
                        <span>Berita</span>
                    </a>
                </li>

                {{-- <li class="nav-item {{ Route::is('alumni-aktif', 'alumni-pasif') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAlumni"
                       aria-expanded="true" aria-controls="collapseAlumni">
                        <i class="fas fa-fw fa-user-graduate"></i>
                        <span>Alumni</span>
                    </a>
                    <div id="collapseAlumni" class="collapse" aria-labelledby="headingUtilities"
                         data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item {{ Route::is('alumni-aktif') ? 'active' : '' }}" href="{{ route('alumni-aktif') }}">Alumni Aktif</a>
                            <a class="collapse-item {{ Route::is('alumni-pasif') ? 'active' : '' }}" href="{{ route('alumni-pasif') }}">Alumni Pasif</a>
                        </div>
                    </div>
                </li> --}}

                <!-- Tambahkan item lain sesuai kebutuhan admin -->

            @break

            @case('alumni')
                <!-- Navbar for Alumni -->
                <li class="nav-item {{ Route::is('dashboard.alumni') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.alumni') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('alumni.profile') }}">
                        <i class="fas fa-fw fa-user-graduate"></i>
                        <span>Profile Alumni</span>
                    </a>
                </li>
            @break

            @case('perusahaan')
                <!-- Navbar for Perusahaan -->
                <li class="nav-item {{ Route::is('dashboard.perusahaan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.perusahaan') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('lowongan.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('lowongan.index') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Lowongan</span>
                    </a>
                </li>
            @break
        @endswitch
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
