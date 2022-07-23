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

<body height="100%" style="margin-bottom: 7rem;">

<!--navigation menu-->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #c51f5d; color: #15202B;">

<!--show hamburger navigation (responsive)-->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<!--the contents of the navigation menu can be lost when the display is not on the desktop-->
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    @if(Session::has('pengguna'))
    <h4 class="mt-2 mb-2" style="color: white;">Compare between data!</h4>
    @endif
    <ul class="navbar-nav ml-auto">
    <li class="nav-item mr-2">
        <a class="nav-link" href="{{ route('index') }}" style="background-color: #15202B; padding: 15px;" id="index">
        <img src="{{ asset('public/images/back.svg') }}" style="width: 17px; height: 17px; filter: invert(100%) sepia(3%) saturate(11%) hue-rotate(76deg) brightness(103%) contrast(103%);"/>
        Back
        </a>
    </li>
    </ul>
</div>
</nav>

<div class="container-fluid" style="margin-top: 20px; margin-bottom: 130px;">
<div class="row justify-content-center">
    @for($i = 0 ; $i < 2; $i++)
    <div class="col-xs-12 m-2 col-md-5">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-md-5 m-2" style="padding: 10px;">
                <div class="form-group">
                    <label for="cari" style="color: #15202B;">Input the Public Figure Name:</label>
                    <input class="form-control basicAutoComplete" id="cari{{$i}}" type="text" autocomplete="off">
                </div>
                <div class="row mb-4">
                    <div class="col" width="100%">
                        <button type="button" style="background-color: #c51f5d; color: #15202B;" class="btn btn-block btn-primary" onclick="analysisFigure('{{$i}}')">Search</button>
                    </div>
                    <div class="col" width="100%">
                        <button type="button" style="background-color: #15202B; color: #c51f5d;" class="btn btn-block btn-primary" onclick="clearFigure('{{$i}}')">Clear</button>
                    </div>
                </div>
                <div class="row mb-4" style="background-color: #8899A6; padding: 10px;">
                    <div class="col">
                        <h6 class="text-center" style="color: #15202B;">Public Figure Data</h6>
                        <p>Category&nbsp;: <span id="category_pf{{$i}}">-</span></p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 m-2">
                <div class="row" style="background-color: #8899A6; padding: 10px;">
                    <div class="col">
                        <h6 class="text-center" style="color: #c51f5d;">Sentiment Result</h6>
                        <p style="color: #15202B;">Positive&emsp;&emsp;&emsp;&ensp;&nbsp;: <span id="p{{$i}}">..%</span></p>
                        <p style="color: #15202B;">Semi-Positive&emsp;&nbsp;: <span id="sp{{$i}}">..%</span></p>
                        <p style="color: #15202B;">Neutral&emsp;&emsp;&emsp;&ensp;&nbsp;: <span id="ne{{$i}}">..%</span></p>
                        <p style="color: #15202B;">Semi-Negative&ensp;: <span id="sn{{$i}}">..%</span></p>
                        <p style="color: #15202B;">Negative&emsp;&emsp;&emsp;: <span id="n{{$i}}">..%</span></p>
                        <p style="color: white;">Total tweet: <span id="tt{{$i}}">Max 100</span></p>
                        <p class="font-weight-bold">Attitude: <span id="att{{$i}}">Good! or Bad!</span></p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-11 m-2" style="padding: 10px; background-color: #8899A6;">
            <h5 for="thewords" class="text-center" style="color: white;">CHART</h5>
                <div class="card">
                    <div class="card-body">
                        <canvas id="bar{{$i}}" width="100%" height="100%" style="margin: 0 auto;"></canvas>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <canvas id="pie{{$i}}" width="100%" height="100%" style="margin: 0 auto;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endfor
</div>
</div>

