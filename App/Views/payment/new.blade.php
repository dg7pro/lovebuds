@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="content">							<div class="row">

            <div class="col-md-6 offset-md-3">
                @include('layouts.partials.alert')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card card-default">
                    <div class="card-header justify-content-center">
                        <h2 class="text-info" >One Time KYC Fees</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row justify-content-center" style="font-size: 3rem">
                            <i class="mdi mdi-currency-inr"></i> 200
                        </div>
                        <div class="mt-3 mb-4 row justify-content-center">
                            <h5 class="text-muted text-center">On Occasion of Christmas & New Year's Eve<br>
                                <span class="text-info">Offer valid till 5th Jan 2020</span>
                            </h5>
                        </div>

                        <form action="{{'/Payment/redirect-payment'}}" method="POST">
                            <div class="form-row justify-content-center">

                                <input type="text" class="form-control" id="ORDER_ID" tabindex="1" maxlength="20" size="20"
                                       name="ORDER_ID" autocomplete="off"
                                       value="{{"ORDS" . mt_rand() . $authUser->pid }}" hidden>
                                <input type="text" class="form-control" id="CUST_ID" tabindex="1" maxlength="20" size="20"
                                       name="CUST_ID" autocomplete="off"
                                       value="{{$authUser->pid}}" hidden>
                                <input type="text" class="form-control" id="INDUSTRY_TYPE_ID" tabindex="1" maxlength="20" size="20"
                                       name="INDUSTRY_TYPE_ID" autocomplete="off"
                                       value="Retail" hidden>
                                <input type="text" class="form-control" id="CHANNEL_ID" tabindex="1" maxlength="20" size="20"
                                       name="CHANNEL_ID" autocomplete="off"
                                       value="WEB" hidden>


                                <div class="col-md-10 mt-3">
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-currency-inr"></i>
													</span>
                                        </div>
                                        <input type="text" class="form-control" id="TXN_AMOUNT" name="TXN_AMOUNT" placeholder="200 INR" value="{{$amount}}" style="height: 3.32rem" readonly autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-10 mb-3">
                                    <button class="btn btn-info btn-lg btn-block mt-3" name="create-account-submit" type="submit">{{'Pay Now'}}</button>
                                </div>

                                <div class="col-md-10 mb-3">
                                    <dl class="row">
                                        <dt class="col-sm-1"></dt>
                                        <dt class="col-sm-2">Step1:</dt>
                                        <dd class="col-sm-9">Pay one time KYC fees of Rs. 200 INR</dd>
                                        <dt class="col-sm-1"></dt>
                                        <dt class="col-sm-2">Step2:</dt>
                                        <dd class="col-sm-9">Send snap of Aadhar, PAN, DL etc</dd>
                                    </dl>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



