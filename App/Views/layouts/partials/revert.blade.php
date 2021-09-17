@if($authUser)
    <a href="{{'/account/dashboard'}}" class="btn btn-pink">Goto Dashboard</a>
    <a onclick="goBack()" class="btn btn-orange">Go Back</a>
@else
    <a href="{{'/login/index'}}" class="btn btn-yellow">Session expired! Login please...</a>
@endif