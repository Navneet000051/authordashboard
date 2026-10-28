<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> BFC Author Dashboard</title>
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ base_url() }}authordashboard/assets/img/favicon.ico" type="image/x-icon">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ base_url() }}authordashboard/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="{{ base_url() }}authordashboard/assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="{{ base_url() }}authordashboard/assets/fonts/flaticon/font/flaticon.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="{{ base_url() }}authordashboard/assets/css/style.css">
    @yield('head')
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ base_url() }}AuthorDashboard"><img src="{{ base_url() }}authordashboard/assets/img/pub_logo.png" alt="" class="img-fluid header-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ base_url() }}AuthorDashboard">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ base_url() }}AuthorDashboard/payable">View Sales Ledger</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ base_url() }}AuthorDashboard/salesreport">View Sales Report</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span><img src="{{ base_url() }}authordashboard/assets/img/icon.png" class="img-fluid navbar-icon pr-2"></span> {{ session('author_login')['userName'] ?? '' }} </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ base_url() }}AuthorDashboard/myprofile"><span><img src="{{ base_url() }}authordashboard/assets/img/navbar-icon/profile.png" alt="" class="img-fluid navbar-icon"></span> My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ base_url() }}AuthorDashboard/change_password"><span><img src="{{ base_url() }}authordashboard/assets/img/navbar-icon/reset-password.png" alt="" class="img-fluid navbar-icon"></span> Change Password </a></li>

                            <li><a class="dropdown-item" href="{{ base_url() }}AuthorDashboard/myOrder"><span><img src="{{ base_url() }}authordashboard/assets/img/navbar-icon/reset-password.png" alt="" class="img-fluid navbar-icon"></span> My Order </a></li>
                            @if((session('author_login')['lead_new'] ?? '') == '1' || (session('author_login')['lead_new'] ?? '') == '4')
                            <li><a class="dropdown-item" href="{{ base_url() }}AuthorDashboard/work_status"><span><img src="{{ base_url() }}authordashboard/assets/img/navbar-icon/reset-password.png" alt="" class="img-fluid navbar-icon"></span> Project Status </a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ base_url() }}AuthorDashboard/logout"><span><img src="{{ base_url() }}authordashboard/assets/img/navbar-icon/logout.png" alt="" class="img-fluid navbar-icon"></span>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<style>
.form-select{
    color:black;
}
</style>

@yield('content')

<!-- External JS libraries -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
<script src="{{ base_url() }}authordashboard/assets/js/popper.min.js"></script>
<script src="{{ base_url() }}authordashboard/assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    // Send the CSRF token with every AJAX request (ported POST endpoints).
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $("input").on("keypress", function(e) {
        if (e.which === 32 && !this.value.length)
            e.preventDefault();
    });
</script>

<footer class="pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>Copyright &copy; BFC Publications - {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</footer>

@yield('scripts')
</body>
</html>
