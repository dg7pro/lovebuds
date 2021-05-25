<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JU Matrimony Service</title>

    <!-- bootstrap css file -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- font awesome icons -->
    <link rel="stylesheet" href="/css/all.min.css">

    <!-- toastr css file -->
    <link href="/css/toastr.min.css" rel="stylesheet"/>

    <!-- custom css file -->
    <link rel="stylesheet" href="/css/style.css">

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

<!-- bootstrap js file -->
<script src="/js/bootstrap.min.js"></script>

@yield('js')

</body>
</html>