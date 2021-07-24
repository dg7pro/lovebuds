@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <section class="main">
        <h3>Reset token expired</h3>
        <p class="lead"><i class="fa fa-exclamation-triangle text-orange"> </i> Password reset link invalid or expired please
            <b><u><a href="{{'/password/forgot'}}">click here</a></u></b>
            to request another.
        </p>


    </section>
@endsection