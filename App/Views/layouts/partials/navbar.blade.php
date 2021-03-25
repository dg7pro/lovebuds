<!--
====================================
——— HEADER
=====================================
-->
<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
        <!-- Sidebar toggle button -->
        <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
        </button>
        <!-- search form -->
        <div class="search-form d-none d-lg-inline-block">
            <div class="input-group">
                <button type="button" name="search" id="search-btn" class="btn btn-flat">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <input type="text" name="query" id="search-input" class="form-control" placeholder=""
                       autofocus autocomplete="off" />
            </div>
            <div id="search-results-container">
                <ul id="search-results"></ul>
            </div>
        </div>

        <div class="navbar-right ">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <button class="dropdown-toggle" data-toggle="dropdown">
                        <i class="mdi mdi-bell-outline"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-right" id="notify">
                        <li class="dropdown-header">Latest notifications</li>
                        @if($authUser)
                            <li>
                                <a href="#">
                                    <i class="mdi mdi-information-outline"></i>No new notification..
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="#">
                                    <i class="mdi mdi-information-outline"></i>Please Login to see..
                                </a>
                            </li>
                        @endif
                        <li class="dropdown-footer">
                            <a class="text-center" href="{{'/account/my-notification'}}"> View All </a>
                        </li>
                    </ul>
                </li>

                @if($authUser)

                <!-- User Account -->
                <li class="dropdown user-menu">
                    <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <img src="{{'/uploaded/tmb/tn_'.$authUser->avatar}}" class="user-image" alt="User Image" />
                        <span class="d-none d-lg-inline-block">{{$displayName}}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <!-- User image -->
                        <li class="dropdown-header">
                            <img src="{{'/uploaded/tmb/tn_'.$authUser->avatar}}" class="img-circle" alt="User Image" />
                            <div class="d-inline-block">
                                {{$displayName}} <small class="pt-1">{{$authUser->email}}</small>
                            </div>
                        </li>
                        <li>
                            <a href="{{'/account/my-profile'}}">
                                <i class="mdi mdi-account"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{'/notification/index'}}"><i class="mdi mdi-bell"></i> Notifications</a>
                        </li>

                        <li>
                            <a href="{{'/account/info'}}"> <i class="mdi mdi-settings"></i> Account Settings </a>
                        </li>

                        <li>
                            <a href="{{'/account/my-kyc'}}"> <i class="mdi mdi-file-document"></i> Verify Account </a>
                        </li>

                        <li>
                            <a href="{{'/payment/new'}}"> <i class="mdi mdi-currency-inr"></i> Become Paid </a>
                        </li>

                        @if($authUser->is_admin)
                            <li>
                                <a href="{{'/admin'}}"> <i class="mdi mdi-currency-inr"></i> Administrator </a>
                            </li>
                        @endif

                        <li class="dropdown-footer">
                            <a href="{{'/account/logout'}}" > <i class="mdi mdi-logout"></i> Log Out </a>
                        </li>


                    </ul>
                </li>
                @else
                    <a role="button" class="mb-1 btn btn-square btn-outline-primary ml-3 mr-3" href="{{'/login/index'}}">
                        <i class=" mdi mdi-power mr-1"></i> Login</a>
                @endif
            </ul>
        </div>
    </nav>
</header>