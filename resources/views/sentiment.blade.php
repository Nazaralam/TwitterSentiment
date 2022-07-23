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
<div class="row justify-content-center">
    <div class="col">
        <h3 class="text-center mb-4" style="color: white;">Sentiment History</h3>
        <div class="card">
            <div class="card-body">
            <div class="row">
                <button onclick="sortByTotalAccess()" class="btn btn-primary ml-auto mr-2" id="sortbutton">Sort by Total Access</button>
            </div>
            <table class="table table-bordered table-responsive-md" id="tabel">
                <thead class="thead">
                    <th class="align-top" scope="col">Number</th>
                    <th class="align-top" scope="col">Datetime</th>
                    <th class="align-top" scope="col">Public Figure Name</th>
                    <th class="align-top" scope="col">Category</th>
                    <th class="align-top" scope="col">Total Access</th>
                    <th class="align-top" scope="col">Menu</th>
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
                        <td>{{ $s->figure->access }}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('sentiment.detail', $s->id) }}">Show</a>
                            <button class="btn btn-danger" onclick="deleteSentiment('{{ $s->id }}')">Delete</button>
                        </td>
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
    let table;
    var originalOrder = true;
    $(document).ready(function(){
        table = $('#tabel').DataTable({
            "columnDefs": [ 
                {
                    "orderable": false,
                    "targets": [0,1,2,3,4]
                } ,
                {
                    "searchable": false,
                    "targets": [0,4,5]
                } 
            ],
            "order": [[ 0, 'asc' ]]
        });
    });
    function sortByTotalAccess() {
        if(originalOrder) {
            table.order([ 4, 'desc' ]).draw();
            $("#sortbutton").text("Sort by Number");
            originalOrder = false;
        } else {
            table.order([ 0, 'asc' ]).draw();
            $("#sortbutton").text("Sort by Total Access");
            originalOrder = true;
        }
    }
    function deleteSentiment(id) {
        Swal.fire({
            title: "Are you sure want to delete this item?",
            confirmButtonText: "Yes",
            confirmButtonColor: '#5cb85c',
            cancelButtonColor: '#FF5252',
            showCancelButton: true,
            cancelButtonText: "Cancel",
            closeOnCancel: true,
            focusConfirm: false
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url: "{{ route('sentiment.delete') }}"+"/"+id,
                    type: "GET"
                }).done(function (response1) {
                    if(response1.row > 0) {
                        Swal.fire("Delete Success", "Item has been deleted.", "success").then((result1) => {
                            window.location.reload()
                        })
                    } else {
                        Swal.fire("Delete Failed", "", "error").then((result) => {})
                    }
                })
            }
        });
    }
</script>

@include('sub.mainfooter')
</body>

</html>