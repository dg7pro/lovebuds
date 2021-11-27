<!-- footer section start -->
<section class="footer mb-5">
    <div class="copyright_info">
        <div>Join & Unite 2021 © All Rights Reserved</div>

    </div>
    <div class="company_info">
        <div><a href="{{'/company/about-us'}}">About</a> | </div>
        <div><a href="{{'/company/tnc'}}">T & C</a> | </div>
        <div><a href="{{'/company/privacy-policy'}}">Privacy</a> | </div>
        <div><a href="{{'/company/disclaimer'}}">Disclaimer</a> | </div>
        <div><a href="{{'/payment/pricing-plans'}}">Pricing</a>  </div>
    </div>
</section>
<!-- footer section ends -->

<section id="bottom_navbar">
    <nav class="bnav">
        <a href="{{'/account/dashboard'}}" class="bnav__link" title="My Dashboard">
            <i class="material-icons bnav__icon">dashboard</i>
            <span class="bnav__text">Dashboard</span>
        </a>
        @if($authUser)
            <a href="{{'/profile/'.$authUser->pid}}" class="bnav__link bnav__link--active">
                <i class="material-icons bnav__icon">person</i>
                <span class="bnav__text">My Profile</span>
            </a>
        @else
            <a href="#" class="bnav__link bnav__link--active">
                <i class="material-icons bnav__icon">person</i>
                <span class="bnav__text">My Profile</span>
            </a>
        @endif
        <a href="{{'/search/index'}}" class="bnav__link">
            {{--<i class="material-icons bnav__icon">devices</i>--}}
            {{--<i class="material-icons bnav__icon">search</i>--}}
            {{--<i class="material-icons bnav__icon">people_alt</i>--}}
            <i class="material-icons bnav__icon">recent_actors</i>
            <span class="bnav__text">Search</span>
        </a>
        <a href="{{'/account/notifications'}}" class="bnav__link">
            {{--<i class="material-icons bnav__icon">lock</i>--}}
            <span class="material-icons">notifications_active</span>
          <span class="bnav__text">Alerts</span>
        </a>
        <a href="{{'/account/settings'}}" class="bnav__link">
            <i class="material-icons bnav__icon">settings</i>
            <span class="bnav__text">Settings</span>
        </a>
    </nav>
</section>