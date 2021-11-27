@extends('layouts.app')

@section('page_css')


@endsection

@section('content')

    <!-- login section -->
    <section class="main">


            <div class="card mx-auto col-md-5 mt-3 p-0"> <img class='mx-auto offer-img' src="{{'/img/'.$offer->image}}" />
                <div class="card-title offer-title d-flex px-4">
                    {{--<p class="item text-muted">December<label class="offer-ss">21</label> Offer</p>--}}
                    <p class="item text-muted">{{$offer->offer_name}}</p>
                    <p>{{$offer->discount_rate.'%'}} off</p>
                </div>
                <div class="card-body offer-body">
                    <p class="text-muted">Features:</p>
                    <!-- <span class="text-muted">Following Benifits you will get</span> -->
                    <div class="mb-5">
                        <div class="text-muted"><span class="fas fa-arrow-right mb-2 pr-2"></span>View 500 contact numbers</div>
                        <!-- <div class="text-muted"><span class="fas fa-arrow-right mb-2 pr-2"></span>All paid benfits till you get married</div> -->
                        <div class="text-muted"><span class="fas fa-arrow-right mb-2 pr-2"></span>Service till you get married</div>
                        <div class="text-muted"><span class="fas fa-arrow-right mb-2 pr-2"></span>Receive Alerts on Mobile</div>
                    </div>

                    <p class="text-muted">Your Payment details</p>
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-1 text-muted">
                            <div>Premium Membership:</div>
                            <!-- <p><span class="fas fa-dollar-sign"></span>19.00</p> -->
                            <div>Rs {{$offer->base_price}}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-1 text-muted">
                            {{--<div>Discount 92% :</div>--}}
                            <div>Discount {{$offer->discount_rate.'%'}} :</div>
                            {{--<div>- Rs 2300</div>--}}
                            <div>- Rs {!! $offer->base_price/100*$offer->discount_rate !!}</div>

                        </div>
                        <div class="text-muted"><hr></div>
                        <div class="d-flex align-items-center justify-content-between mb-1 text-muted">
                            <div>Amount Payable:</div>
                            <div>Rs {{ $offer->discount_price }}</div>
                            {{--<div>Rs {{ $offer->base_price - $offer->base_price/100*$offer->discount_rate}}</div>--}}
                        </div>
                    </div>

                </div>
                <div class="footer offer-footer text-center p-0">
                    <form action="{{'/payment/redirect-payment'}}" method="POST" id="jum_order_form">

                        <input type="text" id="ORDER_ID" maxlength="20" size="20"
                               name="ORDER_ID" autocomplete="off"
                               value="{{"ORDS" . mt_rand() . $authUser->id}}" hidden>

                        <input type="text" id="CUST_ID" maxlength="20" size="20"
                               name="CUST_ID" autocomplete="off"
                               value="{{$authUser->pid}}" hidden>

                        <input type="text" id="INDUSTRY_TYPE_ID" maxlength="20" size="20"
                               name="INDUSTRY_TYPE_ID" autocomplete="off"
                               value="Retail" hidden>

                        <input type="text" id="CHANNEL_ID" maxlength="20" size="20"
                               name="CHANNEL_ID" autocomplete="off"
                               value="WEB" hidden>

                        <!-- Course/Group related -->
                        <input type="text" id="OFFER_ID"
                               name="OFFER_ID" autocomplete="off"
                               value="{{$offer->id}}" hidden >

                        <input type="text" id="OFFER_CODE"
                               name="OFFER_CODE" autocomplete="off"
                               value="{{$offer->offer_code}}" hidden >

                        <!-- Course/Group related -->
                        <input type="text" id="BASE_PRICE"
                               name="BASE_PRICE" autocomplete="off"
                               value="{{$offer->base_price}}" hidden >

                        <input type="text" id="DISCOUNT"
                               name="DISCOUNT" autocomplete="off"
                               value="{{$offer->discount_rate}}" hidden >

                        <input type="text" id="PAYABLE_AMOUNT"
                               name="PAYABLE_AMOUNT" autocomplete="off"
                               value="{{$offer->discount_price}}" hidden >

                        <input type="text" id="TXN_AMOUNT"
                               name="TXN_AMOUNT" autocomplete="off"
                               value="{{$offer->discount_price}}" hidden >

                        {{--<button type="submit" class="btn btn-lg btn-block btn-dark">Purchase</button>--}}

                        <div class="col-lg-12 col-12 p-0">
                            <p class="order" onclick="submitOrderForm()">Pay 200</p>
                        </div>

                    </form>
                </div>
            </div>


    </section>
    <!-- login ends -->

@endsection

@section('js')
    <script>
        function submitOrderForm(){

            document.getElementById("jum_order_form").submit();
        }
    </script>



@endsection