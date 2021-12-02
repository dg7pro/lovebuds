@extends('layouts.app')

@section('page_css')
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            text-align: center;
            /*padding: 40px 0;*/
            background: #EBF0F5;
        }
        .order_status {
            color: #b20404;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        .order_msg {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size:20px;
            margin: 0;
        }
        .order_icon {
            //color: #b20404;
            font-size: 100px;
            line-height: 200px;
            margin-left:-15px;
        }
        .order_card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }

    </style>

@endsection

@section('content')

    <!-- login section -->
    <section class="main">

        <div class="order_card">
            <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                {{--<i class="checkmark order_icon">✓</i>--}}
                <i class="order_icon text-danger">&#x2716</i>
            </div>
            <h1 class="order_status text-danger">Failed</h1>
            {{--<p class="order_msg">We received your purchase request;<br/> we'll be in touch shortly!</p>--}}
            <p class="order_msg">Transaction of INR {{$amount}} <br/>vide order id: {{$order}}<br/> failed due to: </p>
            <span>
                {{$reason}}
                <a class="btn btn-blue mt-2" role="button" href="{{'/account/dashboard'}}">My Dashboard</a></span>
            </span>

        </div>

    </section>
    <!-- login ends -->

@endsection

@section('js')




@endsection