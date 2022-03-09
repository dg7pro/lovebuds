<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{$_SESSION['csrf_token']}}">
    <link rel="icon" type="image/svg+xml" href="/img/favicon.svg" />
    <title>JuMatrimony Service</title>

    @yield('page_og')

    <!-- bootstrap css file -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- font awesome icons -->
    <link rel="stylesheet" href="/css/all.min.css">

    <!-- toastr css file -->
    <link href="/css/toastr.min.css" rel="stylesheet"/>

    <!-- custom css file -->
    <link rel="stylesheet" href="/css/jquery-confirm.min.css">

    <!-- material icons css file -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- custom css file -->
    <link rel="stylesheet" href="/css/main.css?version=0222">

    @yield('page_css')
</head>
<body>

<!-- header -->
@include('layouts.partials.header')

<!-- body -->
@yield('content')

<!-- footer -->
@include('layouts.partials.footer')

<!-- jquery js file -->
<script src="/js/jquery.4.5.1.js"></script>

<!-- toastr js-->
<script src="/js/toastr.min.js"></script>

<script src="/js/jquery-confirm.min.js"></script>

<script>
    // Display an info toast with no title
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- bootstrap js file -->
<script src="/js/bootstrap.min.js"></script>

<script>
    // Get the container element
    var btnContainer = document.getElementById("bottom_navbar");

    // Get all buttons with class="btn" inside the container
    var btns = btnContainer.getElementsByClassName("bnav__link");

    // Loop through the buttons and add the active class to the current/clicked button
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("bnav__link--active");
            current[0].className = current[0].className.replace(" bnav__link--active", "");
            this.className += " bnav__link--active";
        });
    }
</script>

@yield('js')

</body>
</html>