<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('adminlte/assets/img/profile2.png') }}"
                        class="user-image rounded-circle" alt="User Image" />
                    <span class="d-none d-md-inline">{{ Auth::user()->nama }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('adminlte/assets/img/profile2.png') }}" class="rounded-circle"
                            alt="User Image" />
                        <p>
                            {{ Auth::user()->nama }} | {{ Auth::user()->role }} <br>
                            <small>Member since {{ Auth::user()->tahun_mulai }} - {{ Auth::user()->tahun_selesai }}</small>
                        </p>
                    </li>
                    <!--end::User Image-->
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <form method="GET" action="{{ route('logout') }}">
                            <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
