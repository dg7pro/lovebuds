@extends('layouts.app')

@section('content')

    <!-- login section -->
    <section class="main">

        @include('layouts.partials.alert')


        <h1 class="large text-green">
            Disclaimer
        </h1>
        <p class="lead"><i class="fas fa-user text-blue"> </i> All Members are bound by following disclaimer</p>

        <p class="mb-2"> The terms "We" / "Us" / "Our"/”Company” individually and collectively refer
            to JU Matrimony Service and the terms "Visitor” ”Member” refer to the users of this website.</p>

        <h4 class="mt-3 mb-2">DISCLAIMER OF CONSEQUENTIAL DAMAGES</h4>
        <p class="mb-2">In no event shall Company or any parties, organizations or entities associated with
            the corporate brand name us or otherwise, mentioned at this Website be liable for
            any damages whatsoever (including, without limitations, incidental and consequential
            damages, lost profits, or damage to computer hardware or loss of data information or
            business interruption) resulting from the use or inability to use the Website and the
            Website material, whether based on warranty, contract, tort, or any other legal theory,
            and whether or not, such organization or entities were advised of the possibility of
            such damages.
        </p>


    </section>
    <!-- login ends -->

@endsection