<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="BMIS">
    <meta name="author" content="Arzatech">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BMIS</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
</head>
<body id="page-top">

<div id="app">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-bus"></i>
                </div>
                <div class="sidebar-brand-text mx-3">BMIS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Nav::isRoute('admin.dashboard') }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                {{ __('Settings') }}
            </div>

            <!-- Nav Item - Buses -->
            <li class="nav-item {{ Nav::isRoute('admin.buses.*') }} {{  Nav::isRoute('admin.bus-classes.*')  }}">
                <a class="nav-link" href="{{ route('admin.buses.index') }}">
                    <i class="fas fa-fw fa-bus"></i>
                    <span>{{ __('Buses') }}</span>
                </a>
            </li>

            <!-- Nav Item - Terminals -->
            <li class="nav-item {{ Nav::isRoute('admin.terminals.*') }}">
                <a class="nav-link" href="{{ route('admin.terminals.index') }}">
                    <i class="fas fa-fw fa-warehouse"></i>
                    <span>{{ __('Terminals') }}</span>
                </a>
            </li>

            <!-- Nav Item - Routes -->
            <li class="nav-item {{ Nav::isRoute('admin.routes.*') }}">
                <a class="nav-link" href="{{ route('admin.routes.index') }}">
                    <i class="fas fa-fw fa-route"></i>
                    <span>{{ __('Routes') }}</span>
                </a>
            </li>



            <!-- Nav Item - Rides -->
            <li class="nav-item {{ Nav::isRoute('admin.rides.*') }}">
                <a class="nav-link" href="{{ route('admin.rides.index') }}">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>{{ __('Rides') }}</span>
                </a>
            </li>


            <!-- Nav Item - Bookings -->
            <li class="nav-item {{ Nav::isRoute('bookings.*') }}">
                <a class="nav-link" href="{{ route('bookings.my.bookings') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>{{ __('Bookings') }}</span>
                </a>
            </li>


            <!-- Nav Item - Sales -->
            <li class="nav-item {{ Nav::isRoute('admin.sales.*') }}">
                <a class="nav-link" href="{{ route('admin.sales.index') }}">
                    <i class="fas fa-fw fa-money-bill"></i>
                    <span>{{ __('Sales') }}</span>
                </a>
            </li>


            @role('superadmin')
                <!-- Nav Item - Users -->
                <li class="nav-item {{ Nav::isRoute('super.users.*') }}">
                    <a class="nav-link" href="{{ route('super.users.index') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>{{ __('Users') }}</span>
                    </a>
                </li>

            <!-- Nav Item - Passengers - super -->
            <li class="nav-item {{ Nav::isRoute('super.passengers*') }}">
                <a class="nav-link" href="{{ route('super.passengers') }}">
                    <i class="fas fa-fw fa-walking"></i>
                    <span>{{ __('Passengers') }}</span>
                </a>
            </li>

            @else

            <!-- Nav Item - Passengers - super -->
            <li class="nav-item {{ Nav::isRoute('admin.passengers*') }}">
                <a class="nav-link" href="{{ route('admin.passengers') }}">
                    <i class="fas fa-fw fa-walking"></i>
                    <span>{{ __('Passengers') }}</span>
                </a>
            </li>

            @endrole



            <!-- Nav Item - Employees -->
            <li class="nav-item {{ Nav::isRoute('admin.employees.*') }}">
                <a class="nav-link" href="{{ route('admin.employees.index') }}">
                    <i class="fas fa-fw fa-user-tie"></i>
                    <span>{{ __('Employees') }}</span>
                </a>
            </li>


            <!-- Nav Item - Profile -->
            <li class="nav-item {{ Nav::isRoute('admin.profile*') }}">
                <a class="nav-link" href="{{ route('admin.profile') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>{{ __('Profile') }}</span>
                </a>
            </li>

            <!-- Nav Item - About -->
            <li class="nav-item {{ Nav::isRoute('admin.report*') }}">
                <a class="nav-link" href="{{ route('admin.report.depart.arrive') }}">
                    <i class="fas fa-fw fa-hands-helping"></i>
                    <span>{{ __('Reports') }}</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Profile') }}
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->


                    @yield('main-content')


                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; BMIS 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

@yield('scripts')

</body>
</html>
