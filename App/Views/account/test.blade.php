@extends('layouts.app')

@section('page_css')
    <style>
        section.range-slider {
            position: relative;
            width: 100%;
            height: 40px;
            text-align: center;
        }

        section.range-slider input {
            pointer-events: none;
            position: absolute;
            overflow: hidden;
            left: 0;
            top: 15px;
            width: 100%;
            outline: none;
            height: 32px;
            margin: 0;
            padding: 0;
        }

        section.range-slider input::-webkit-slider-thumb {
            pointer-events: all;
            position: relative;
            z-index: 1;
            outline: 0;
        }

        section.range-slider input::-moz-range-thumb {
            pointer-events: all;
            position: relative;
            z-index: 10;
            -moz-appearance: none;
            width: 9px;
        }

        section.range-slider input::-moz-range-track {
            position: relative;
            z-index: -1;
            background-color: rgba(0, 0, 0, 1);
            border: 0;
        }
        section.range-slider input:last-of-type::-moz-range-track {
            -moz-appearance: none;
            background: none transparent;
            border: 0;
        }
        section.range-slider input[type=range]::-moz-focus-outer {
            border: 0;
        }
    </style>

@endsection

@section('content')

    <!-- registration section -->
    <section class="main">
        <h1 class="large text-green">
            Partner Preference
        </h1>
        <p class="lead"><i class="fas fa-user"> </i> Every field is Important</p>

        <form class="form" action="{{'/account/form-result'}}" method="POST" autocomplete="off" >

            <!-- This block can be reused as many times as needed -->
            <section class="range-slider">
                <span class="rangeValues"></span>
                <input name="min_age" value="21" min="18" max="72" step="1" type="range">
                <input name="max_age" value="35" min="18" max="72" step="1" type="range">
            </section>

            <input type="submit" value="Save Profile" name="create-profile-submit" class="btn btn-green may-2">

        </form>
    </section>
    <!-- registration ends -->

@endsection

@section('js')
    <script>
        function getVals(){
            // Get slider values
            var parent = this.parentNode;
            var slides = parent.getElementsByTagName("input");
            var slide1 = parseFloat( slides[0].value );
            var slide2 = parseFloat( slides[1].value );
            // Neither slider will clip the other, so make sure we determine which is larger
            if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }

            var displayElement = parent.getElementsByClassName("rangeValues")[0];
            displayElement.innerHTML = "Age: " + slide1 + " - " + slide2;
        }

        window.onload = function(){
            // Initialize Sliders
            var sliderSections = document.getElementsByClassName("range-slider");
            for( var x = 0; x < sliderSections.length; x++ ){
                var sliders = sliderSections[x].getElementsByTagName("input");
                for( var y = 0; y < sliders.length; y++ ){
                    if( sliders[y].type ==="range" ){
                        sliders[y].oninput = getVals;
                        // Manually trigger event first time to display values
                        sliders[y].oninput();
                    }
                }
            }
        }
    </script>

@endsection