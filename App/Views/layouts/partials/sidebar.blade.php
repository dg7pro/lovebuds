<!--
====================================
——— LEFT SIDEBAR WITH FOOTER
=====================================
-->
<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="{{'/'}}">
                <svg
                        class="brand-icon"
                        xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="xMidYMid"
                        width="30"
                        height="33"
                        viewBox="0 0 30 33"
                >
                    <g fill="none" fill-rule="evenodd">
                        <path
                                class="logo-fill-blue"
                                fill="#7DBCFF"
                                d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
                        />
                        <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                    </g>
                </svg>
                <span class="brand-name">JU Matrimony</span>
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-scrollbar">

            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">

                <li  class="has-sub" >
                    <a class="sidenav-item-link" href="{{'/home/index'}}">
                        <i class="mdi mdi-home-outline"></i>
                        <span class="nav-text">Home</span>
                    </a>
                </li>

                <li  class="has-sub" >
                    <a class="sidenav-item-link" href="{{'/account/welcome'}}"
                       aria-expanded="false" aria-controls="dashboard">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li  class="has-sub" >
                    <a class="sidenav-item-link" href="{{'/account/stats'}}">
                        <i class="mdi mdi-chart-pie"></i>
                        <span class="nav-text">All Stats</span>
                    </a>
                </li>

                {{--My Profile--}}
                <li  class="has-sub" >
                    <a class="sidenav-item-link" href="{{'/account/my-profile'}}">
                        <i class="mdi mdi-image-filter-none"></i>
                        <span class="nav-text">My Profile</span>
                    </a>
                </li>

                {{--Advance Search Page--}}
                <li  class="has-sub" >
                    <a class="sidenav-item-link" href="{{'/search/advance'}}">
                        <i class="mdi mdi-magnify"></i>
                        <span class="nav-text">Search</span>
                    </a>
                </li>

                {{--Terms & Conditions--}}
                <li  class="has-sub" >
                    <a class="sidenav-item-link" href="{{'/company/info'}}">
                        <i class="mdi mdi-google-spreadsheet"></i>
                        <span class="nav-text">T&C</span>
                    </a>
                </li>

                {{--Login Page--}}
                @if($authUser)
                    <li  class="has-sub" >
                        <a class="sidenav-item-link" href="{{'/account/logout'}}">
                            <i class="mdi mdi-login"></i>
                            <span class="nav-text">Logout</span>
                        </a>
                    </li>
                @else
                    <li  class="has-sub" >
                    <a class="sidenav-item-link" href="{{'/login/index'}}">
                        <i class="mdi mdi-login"></i>
                        <span class="nav-text">Login</span>
                    </a>
                </li>
                @endif
            </ul>

        </div>

        <hr class="separator" />

        {{--<div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <h6 class="text-uppercase">
                    Cpu Uses <span class="float-right">40%</span>
                </h6>
                <div class="progress progress-xs">
                    <div
                            class="progress-bar active"
                            style="width: 40%;"
                            role="progressbar"
                    ></div>
                </div>
                <h6 class="text-uppercase">
                    Memory Uses <span class="float-right">65%</span>
                </h6>
                <div class="progress progress-xs">
                    <div
                            class="progress-bar progress-bar-warning"
                            style="width: 65%;"
                            role="progressbar"
                    ></div>
                </div>
            </div>
        </div>--}}
    </div>
</aside>