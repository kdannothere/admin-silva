<!-- Topbar Start -->
<div class="topbar-custom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                <li>
                    <button class="button-toggle-menu nav-link">
                        <i data-feather="menu" class="noti-icon"></i>
                    </button>
                </li>
                <li class="d-none d-lg-block">
                    @auth
                    <h5 class="mb-0">Hello, {{ auth()->user()->name }}</h5>
                    @endauth
                </li>
            </ul>

            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">

                <li class="d-none d-sm-flex">
                    <button type="button" class="btn nav-link" data-toggle="fullscreen">
                        <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                    </button>
                </li>

                <li class="dropdown notification-list topbar-dropdown">
                    @auth
                    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="/images/users/user-5.jpg" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ms-1">
                        {{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i>
                        </span>
                        @endauth
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">

                        <!-- item-->
                        <a href="pages-profile.html" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="auth-lock-screen.html" class="dropdown-item notify-item">
                            <i class="mdi mdi-lock-outline fs-16 align-middle"></i>
                            <span>Lock Screen</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <form action="{{route('logout')}}" method="POST" class="dropdown-item notify-item">
                            @csrf
                            <button class=" dropdown-item notify-item m-0 p-1"><i class="mdi mdi-location-exit fs-16 align-middle p-0"></i> Logout</button>
                        </form>

                    </div>
                </li>

            </ul>
        </div>

    </div>

</div>
<!-- end Topbar -->