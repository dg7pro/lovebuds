@extends('layouts.app')

@section('title', 'Ju-Matrimony')

@section('content')

    <div class="content">							<div class="row">
            <div class="col-md-6 offset-md-3">
                @include('layouts.partials.alert')
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card card-default">
                    <div class="card-header justify-content-center card-header-border-bottom">
                        <h3>Create Profile</h3>
                        <span class="mb-3 ml-2 badge badge-info">Just 5 min</span>
                    </div>
                    <div class="card-body">
                        <form action="{{'/account/save-profile'}}" method="POST" autocomplete="off" >
                            <div class="form-row">

                                {{--                                <div class="col-8 mb-3">--}}
                                {{--                                    <label for="cFor">Creating profile for:</label>--}}
                                {{--                                    <select class="form-control" id="cFor" name="cFor">--}}
                                {{--                                        <option selected>Select...</option>--}}
                                {{--                                        @foreach($fors as $for)--}}
                                {{--                                            <option value="{{$for->id}}">{{$for->name}}</option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}

                                {{--                                <div class="col-4 mb-3">--}}
                                {{--                                    <label for="gender">Gender</label>--}}
                                {{--                                    <select class="form-control" id="gender" name="gender">--}}
                                {{--                                        <option selected>Select...</option>--}}
                                {{--                                        <option value="1">Male</option>--}}
                                {{--                                        <option value="2">Female</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}

                                <div class="col-6 mb-3">
                                    <label for="firstName" data-toggle="popover" data-trigger="hover" data-placement="top"
                                           data-content="First name of the person">First Name:</label>
                                    {{--<span class="font-size-17 ml-1"><i class="mdi mdi-help-circle-outline"></i></span>--}}
                                    <input type="text" class="form-control" id="firstName" name="first_name"
                                           value="{{ isset($_GET['fn']) ? $_GET['fn'] : '' }}" placeholder="First Name" >
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="lastName" data-toggle="popover" data-trigger="hover" data-placement="top"
                                           data-content="Last name of the person">Last Name:</label>
                                    {{--<span class="font-size-17 ml-1"><i class="mdi mdi-help-circle-outline"></i></span>--}}
                                    <input type="text" class="form-control" id="lastName" name="last_name"
                                           value="{{ isset($_GET['ln']) ? $_GET['ln'] : '' }}" placeholder="Last Name" >
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="dob">Date of Birth:</label>
                                    <div class="row">
                                        <div class="col-3 mb-3 pr-0">
                                            <select class="form-control" id="day" name="day" >
                                                <option value="" selected>Day</option>
                                                @foreach($dates as $date)
                                                    <option value="{{$date}}" {{isset($_GET['dy']) && $_GET['dy']==$date ?'selected':''}}>{{$date}}</option>
                                                    {{--<option value="{{$date}}">{{(strlen($date)==1)?'0'.$date:$date}}</option>--}}
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-5 mb-3 pr-0">
                                            <select class="form-control" id="month" name="month" >
                                                <option value="" selected>Month</option>
                                                @foreach($months as $mo)
                                                    <option value="{{$mo['value']}}" {{isset($_GET['mo']) && $mo['value']==$_GET['mo'] ? 'selected':''}}>{{$mo['text']}}</option>
                                                @endforeach

                                                {{--<option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>--}}
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <select class="form-control" id="year" name="year" >
                                                <option value="" selected>Year</option>
                                                @foreach($years as $year)
                                                    <option value="{{$year}}" {{isset($_GET['yr']) && $_GET['yr']==$year?'selected':''}}>{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="religion">Religion:</label>
                                    <select class="form-control" id="religion" name="religion_id" >
                                        <option value="" selected>Select...</option>
                                        @foreach($religions as $religion)
                                            <option value="{{$religion->id}}" {{isset($_GET['rl']) && $_GET['rl']==$religion->id ?'selected':''}}>{{$religion->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="community">Community:</label>
                                    <select class="form-control" id="community" name="community_id" >
                                        <option value="" selected>Select...</option>
                                        @foreach($languages as $lang)
                                            <option value="{{$lang->value}}" {{ isset( $_GET['co']) && $_GET['co']==$lang->value ?'selected':''}}>{{$lang->text}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="education">Education:</label>
                                    <select class="form-control" id="education" name="education_id" >
                                        <option value="" selected>Select...</option>
                                        @foreach($educations as $education)
                                            <optgroup label="{{$education['stream']}}">
                                                @foreach($education['edu'] as $edu)
                                                    <option value="{{$edu['id']}}" {{isset($_GET['ed']) && $_GET['ed']==$edu['id'] ?'selected':''}}>{{$edu['name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                        {{--@foreach($educations as $education)
                                            <option value="{{$education->id}}" {{isset($_GET['ed']) && $_GET['ed']==$education->id ?'selected':''}}>{{$education['name']}}</option>
                                        @endforeach--}}
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="occupation">Occupation:</label>
                                    <select class="form-control" id="occupation" name="occupation_id" >
                                        <option value="" selected>Select...</option>
                                        @foreach($occupations as $occupation)
                                            <optgroup label="{{$occupation['category']}}">
                                                @foreach($occupation['occ'] as $occ)
                                                    <option value="{{$occ['id']}}" {{isset($_GET['oc']) && $_GET['oc']==$occ['id'] ?'selected':''}}>{{$occ['name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                        {{--@foreach($occupations as $occupation)
                                            <option value="{{$occupation->id}}" {{isset($_GET['oc']) && $_GET['oc']==$occupation->id ?'selected':''}}>{{$occupation['name']}}</option>
                                        @endforeach--}}
                                    </select>
                                </div>

                                <div class="col-4 mb-3">
                                    <label for="mStatus">Marital Status:</label>
                                    <select class="form-control" id="mStatus" name="marital_id" >
                                        <option value="" selected>Select...</option>
                                        @foreach($maritals as $marital)
                                            <option value="{{$marital->id}}" {{isset($_GET['ms']) && $_GET['ms']==$marital->id ?'selected':''}}>{{$marital->status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="manglik">Astro:</label>
                                    <select class="form-control" id="manglik" name="manglik_id" >
                                        <option value="" selected>Select...</option>
                                        @foreach($mangliks as $manglik)
                                            <option value="{{$manglik->id}}" {{isset($_GET['mn']) && $_GET['mn']==$manglik->id ?'selected':''}}>{{$manglik->status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="height">Height:</label>
                                    <select class="form-control" id="height" name="height_id" >
                                        <option value="" selected>Select...</option>
                                        @foreach($heights as $ht)
                                            <option value="{{$ht->id}}" {{isset($_GET['ht']) && $_GET['ht']==$ht->id ?'selected':''}}>{{$ht->feet}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button class="btn btn-block btn-danger mt-5 " name="create-profile-submit" type="submit">{{'Create Profile'}}</button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('app-script')
    {{--<script>
        $(document).ready(function(){

        });
    </script>--}}
{{--    @include('scripts.load_notification')--}}

@endsection



