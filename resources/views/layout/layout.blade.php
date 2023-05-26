<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Inventory System</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    {{-- <link rel="icon" href="/assets/img/icon.ico" type="image/x-icon" /> --}}
    {{-- bawah ini buat ganti icon di bar atas web --}}
    <link rel="icon" href="/assets/img/warehouse logo.png" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['/assets/css/fonts.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/azzara.min.css">
</head>

<body>
    <div class="wrapper">
        <!--
    Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
  -->

        <div class="main-header" data-background-color="light-blue">
            <!-- Logo Header -->
            <div class="logo-header">

                <a href="#" class="logo text-center">
                    {{-- <img src="/assets/img/logoazzara.svg" alt="navbar brand" class="navbar-brand"> --}}
                    <h2 alt="navbar brand" class="navbar-brand font-weight-bold" style="color: white">Warehouse</h2>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa fa-bars"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
                <div class="navbar-minimize">
                    <button class="btn btn-minimize btn-rounded">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg">

                <div class="container-fluid">
                    {{-- <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form>
                    </div> --}}
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        {{-- <li class="nav-item toggle-nav-search hidden-caret">
                            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
                                aria-expanded="false" aria-controls="search-nav">
                                <i class="fa fa-search"></i>
                            </a>
                        </li> --}}
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="/assets/img/552721 user logo.png" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg"><img src="../../assets/img/552721 user logo.png"
                                                alt="image profile" class="avatar-img rounded"></div>
                                        <div class="u-text mt-2">
                                            <h4>{{ auth()->user()->name }}</h4>
                                            <p class="text-muted">{{ auth()->user()->email }}</p>
                                            {{-- <a href="profile.html"
                                                class="btn btn-rounded btn-danger btn-sm">View Profile</a> --}}
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    {{-- <div class="dropdown-divider"></div> --}}
                                    <a class="dropdown-item" href="/logout">Logout</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <!-- Sidebar -->
        <div class="sidebar">

            <div class="sidebar-wrapper scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="../../assets/img/552721 user logo.png" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" aria-expanded="true">
                                <span>
                                    {{ auth()->user()->name }}
                                    <span class="user-level">Role: {{ auth()->user()->level }}</span>
                                </span>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <ul class="nav">
                        <li class="nav-item @yield('home')">
                            <a href="/home">
                                <i class="fas fa-home"></i>
                                <p>Home</p>
                                {{-- <span class="badge badge-count">5</span> --}}
                            </a>
                        </li>
                        <li class="nav-item @yield('managecustomerbutton')">
                            <a data-toggle="collapse" href="#customer">
                                <i class="fa fa-users"></i>
                                <p>Manage Customer</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse @yield('showmanagecustomer')" id="customer">
                                <ul class="nav nav-collapse">
                                    <li class="@yield('newcustomer')">
                                        <a href="/newCustomer">
                                            <span class="sub-item">Add New Customer</span>
                                        </a>
                                    </li>
                                    <li class="@yield('managecustomer')">
                                        <a href="/manageCustomer">
                                            <span class="sub-item">Edit Customers</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item @yield('managebrandbutton')">
                            <a data-toggle="collapse" href="#brand">
                                <i class="fa fa-th-large"></i>
                                <p>Manage Brands</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse @yield('showmanagebrand')" id="brand">
                                <ul class="nav nav-collapse">
                                    <li class="@yield('newbrand')">
                                        <a href="/newBrand">
                                            <span class="sub-item">Add New Brand</span>
                                        </a>
                                    </li>
                                    <li class="@yield('managebrand')">
                                        <a href="/manageBrand">
                                            <span class="sub-item">Edit Brands</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item @yield('manageitembutton')">
                            <a data-toggle="collapse" href="#item">
                                <i class="fa fa-truck"></i>
                                <p>Manage Items</p>
                                <span class="caret"></span>
                            </a>
                            {{-- color of the pressed button is style="background-color: #f7f7f7" --}}
                            <div class="collapse @yield('showmanageitem')" id="item">
                                <ul class="nav nav-collapse">
                                    <li class="@yield('newitem')">
                                        <a href="/newItem">
                                            <span class="sub-item">Add New Item</span>
                                        </a>
                                    </li>
                                    <li class="@yield('manageitem')">
                                        <a href="/manageItem">
                                            <span class="sub-item">Edit Items</span>
                                        </a>
                                    </li>
                                    <li class="@yield('managehistory')">
                                        <a href="/manageHistory">
                                            <span class="sub-item">History</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @auth
                            @if (Auth::user()->level == 'admin')
                                <li class="nav-section">
                                    <span class="sidebar-mini-icon">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </span>
                                    <h4 class="text-section">Admin Only</h4>
                                </li>
                                <li class="nav-item @yield('manageuserbutton')">
                                    <a data-toggle="collapse" href="#user">
                                        <i class="fas fa-user"></i>
                                        <p>Manage Users</p>
                                        <span class="caret"></span>
                                    </a>
                                    {{-- ni jangan lupa buat ganti idnya --}}
                                    <div class="collapse @yield('showmanageuser')" id="user">
                                        <ul class="nav nav-collapse">
                                            <li class="@yield('newuser')">
                                                <a href="/newUser">
                                                    <span class="sub-item">Create New User</span>
                                                </a>
                                            </li>
                                            {{-- <li class="active"> itu pake class active buat nge darken kyk button gt --}}
                                            <li class="@yield('manageuser')">
                                                <a href="/manageUser">
                                                    <span class="sub-item">Edit Users</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
        @include('sweetalert::alert')
    </div>
    <!--   Core JS Files   -->
    <script src="/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <!-- jQuery UI -->
    <script src="/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <!-- Bootstrap Toggle -->
    <script src="/assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
    <!-- jQuery Scrollbar -->
    <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="/assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Azzara JS -->
    <script src="/assets/js/ready.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-row').DataTable({});
        });
    </script>
</body>

</html>