<script>
    const penggunaData = @json(Session::get('pengguna'));
    var globalSearchRef = []
    var myBarChart = [null, null]
    var myPieChart = [null, null]
    function clearFigure(i) {
        $("#cari"+i).val("");
        $("#category_pf"+i).text("-");
        $("#p"+i).text("..%");
        $("#sp"+i).text("..%");
        $("#ne"+i).text("..%");
        $("#sn"+i).text("..%");
        $("#n"+i).text("..%");
        $("#tt"+i).text("Max 100");
        $("#att"+i).text("Good! or Bad!");
        if(myBarChart[parseInt(i)])
            myBarChart[parseInt(i)].destroy()
        if(myPieChart[parseInt(i)])
            myPieChart[parseInt(i)].destroy()
    }
    function analysisResult(response, fromOnline, x) {
        $.ajax({
            url: "{{ route('figure_detail') }}"+"/"+$("#cari"+x).val(),
            type: "GET"
        }).done(function (response) {
            $("#category_pf"+x).text(response.category);
        })
        var thewords = ""
        var tweetSum = 0
        if(myBarChart[parseInt(x)])
            myBarChart[parseInt(x)].destroy()
        if(myPieChart[parseInt(x)])
            myPieChart[parseInt(x)].destroy()
        for(var i=0; i<response.sentiment.length; i++) {
            tweetSum += response.sentiment[i]
        }
        for(var i=0; i<response.data.length; i++) {
            var tmpSentiment = "Neutral"
            if(response.data[i].sentiment == "--")
                tmpSentiment = "Negative"
            else if(response.data[i].sentiment == "-")
                tmpSentiment = "Semi-Negative"
            else if(response.data[i].sentiment == "+")
                tmpSentiment = "Semi-Positive"
            else if(response.data[i].sentiment == "++")
                tmpSentiment = "Positive"
            thewords += response.data[i].tweet+
                " (Sentiment Result: "+tmpSentiment+"; Subjectivity: "+
                response.data[i].subjectivity+")\n\n";
        }
        $("#p"+x).text(Math.round(response.sentiment[0]/ tweetSum*10000)/100  + "%");
        $("#sp"+x).text(Math.round(response.sentiment[1]/ tweetSum*10000)/100  + "%");
        $("#ne"+x).text(Math.round(response.sentiment[2]/ tweetSum*10000)/100  + "%");
        $("#sn"+x).text(Math.round(response.sentiment[3]/ tweetSum*10000)/100  + "%");
        $("#n"+x).text(Math.round(response.sentiment[4] / tweetSum*10000)/100  + "%");
        $("#tt"+x).text(tweetSum);
        $("#att"+x).text(response.attitude);
        let barCtx = document.getElementById('bar'+x).getContext('2d');
        let pieCtx = document.getElementById('pie'+x).getContext('2d');
        myBarChart[parseInt(x)] = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ["Positive", "Semi-Positive", "Neutral", "Semi-Negative", "Negative"],
                datasets: [
                    {
                        label: "Tweet Count",
                        data: response.sentiment,
                        backgroundColor: 'rgba(29, 161, 242, 0.5)',
                        borderColor: 'rgba(29, 161, 242, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        let pieColors = []
        for(var i=0; i<response.sentiment.length; i++)
            pieColors.push("#"+Math.floor(Math.random()*16777215).toString(16))
        myPieChart[parseInt(x)] = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ["Positive", "Semi-Positive", "Neutral", "Semi-Negative", "Negative"],
                datasets: [
                    {
                        label: "Tweet Count",
                        data: response.sentiment,
                        backgroundColor: pieColors,
                        borderColor: 'rgba(197,31,93,1)',
                        borderWidth: 1
                    }
                ]
            }
        });
        if(fromOnline) {
            const jsonPostData = {
                    pengguna: penggunaData,
                    figure: $("#cari"+x).val(),
                    data: response
                };
            $.ajax({
                url: "{{ route('index.post') }}",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(jsonPostData)
            }).done(function (response1) {
                if(!response1.success) {
                    Swal.fire("Save Failed", "This search data not saved into database", "error").then((result) => {})
                }
            })
        }
    }
    function analysisFigure(x) {
        let cari = $("#cari"+x).val().toLowerCase()
        if(globalSearchRef.indexOf(cari) > -1) {
            $.ajax({
                url: "{{ $flask_api }}"+cari,
                type: "GET",
                crossDomain: true,
                timeout: 7000,
                headers: {
                    accept: "application/json",
                    "Access-Control-Allow-Origin": "*"
                }
            }).done(function (response) {
                analysisResult(response, true, x)
            }).fail(function(err, status) {
                Swal.fire("Online Search Failed", "Searching by latest local data...", "warning").then((result1) => {
                    $.ajax({
                        url: "{{ route('search.latest') }}"+"/"+cari+"/"+penggunaData.id,
                        type: "GET"
                    }).done(function (response1) {
                        if(response1.success) {
                            analysisResult(response1.data, false, x)
                        } else {
                            Swal.fire("Search Failed", response1.msg, "error").then((result) => {})
                        }
                    })
                })
            });
        } else {
            Swal.fire("Search Failed", "Public figure not found", "error").then((result) => {})
        }
    }

    $(document).ready(function(){
        $.ajax("{{ route('pf') }}").done(function (searchRef) {
            globalSearchRef = searchRef
            $('.basicAutoComplete').autoComplete({
                minLength: 1,
                events: {
                    search: function(qry, callback) {
                        var finalSearch = searchRef.filter(item => item.substring(0, qry.length) == qry.toLowerCase())
                        callback(finalSearch)
                    }
                }
            });
        });
    });
</script>

<footer class="sticky-footer" style="padding: 1rem; position: fixed; bottom: 0; width: 100%; background-color: #c51f5d; color: #15202B;">
    <div class="container my-auto">
    <div class="copyright text-center my-auto">
        <span class="text-white"> &copy; ATSPAS || Nazar Alam <script>document.write(new Date().getFullYear());</script></span>
    </div>
    </div>
</footer>

<script src="{{ asset('public/js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/js/popper.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>

</body>

</html>