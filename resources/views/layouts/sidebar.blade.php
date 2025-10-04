<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="" class="brand-link">
            <!--begin::Brand Image-->
            <img src="../../dist/assets/img/AdminLTELogo.png" alt="" class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Prediksi Kesejahteraan</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('kelola-data-*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('kelola-data-*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>
                            Kelola Data
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/kelola-data-keluarga" class="nav-link {{ Request::is('kelola-data-keluarga') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Keluarga</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/kelola-data-indikator" class="nav-link {{ Request::is('kelola-data-indikator') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Keluarga Indikator</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/indikator" class="nav-link {{ Request::is('indikator') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Indikator</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/prediksi" class="nav-link {{ Request::is('prediksi') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-fill-gear"></i>
                        <p>Prediksi</p>
                    </a>
                </li>
                @if(auth()->user()->role === 'Admin')
                <li class="nav-item">
                    <a href="/user" class="nav-link {{ Request::is('user') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-workspace"></i>
                        <p>User</p>
                    </a>
                </li>
                @endif
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
@php use Illuminate\Support\Facades\Request; @endphp
