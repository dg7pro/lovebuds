@extends('layouts.app')

@section('content')

    <!-- login section -->
    <section class="main">

        @include('layouts.partials.alert')


        <h1 class="large text-green">
            Refund Policy
        </h1>
        <p class="lead"><i class="fas fa-user text-blue"> </i> All Members are bound by following refund policy</p>



        <p class="mb-2">Our focus is complete customer satisfaction. In the event, if you are displeased with our
            matrimonial services, we will refund  you back the money, provided the reasons are genuine.
            In case of dissatisfaction from our service, members have the liberty to cancel his/her membership
            only within 5 days from date of purchase and request a refund from us. Our Policy for the cancellation
            and refund will be as follows:
        </p>

        <h4 class="mt-3 mb-2">Cancellation Policy</h4>
        <p class="mb-2">
            <i class="fas fa-angle-right"></i>
            For Cancellations please message us, on our whatsapp helpline no. +91 9335683398
        </p>
        <p class="mb-2">
            <i class="fas fa-angle-right"></i>
            Cancellation of order and Refund request should be made within 5 days from the date of purchase
        </p>
        <p class="mb-2">
            <i class="fas fa-angle-right"></i>
            Refund shall not be made if you have already used 10% of total credit contacts added to your account after
            purchase of membership plan. example: If you have already seen 50 contact address, out of total 500 credit contacts
            added to your account on purchase of membership plan - no refund will be made.
        </p>
        <p class="mb-2">
            <i class="fas fa-angle-right"></i>
            Refund will not be made if membership plan has been purchased on huge offer or discounted price, example:
            more than 90% discount on our Premium Plan of INR 2500/-
        </p>
        <p class="mb-2">
            <i class="fas fa-angle-right"></i>
            No Refund will not be made if member has already been using our service for more than 3 months and purchased
            the membership plan after thorough testing of our matrimonial app/web portal
        </p>


        <h4 class="mt-3 mb-2">Refund Policy</h4>
        <p class="mb-2">We will try our best to create the suitable design concepts for our clients.</p>
        <p class="mb-2">In case any client is not completely satisfied with our service we can provide a refund.</p>
        <p class="mb-2">If paid by credit card, refunds will be issued to the original credit card provided
            at the time of purchase and in case of payment gateway name payments refund will be
            made to the same account.</p>



    </section>
    <!-- login ends -->

@endsection