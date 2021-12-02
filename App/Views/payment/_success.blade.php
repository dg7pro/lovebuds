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
            color: #88B04B;
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
            color: #9ABC66;
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
                <i class="order_icon">&#x2714</i>
            </div>
            <h1 class="order_status">Success</h1>
            <p class="order_msg">Transaction of INR {{$amount}} <br/>vide order id: {{$order}}<br/> has been completed successfully. </p>
            <span>Congrats! you are paid member now. Your account has been credited with 500 contacts. <br/>
                <a class="btn btn-green mt-2" role="button" href="{{'/account/dashboard'}}">My Dashboard</a>
            </span>
        </div>

    </section>
    <!-- login ends -->

@endsection

@section('js')




@endsection