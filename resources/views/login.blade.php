<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">

    <script src="{{ asset('public/js/jquery.min.js') }}"></script>

    <title>Public Figure Analysis Sentiment</title>
</head>

<body height="100%" style="margin-bottom: 7rem; background-color: #15202B;">
@include('sub.mainheader')

<div class="container-fluid" style="margin-top: 80px; margin-bottom: 130px;">
@isset($alert_msg)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $alert_msg }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endisset
<div class="row justify-content-center">
    <div class="card-transparent" style="width: 20rem;">
        <div class="card-body">
        <h3 class="card-title text-center" style="color: #8899A6;">Login</h3>
        <form action="{{ route('login.post') }}" method="post" enctype="application/x-www-form-urlencoded">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="username" style="color: #8899A6;">Username</label>
                <input type="text" class="form-control" value="{{ old('username') }}" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="pass" style="color: #8899A6;">Password</label>
                <input type="password" class="form-control" minlength="8" id="pass" name="pass" value="{{ old('pass') }}" required>
            </div>
            <div class="row mt-4 justify-content-center">
                <button type="submit" style="background-color: #1DA1F2; width: 100px;" class="btn btn-primary" id="login" name="login" value="login">Login</button>
            </div>
            <div class="row mt-3 justify-content-center">
                <a style="background-color: #1DA1F2; width: 100px;" class="btn btn-primary" id="register" href="{{ route('register') }}">Register</a>
            </div>
        </form>
        </div>
        </div>
    </div>
</div>

</div>

<script>
    var nav = document.getElementById("index");
    nav.classList.add("active");
</script>

@include('sub.mainfooter')
</body>

</html>