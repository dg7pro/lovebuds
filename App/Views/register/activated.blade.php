@extends('layouts.app')

@section('content')

    {{--<h2>Your Account is Active now</h2>--}}
    <section class="main">
        <h3>Account Activated</h3>
        <p class="lead"><i class="fas fa-user text-green"> </i> Your account is active now, please <a href="{{'/login/index'}}">login to continue</a></p>
    </section>

@endsection