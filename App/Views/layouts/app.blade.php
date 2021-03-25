{{--Sleek Template--}}
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    <!-- FAVICON -->
    <link href="/images/favicon.ico" sizes="16x16" rel="icon">

    <!-- FONTS and ICONS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500"
          rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.0.39/css/materialdesignicons.css" integrity="sha256-hpIKfjdsbMecd6qUvr+RWnU0WVt2gwW2TgGrf7jPkLc=" crossorigin="anonymous" />
    {{--<link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />--}}

    @yield('page-css')

    <!-- PLUGINS CSS STYLE -->
    <link href="/assets/plugins/nprogress/nprogress.css" rel="stylesheet" />
    <!-- No Extra plugin used -->
    <link href="/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <link href="/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" />


    <!-- SLEEK STYLE FILE -->
    <link id="sleek-css" rel="stylesheet" href="/assets/css/sleek.css" />

    @yield('app-css')

    <script src="/assets/plugins/nprogress/nprogress.js"></script>
</head>
<!--Start of Tawk.to Script-->

{{--<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5e84e01c35bcbb0c9aacbcaa/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>--}}

<!--End of Tawk.to Script-->
<body  class="header-fixed sidebar-fixed-offcanvas sidebar-collapse sidebar-dark header-light" id="body">
{{--<body  class="header-fixed sidebar-fixed sidebar-minified sidebar-dark header-light" id="body">--}}
<script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
</script>
<div class="mobile-sticky-body-overlay"></div>
<div id="toaster"></div>
<div class="wrapper">
    <!-- Referral Link -->
@include('layouts.partials.referral')

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')
    <!-- Main -->
    <div class="page-wrapper">
        <!-- Header -->
        @include('layouts.partials.navbar')
        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
            @yield('layouts.partials.right-sidebar-2')
        </div>
        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>
</div>

    <!-- JavaScript -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>

    <script src="/assets/plugins/slimscrollbar/jquery.slimscroll.min.js"></script>
{{--    <script src="/assets/plugins/jekyll-search.min.js"></script>--}}

    <!--Page Specific JavaScript -->
    @yield('page-script')
    <script src="/assets/plugins/charts/Chart.min.js"></script>
    <script src="/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="/assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
    <script src="/assets/plugins/daterangepicker/moment.min.js"></script>
    <script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>



    <script src="/assets/js/sleek.bundle.js"></script>
    {{--    <script src="/assets/js/sleek.js"></script>--}}

    <!-- Optional JavaScript -->
    @yield('app-script')

    @include('request.load_notification')

{{--    @include('scripts.close_flash_message')--}}
{{--    @include('scripts.load_notification')--}}

    {{--@if(isset($_SESSION['logged-in']))
        @include('scripts.load_connected_profiles')
    @endif--}}

</body>
</html>