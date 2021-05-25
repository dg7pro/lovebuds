@extends('layouts.app')

@section('page_css')
    <style>
        .others {color:black}
    </style>
@endsection

@section('content')

    <!-- registration section -->
    <section class="main">
        <h1 class="large text-heading">
            Create Profile
        </h1>
        <p class="lead"><i class="fas fa-user"> </i> Every field is Important</p>

        <form class="form" action="{{'/account/save-profile'}}" method="POST" autocomplete="off" >

            <div class="flex-row form-group">
                <div class="flex-field-2">
                    {{--<label for="fname">First name:</label>--}}
                    <input type="text" id="fname" name="first_name" placeholder="First name">
                    {{--<small class="form-text">
                        Firstname
                    </small>--}}
                </div>
                <div class="flex-field-2">
                    {{--<label for="lname">First name:</label>--}}
                    <input type="text" id="lname" name="last_name" placeholder="Last name">
                    {{--<small class="form-text">
                        Lastname/Surname
                    </small>--}}
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-3">
                    <select id="day" name="day">
                        <option value="" selected>Birthday</option>
                        @foreach($dates as $date)
                            <option value="{{$date}}" {{isset($_GET['dy']) && $_GET['dy']==$date ?'selected':''}} class="others">{{$date}}</option>
                        @endforeach
                    </select>
                    <small class="form-text">Your Date of Birth</small>
                </div>
                <div class="flex-field-3">
                    <select id="month" name="month">
                        <option value="" selected>Month</option>
                        @foreach($months as $mo)
                            <option value="{{$mo['value']}}" {{isset($_GET['mo']) && $mo['value']==$_GET['mo'] ? 'selected':''}}>{{$mo['text']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-3">
                    {{--<label for="occupation">Year:</label>--}}
                    <select id="year" name="year">
                        <option value="" selected>Year</option>
                        @foreach($years as $year)
                            <option value="{{$year}}" {{isset($_GET['yr']) && $_GET['yr']==$year?'selected':''}} class="others">{{$year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-2">
                    {{--<label for="religion">Religion:</label>--}}
                    <select id="religion" name="religion_id">
                        <option value="" selected>Select Religion</option>
                        @foreach($religions as $religion)
                            <option value="{{$religion->id}}" {{isset($_GET['rl']) && $_GET['rl']==$religion->id ?'selected':''}} class="others">{{$religion->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-2">
                    {{--<label for="community">Community:</label>--}}
                    <select id="community" name="community_id">
                        <option value="" selected>Select Community</option>
                        @foreach($languages as $lang)
                            <option value="{{$lang->value}}" {{ isset( $_GET['co']) && $_GET['co']==$lang->value ?'selected':''}} class="others">{{$lang->text}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-2">
                    {{--<label for="education">Education:</label>--}}
                    <select id="education" name="education_id">
                        <option value="" selected>Education</option>
                        @foreach($educations as $education)
                            <optgroup label="{{$education['stream']}}">
                                @foreach($education['edu'] as $edu)
                                    <option value="{{$edu['id']}}" {{isset($_GET['ed']) && $_GET['ed']==$edu['id'] ?'selected':''}} class="others">{{$edu['name']}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-2">
                    {{--<label for="occupation">Occupation:</label>--}}
                    <select id="occupation" name="occupation_id">
                        <option value="" selected>Occupation</option>
                        @foreach($occupations as $occupation)
                            <optgroup label="{{$occupation['category']}}">
                                @foreach($occupation['occ'] as $occ)
                                    <option value="{{$occ['id']}}" {{isset($_GET['oc']) && $_GET['oc']==$occ['id'] ?'selected':''}} class="others">{{$occ['name']}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-3">
                    {{--<label for="education">Marital Status:</label>--}}
                    <select id="mStatus" name="marital_id">
                        <option value="" selected>Select</option>
                        @foreach($maritals as $marital)
                            <option value="{{$marital->id}}" {{isset($_GET['ms']) && $_GET['ms']==$marital->id ?'selected':''}} class="others">{{$marital->status}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-3">
                    {{--<label for="occupation">Manglik Status:</label>--}}
                    <select id="manglik" name="manglik_id" >
                        <option value="" selected>Select...</option>
                        @foreach($mangliks as $manglik)
                            <option value="{{$manglik->id}}" {{isset($_GET['mn']) && $_GET['mn']==$manglik->id ?'selected':''}} class="others">{{$manglik->status}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-3">
                    {{--<label for="occupation">Height:</label>--}}
                    <select id="height" name="height_id">
                        <option value="" selected>Select...</option>
                        @foreach($heights as $ht)
                            <option value="{{$ht->id}}" {{isset($_GET['ht']) && $_GET['ht']==$ht->id ?'selected':''}} class="others">{{$ht->feet}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <input type="submit" value="Save Profile" name="create-profile-submit" class="btn btn-green may-2">

        </form>
    </section>
    <!-- registration ends -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#day').css('color','gray');
            $('#day').change(function() {
                var current = $('#day').val();
                if (current != 'null') {
                    $('#day').css('color','black');
                } else {
                    $('#day').css('color','gray');
                }
            });

            $('#month').css('color','gray');
            $('#month').change(function() {
                var current = $('#month').val();
                if (current != 'null') {
                    $('#month').css('color','black');
                } else {
                    $('#month').css('color','gray');
                }
            });

            $('#year').css('color','gray');
            $('#year').change(function() {
                var current = $('#year').val();
                if (current != 'null') {
                    $('#year').css('color','black');
                } else {
                    $('#year').css('color','gray');
                }
            });

            $('#religion').css('color','gray');
            $('#religion').change(function() {
                var current = $('#religion').val();
                if (current != 'null') {
                    $('#religion').css('color','black');
                } else {
                    $('#religion').css('color','gray');
                }
            });

            $('#community').css('color','gray');
            $('#community').change(function() {
                var current = $('#community').val();
                if (current != 'null') {
                    $('#community').css('color','black');
                } else {
                    $('#community').css('color','gray');
                }
            });

            $('#education').css('color','gray');
            $('#education').change(function() {
                var current = $('#education').val();
                if (current != 'null') {
                    $('#education').css('color','black');
                } else {
                    $('#education').css('color','gray');
                }
            });

            $('#occupation').css('color','gray');
            $('#occupation').change(function() {
                var current = $('#occupation').val();
                if (current != 'null') {
                    $('#occupation').css('color','black');
                } else {
                    $('#occupation').css('color','gray');
                }
            });

            $('#mStatus').css('color','gray');
            $('#mStatus').change(function() {
                var current = $('#mStatus').val();
                if (current != 'null') {
                    $('#mStatus').css('color','black');
                } else {
                    $('#mStatus').css('color','gray');
                }
            });

            $('#manglik').css('color','gray');
            $('#manglik').change(function() {
                var current = $('#manglik').val();
                if (current != 'null') {
                    $('#manglik').css('color','black');
                } else {
                    $('#manglik').css('color','gray');
                }
            });

            $('#height').css('color','gray');
            $('#height').change(function() {
                var current = $('#height').val();
                if (current != 'null') {
                    $('#height').css('color','black');
                } else {
                    $('#height').css('color','gray');
                }
            });
        });
    </script>

@endsection