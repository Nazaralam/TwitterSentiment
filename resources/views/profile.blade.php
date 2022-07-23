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
        <a class="nav-link" href="{{ route('index') }}" style="background-color: #15202B; padding: 15px;" id="index">
        <img src="{{ asset('public/images/back.svg') }}" style="width: 17px; height: 17px; filter: invert(100%) sepia(3%) saturate(11%) hue-rotate(76deg) brightness(103%) contrast(103%);"/>
        Back
        </a>
    </li>
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('profile') }}" style="background-color: #15202B; padding: 15px;" id="profile">
        <img src="{{ asset('public/images/settings.svg') }}" style="width: 17px; height: 17px; filter: invert(100%) sepia(3%) saturate(11%) hue-rotate(76deg) brightness(103%) contrast(103%);"/>
        Edit Profile
        </a>
    </li>
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('sentiment') }}" style="background-color: #15202B; padding: 15px;" id="sentiment">
        <img src="{{ asset('public/images/history.svg') }}" style="width: 17px; height: 17px; filter: invert(100%) sepia(3%) saturate(11%) hue-rotate(76deg) brightness(103%) contrast(103%);"/>
        Sentiment History
        </a>
    </li>
    </ul>
</div>
</nav>

<div class="container-fluid" style="margin-top: 20px; margin-bottom: 130px;">
<div class="row grid justify-content-center">
    <div class="col-xs-12 col-md-6 mt-4">
        <div class="card-transparent">
            <div class="card-body">
                <div class="col text-center">
                    <img src="{{asset('public/storage/profile/'.Session::get('pengguna')->picture)}}" style="width: 170px; height: 170px;" class="img-fluid rounded-circle mr-2"/>
                    <h6 style="color: white; margin-top: 30px;">
                    Nama : {{ Session::get('pengguna')->name }}
                    </h6>
                    <h6 style="color: white;">
                    Username : {{ Session::get('pengguna')->username }}
                    </h6><br><br>
                    <h6 style="color: grey; font-size: 10px opacity: 50%">
                    This application is appplication for analyze the sentiment of public figure to know the stigma 
                    of each public figure from sentiment opinion from tweet in Twitter.
                    </h6>    
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 mt-4">
        <div class="card">
            <div class="card-body">
            <table class="table table-bordered table-responsive-md" id="tabel">
                <thead class="thead">
                    <th class="align-top" scope="col">Number</th>
                    <th class="align-top" scope="col">Datetime</th>
                    <th class="align-top" scope="col">Public Figure Name</th>
                    <th class="align-top" scope="col">Category</th>
                </thead>
                <tbody>
                    @php
                    $cnt = 1;
                    @endphp
                    @foreach($data as $s)
                    <tr>
                        <td>{{ $cnt++ }}</td>
                        <td>{{ $s->created_at }}</td>
                        <td>{{ $s->figure->name }}</td>
                        <td>{{ $s->figure->category }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function(){
        var table = $('#tabel').DataTable({
            "columnDefs": [ 
                {
                    "orderable": false,
                    "targets": [0,1,2,3]
                } ,
                {
                    "searchable": false,
                    "targets": [0]
                } 
            ],
            "order": [[ 0, 'asc' ]]
        });
    });
</script>

@include('sub.mainfooter')
</body>

</html>