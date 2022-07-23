<!--menu navigasi-->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1DA1F2;">

<!--tombol hamburger menu navigasi (akan muncul ketika bukan size desktop)-->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<!--isi menu navigasi yang dapat hilang ketika tampilan bukan di desktop-->
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    
    @if(Session::has('pengguna'))
    <h4 class="mt-2 mb-2" style="color: white;">Hello, {{Session::get('pengguna')->name}}!</h4>
    @endif
    <ul class="navbar-nav ml-auto">
    @if(Session::has('pengguna'))
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('index') }}" style="background-color: #15202B; padding: 15px;" id="index">Home</a>
    </li>
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('comparison') }}" id="comparison" style="background-color: #c51f5d; padding: 15px;">Comparison</a>
    </li>
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('profile.home') }}" id="profile" style="background-color: #15202B; padding: 12px;">
            <img src="{{asset('public/storage/profile/'.Session::get('pengguna')->picture)}}" style="width: 30px; height: 30px;" class="img-fluid rounded-circle mr-2"/>
            Profile
        </a>
    </li>
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('logout') }}" style="background-color: #15202B; padding: 15px;" id="logout">Logout</a>
    </li>
    @else
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('index') }}" style="background-color: #15202B; padding: 15px;" id="index">Login</a>
    </li>
    @endif
    </ul>
</div>
</nav>