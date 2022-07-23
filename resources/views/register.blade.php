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

<div class="container-fluid" style="margin-top: 50px; margin-bottom: 80px;">
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
        <h3 class="card-title text-center" style="color: #8899A6;">Sign Up</h3>
        <form action="{{ route('register.post') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="name" style="color: #8899A6;">Name</label>
                <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="username" style="color: #8899A6;">Username</label>
                <input type="text" value="{{ old('username') }}" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="pass" style="color: #8899A6;">Password</label>
                <input type="password" value="{{ old('pass') }}" minlength="8" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="form-group">
                <label for="cpass" style="color: #8899A6;">Confirm Password</label>
                <input type="password" value="{{ old('cpass') }}" minlength="8" class="form-control" id="cpass" name="cpass" required>
                <div class="invalid-feedback">
                    Confirm Password not match
                </div>
            </div>
            <label style="color: #8899A6;">Profile Picture</label>
            <div class="custom-file">
                <input type="file" value="{{ old('profile') }}" class="custom-file-input" name="profile" id="profile" accept=".png,.jpeg,.jpg" required>
                <label class="custom-file-label" for="profile" id="profile_name">File Name</label>
            </div>
            <div class="row mt-4" width="100%">
                <div class="col" width="100%">
                    <button type="submit" style="background-color: white; color: #1DA1F2;" class="btn btn-block btn-primary" id="register" name="register" value="register">Register</button>
                </div>
                <div class="col" width="100%">
                    <button type="button" style="background-color: white; color: #1DA1F2;" onclick="resetFields()" class="btn btn-block btn-primary">Reset</button>
                </div>
            </div>
            <a style="background-color: #1DA1F2;" class="btn mt-3 btn-block btn-primary" id="login" href="{{ route('index') }}">Login</a>
        </form>
        </div>
        </div>
    </div>
</div>

</div>

<script>
    var confirmValid = false;
    function resetFields() {
        $('#name').val("");
        $('#username').val("");
        $('#pass').val("");
        $('#cpass').val("");
        $('#profile').val("");
        $('#profile_name').text("File Name");
    }
    $("#pass").on('input', function() {
        confirmValid = $('#cpass').val() == $(this).val();
    })
    $("#cpass").on('input', function() {
        confirmValid = $('#pass').val() == $(this).val();
        if(!confirmValid) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    $('#register').on('click',function(e){
        e.preventDefault();
        var form = $(this).parents('form');
        if(confirmValid) {
            form.submit();
        } else {
            $('#cpass').addClass('is-invalid');
        }
    });
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var nama = document.getElementById("profile").files[0].name;
        var sib = e.target.nextElementSibling;
        sib.innerText = nama;
    })
</script>

@include('sub.mainfooter')
</body>

</html>