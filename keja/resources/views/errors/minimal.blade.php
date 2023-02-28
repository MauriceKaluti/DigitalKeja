<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">



        <!-- Styles -->
        <style>
            body {
                background-color: #eee;
            }

            body, h1, p {
                font-family: "Helvetica Neue", "Segoe UI", Segoe, Helvetica, Arial, "Lucida Grande", sans-serif;
                font-weight: normal;
                margin: 0;
                padding: 0;
                text-align: center;
            }

            .container {
                margin-left:  auto;
                margin-right:  auto;
                margin-top: 177px;
                max-width: 1170px;
                padding-right: 15px;
                padding-left: 15px;
            }

            .row:before, .row:after {
                display: table;
                content: " ";
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-push-3 {
                margin-left: 25%;
            }

            h1 {
                font-size: 48px;
                font-weight: 300;
                margin: 0 0 20px 0;
            }

            .lead {
                font-size: 21px;
                font-weight: 200;
                margin-bottom: 20px;
            }

            p {
                margin: 0 0 10px;
            }

            a {
                color: #3282e6;
                text-decoration: none;
            }
            .button {
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
            }

        </style>

    </head>
    <body>


    <div class="container text-center" id="error">
        <svg height="100" width="100">
            <polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:none;stroke:#ff8a00;stroke-width:8" />
            <text x="42" y="74" fill="#ff8a00" font-family="sans-serif" font-weight="900" font-size="42px">!</text>
        </svg>
        <div class="row">
            <div class="col-md-12">
                <div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
                <h1> @yield('code')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <p class="lead"> @yield('message')</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <p class="lead"><a href="{{ url()->previous() }}" class="button"> Back</a>  </p>
            </div>
        </div>
    </div>
    </body>
</html>
