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
        <a class="nav-link" href="{{ route('sentiment') }}" style="background-color: #15202B; padding: 15px;" id="index">
        <img src="{{ asset('public/images/back.svg') }}" style="width: 17px; height: 17px; filter: invert(100%) sepia(3%) saturate(11%) hue-rotate(76deg) brightness(103%) contrast(103%);"/>
        Back
        </a>
    </li>
    </ul>
</div>
</nav>

<div class="container-fluid" style="margin-top: 20px; margin-bottom: 130px;">
<div class="row justify-content-center">
    <div class="col-xs-12 col-md-4 m-3" style="padding: 10px;">
        <div class="row" style="background-color: #1DA1F2; padding: 10px;">
            <div class="col">
                <h6 class="text-center" style="color: #15202B;">Sentiment Result of {{ $pf_name }}</h6>
                <p>Positive&emsp;&emsp;&emsp;&ensp;&nbsp;: <span id="p">..%</span></p>
                <p>Semi-Positive&emsp;&nbsp;: <span id="sp">..%</span></p>
                <p>Neutral&emsp;&emsp;&emsp;&ensp;&nbsp;: <span id="ne">..%</span></p>
                <p>Semi-Negative&ensp;: <span id="sn">..%</span></p>
                <p>Negative&emsp;&emsp;&emsp;: <span id="n">..%</span></p>
                <p style="color: #c51f5d;">Total tweet: <span id="tt">Max 100</span></p>
                <p class="font-weight-bold" style="color: #15202B;">Attitude: <span id="att">Good! or Bad!</span></p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4 m-2" style="padding: 10px; background-color: #1DA1F2;">
        <div class="card">
            <div class="card-body">
                <canvas id="bar" width="100%" height="100%" style="margin: 0 auto;"></canvas>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <canvas id="pie" width="100%" height="100%" style="margin: 0 auto;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-3 m-2" style="padding: 10px; background-color: #1DA1F2;">
        <h5 for="thewords" class="text-center" style="color: white;">The Words</h5>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <textarea class="form-control" id="thewords" rows="15"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        const response = @json($data);
        var tweetSum = 0;
        var thewords = "";
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
        $("#thewords").val(thewords);
        $("#p").text(Math.round(response.sentiment[0]/ tweetSum*10000)/100  + "%");
        $("#sp").text(Math.round(response.sentiment[1]/ tweetSum*10000)/100  + "%");
        $("#ne").text(Math.round(response.sentiment[2]/ tweetSum*10000)/100  + "%");
        $("#sn").text(Math.round(response.sentiment[3]/ tweetSum*10000)/100  + "%");
        $("#n").text(Math.round(response.sentiment[4] / tweetSum*10000)/100  + "%");
        $("#tt").text(tweetSum);
        $("#att").text(response.attitude);
        let barCtx = document.getElementById('bar').getContext('2d');
        let pieCtx = document.getElementById('pie').getContext('2d');
        const myBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ["Positive", "Semi-Positive", "Neutral", "Semi-Negative", "Negative"],
                datasets: [
                    {
                        label: "Tweet Count",
                        data: response.sentiment,
                        backgroundColor: 'rgba(197,31,93,0.5)',
                        borderColor: 'rgba(197,31,93,1)',
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
        const myPieChart = new Chart(pieCtx, {
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
    });
</script>

@include('sub.mainfooter')
</body>

</html>