<!-- header starts -->
<header class="header">
    <div class="container">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light">
            <!-- <a class="navbar-brand" href="#">JU Matrimony</a> -->
            {{--<a class="navbar-brand logo-heading" href="{{'/home/index'}}" style="color: #ef1515">JuMatrimony</a>--}}
            <a class="navbar-brand logo-heading" href="{{'/home/index'}}">JuMatrimony</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto text-right">
                    @if($authUser)
                        <li class="nav-item blink">
                            <a class="nav-link" href="{{'/home/index'}}">HOME</a>
                        </li>
                        @if($authUser->is_admin)
                            <li class="nav-item blink">
                                <a class="nav-link" href="{{'/admin/index'}}">ADMIN</a>
                            </li>
                        @endif
                        @if($authUser->is_pro)
                            <li class="nav-item blink">
                                <a class="nav-link" href="{{'/pro/index'}}">PRO</a>
                            </li>
                        @endif
                        <li class="nav-item blink">
                            <a class="nav-link" href="{{'/search/index'}}">SEARCH</a>
                        </li>
                        <li class="nav-item blink">
                            <a class="nav-link" href="{{'/account/dashboard'}}">DASHBOARD</a>
                        </li>
                            <li class="nav-item blink">
                                <a class="nav-link" href="{{'/company/help'}}">HELP</a>
                            </li>
                        <li class="nav-item blink">
                            <a class="nav-link" href="{{'/account/logout'}}">LOGOUT</a>
                        </li>
                    @else
                        <li class="nav-item blink">
                            <a class="nav-link" href="{{'/quick/search'}}">SEARCH</a>
                        </li>
                        <li class="nav-item blink">
                            <a class="nav-link" href="{{'/login/index'}}">LOGIN</a>
                        </li>
                        <li class="nav-item blink">
                            <a class="nav-link" href="{{'/register/index'}}">REGISTER</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
<!-- header ends -->