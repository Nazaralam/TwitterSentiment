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
@include('sub.mainheader')

<div class="container-fluid" style="margin-top: 30px; margin-bottom: 130px;">
<div class="row justify-content-center">
    <div class="col-xs-12 col-md-4 m-3" style="padding: 10px;">
        <div class="row mb-4" style="background-color: white; padding: 10px;">
            <div class="col">
                <h6 class="text-center" style="color: #15202B;">Total Attitude</h6>
                <p>Good&emsp;: <span id="good_pf">-</span></p>
                <p>Bad&emsp;&ensp;&nbsp;: <span id="bad_pf">-</span></p>
                <p>Neutral&nbsp;: <span id="neutral_pf">-</span></p>
            </div>
        </div>
        <div class="form-group">
            <label for="cari" style="color: white;">Input the Public Figure Name:</label>
            <input class="form-control basicAutoComplete" id="cari" type="text" autocomplete="off">
        </div>
        <div class="row mb-4">
            <div class="col" width="100%">
                <button type="button" style="background-color: #1DA1F2;" class="btn btn-block btn-primary" onclick="analysisFigure()">Search</button>
            </div>
            <div class="col" width="100%">
                <button type="button" style="background-color: white; color: #1DA1F2;" class="btn btn-block btn-primary" onclick="clearFigure()">Clear</button>
            </div>
        </div>
        <div class="row mb-4" style="background-color: white; padding: 10px;">
            <div class="col">
                <h6 class="text-center" style="color: #15202B;">Public Figure Data</h6>
                <p>Category&nbsp;: <span id="category_pf">-</span></p>
            </div>
        </div>
        <div class="row" style="background-color: white; padding: 10px;">
            <div class="col">
                <h6 class="text-center" style="color: #15202B;">Sentiment Result</h6>
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
    <h5 for="thewords" class="text-center" style="color: white;">CHART</h5>
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
    var nav = document.getElementById("index");
    nav.classList.add("active");
    const penggunaData = @json(Session::get('pengguna'));
    var globalSearchRef = []
    var myBarChart = null
    var myPieChart = null
    function clearFigure() {
        $("#cari").val("");
        $("#thewords").val("");
        $("#category_pf").text("-");
        $("#p").text("..%");
        $("#sp").text("..%");
        $("#ne").text("..%");
        $("#sn").text("..%");
        $("#n").text("..%");
        $("#tt").text("Max 100");
        $("#att").text("Good! or Bad!");
        if(myBarChart)
            myBarChart.destroy()
        if(myPieChart)
            myPieChart.destroy()
    }
    function totalAttitude() {
        $.ajax({
            url: "{{ route('attitude') }}",
            type: "GET"
        }).done(function (response) {
            $("#good_pf").text(response.good_pf);
            $("#bad_pf").text(response.bad_pf);
            $("#neutral_pf").text(response.neutral_pf);
        })
    }
    function analysisResult(response, fromOnline) {
        $.ajax({
            url: "{{ route('figure_detail') }}"+"/"+$("#cari").val(),
            type: "GET"
        }).done(function (response) {
            $("#category_pf").text(response.category);
        })
        var thewords = ""
        var tweetSum = 0
        if(myBarChart)
            myBarChart.destroy()
        if(myPieChart)
            myPieChart.destroy()
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
        myBarChart = new Chart(barCtx, {
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
        myPieChart = new Chart(pieCtx, {
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
                    figure: $("#cari").val(),
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
                } else {
                    totalAttitude()
                }
            })
        }
    }
    function analysisFigure() {
        let cari = $("#cari").val().toLowerCase()
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
                analysisResult(response, true)
            }).fail(function(err, status) {
                Swal.fire("Online Search Failed", "Searching by latest local data...", "warning").then((result1) => {
                    $.ajax({
                        url: "{{ route('search.latest') }}"+"/"+cari+"/"+penggunaData.id,
                        type: "GET"
                    }).done(function (response1) {
                        if(response1.success) {
                            analysisResult(response1.data, false)
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
    $(document).ready(function() {
        totalAttitude();
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

@include('sub.mainfooter')
</body>

</html>