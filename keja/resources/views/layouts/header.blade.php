<head>

    <!-- metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Digital Marketing Kenya Rental Management system"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="baseuri" content="{{ url('/') }}">
    <!-- title  -->
    <title> @yield('title','Franro Holdings | Property Management') </title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('img/logos/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logos/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/logos/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/logos/apple-touch-icon-114x114.png') }}">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- toastr plugin -->
    <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('extra_css')
    @yield('css')

    <style>
        .btn .btn-outline-primary {
            background: green;
        }

        .btn .btn-outline-success {
            background: green;
        }

        .btn .btn-outline-warning {
            background: orange;
        }

        .btn .btn-outline-danger {
            background: red;
        }


    </style>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

     <script>
      function generatePDF() {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById("printingDiv");
        // Choose the element and save the PDF for our user.
        // html2pdf()
        //   .from(element)
        //   .save();

        // const title = document.title = "Receipt For Payment";
// const title = document.write('<title>Receipt</title>');
        


          html2pdf()
    .set({ html2canvas: { scale: 4 } })
    .from(element)
    // .set(title)
    
    .save();
      }

      //  #2

            function generatePDF2() {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById("printingDiv");
        // Choose the element and save the PDF for our user.
        // html2pdf()
        //   .from(element)
        //   .save();

        // const title = document.title = "Receipt For Payment";
// const title = document.write('<title>Receipt</title>');
        


          html2pdf()
    .set({ html2canvas: { scale: 4 } })
    .from(element)
    // .set(title)
    
    .save();
      }


      // #3

                  function generatePDF3() {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById("printingDiv");
        // Choose the element and save the PDF for our user.
        // html2pdf()
        //   .from(element)
        //   .save();

        // const title = document.title = "Receipt For Payment";
// const title = document.write('<title>Receipt</title>');
        


          html2pdf()
    .set({ html2canvas: { scale: 4 } })
    .from(element)
    // .set(title)
    
    .save();
      }
    </script>

</head>


