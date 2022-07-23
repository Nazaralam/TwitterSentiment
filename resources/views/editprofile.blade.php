<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">

    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-autocomplete.min.js') }}"></script>
    <script src="{{ asset('public/js/sweetalert2.all.min.js') }}"></script>

    <title>Public Figure Analysis Sentiment</title>
</head>

<body height="100%" style="margin-bottom: 7rem; background-color: #15202B;">

<!--navigation menu-->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1DA1F2;">

<!--show hamburger navigation (responsive)-->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<!--the contents of the navigation menu can be lost when the display is not on the desktop-->
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    @if(Session::has('pengguna'))
    <h4 class="mt-2 mb-2" style="color: white;">Hello, {{Session::get('pengguna')->name}}!</h4>
    @endif
    <ul class="navbar-nav ml-auto">
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('profile.home') }}" style="background-color: #15202B; padding: 15px;" id="index">
        <img src="{{ asset('public/images/back.svg') }}" style="width: 17px; height: 17px; filter: invert(100%) sepia(3%) saturate(11%) hue-rotate(76deg) brightness(103%) contrast(103%);"/>
        Back
        </a>
    </li>
    </ul>
</div>
</nav>

<div class="container-fluid" style="margin-top: 20px; margin-bottom: 130px;">
@isset($alert_msg)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $alert_msg }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endisset
<div class="row grid justify-content-center">
    <div class="col-xs-12 col-md-6 mt-4">
        <div class="card-transparent">
            <div class="card-body">
                <div class="col text-center">
                    <img src="{{asset('public/storage/profile/'.Session::get('pengguna')->picture)}}" style="width: 170px; height: 170px;" class="img-fluid rounded-circle mr-2"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 mt-4">
        <div class="card-transparent">
            <div class="card-body">
                <form action="{{ route('profile.post') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ Session::get('pengguna')->id }}"/>
                    <div class="form-group">
                        <label for="name" style="color: #8899A6;">Name</label>
                        <input type="text" value="{{ Session::get('pengguna')->name }}" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="username" style="color: #8899A6;">Username</label>
                        <input type="text"  value="{{ Session::get('pengguna')->username }}" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="pass" style="color: #8899A6;">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>
                    <div class="form-group">
                        <label for="cpass" style="color: #8899A6;">Confirm Password</label>
                        <input type="password" class="form-control" id="cpass" name="cpass">
                        <div class="invalid-feedback">
                            Confirm Password not match
                        </div>
                    </div>
                    <label style="color: #8899A6;">Profile Picture</label>
                    <div class="custom-file">
                        <input type="file" value="{{ old('profile') }}" class="custom-file-input" name="profile" id="profile" accept=".png,.jpeg,.jpg">
                        <label class="custom-file-label" for="profile" id="profile_name">File Name</label>
                    </div>
                    <div class="row mt-4" width="100%">
                        <div class="col" width="100%">
                            <button type="submit" style="background-color: #1DA1F2; color: white;" class="btn btn-block btn-primary" id="register" name="register" value="register">Update</button>
                        </div>
                        <div class="col" width="100%">
                            <button type="button" style="background-color: white; color: #1DA1F2;" onclick="resetFields()" class="btn btn-block btn-primary">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    var confirmValid = true;
    $(document).ready(function(){
        var table = $('#tabel').DataTable({
            "columnDefs": [ 
                {
                    "orderable": false,
                    "targets": [0,1,2]
                } ,
                {
                    "searchable": false,
                    "targets": [0]
                } 
            ],
            "order": [[ 0, 'asc' ]]
        });
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
                Swal.fire({
                    title: "Are you sure want to update the profile?",
                    confirmButtonText: "Yes",
                    confirmButtonColor: '#5cb85c',
                    cancelButtonColor: '#FF5252',
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    closeOnCancel: true,
                    focusConfirm: false
                }).then((result) => {
                    if(result.value) {
                        form.submit();
                    }
                });
            } else {
                $('#cpass').addClass('is-invalid');
            }
        });
    });



    function resetFields() {
        $('#name').val("{{ Session::get('pengguna')->name }}");
        $('#username').val("{{ Session::get('pengguna')->username }}");
        $('#pass').val("");
        $('#cpass').val("");
        $('#profile').val("");
        $('#profile_name').text("File Name");
    }
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var nama = document.getElementById("profile").files[0].name;
        var sib = e.target.nextElementSibling;
        sib.innerText = nama;
    })
</script>

@include('sub.mainfooter')
</body>

</html>