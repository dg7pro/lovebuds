@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <section class="main">
        <h3>Password Reset Successfully</h3>
        <p class="lead"><i class="fa fa-bullhorn text-green"> </i> Password Reset Successfully. You can now <a href="{{'/login/index'}}"><b><u>login</u></b></a> to continue</p>


    </section>

@endsection