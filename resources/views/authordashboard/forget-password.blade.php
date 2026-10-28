<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - BFC Author Dashboard</title>
    <link type="text/css" rel="stylesheet" href="{{ base_url() }}authordashboard/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ base_url() }}authordashboard/assets/css/style.css">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            {!! session('msg') !!}
            <h3>Forgot Password</h3>
            <form action="{{ base_url() }}AuthorDashboard/send_email" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="emailid" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
                <a href="{{ base_url() }}AuthorDashboard/login" class="btn btn-link">Back to login</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
