<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> BFC Author Dashboard</title>
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ base_url() }}authordashboard/assets/img/favicon.ico" type="image/x-icon">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ base_url() }}authordashboard/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="{{ base_url() }}authordashboard/assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="{{ base_url() }}authordashboard/assets/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="{{ base_url() }}authordashboard/assets/css/style.css">

    <style>
    label.error {
        color: #ff0000;
        display: flex;
        padding-left: 24px !important;
        padding-top: 8px !important;
    }
    </style>
</head>
<body>

{!! session('email_sent') !!}
<!-- Login 2 start -->
<div class="login-2">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-10">
                <div class="row login-box">
                    <div class="col-lg-6 col-md-12 bg-img">
                        <div class="info">
                            <div class="info-img text-center">
                                <img src="{{ base_url() }}authordashboard/assets/img/pub_logo.png" alt="logo">
                            </div>
                            <div class="info-text">
                                <p>Take control of your creative journey.
Track key indicators such as sales trends, revenue, and royalties, and stay updated on the performance of your books.</p>
                                <div class="social-buttons">
                                    <a href="https://www.facebook.com/bfcpublicationsindia" class="social-button social-button-facebook">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="https://twitter.com/BfcPublications" class="social-button social-button-twitter" target="_blank">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/X_logo_2023_original.svg" width="18" alt="X">
                                    </a>
                                    <a href="https://www.instagram.com/bfc_publications/" class="social-button social-button-google">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/company/bfc-publications/" class="social-button social-button-linkedin">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 form-info">
                        <div class="form-section">

                            @if(!empty(session('error_msg')))
                            <div class="alert alert-danger">
                                <strong>Error!</strong> {!! session('error_msg') !!}
                            </div>
                            @endif

                            <h3>Sign In Now</h3>
                            <div class="login-inner-form">
                                <form action="{{ base_url() }}AuthorDashboard/author_login" id="login_form" method="POST">
                                    @csrf
                                    <div class="form-group form-box">
                                        <input type="email" name="email" class="form-control" placeholder="Email Address" aria-label="Email Address">
                                        <i class="flaticon-mail-2"></i>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password" aria-label="Password">
                                        <i class="flaticon-password"></i>
                                        {!! form_error('pass') !!}
                                        {!! session('message') !!}
                                        {!! session('msg_class') !!}
                                        {!! session('msg') !!}
                                    </div>
                                    <div class="checkbox form-group form-box">
                                        <div class="form-check checkbox-theme">
                                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" name="submit" class="btn-md btn-theme w-100">Login</button>
                                    </div>
                                    <p class="text"><a href="https://bfcpublications.com/"> Go To Home Page</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login 2 end -->

<!-- External JS libraries -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
<script src="{{ base_url() }}authordashboard/assets/js/popper.min.js"></script>
<script src="{{ base_url() }}authordashboard/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<script>
    $("input").on("keypress", function(e) {
        if (e.which === 32 && !this.value.length)
            e.preventDefault();
    });
    $(document).ready(function($) {
        $("#login_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true
                },
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email: "Please enter valid email",
                },
                password: {
                    required: "Please enter your  password"
                },
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio")) {
                    error.appendTo(element.parents('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });

    window.setTimeout(function() {
        $(".alert").fadeTo(800, 0).slideUp(200, function(){
            $(this).remove();
        });
    }, 4000);
</script>
