@extends('layouts.app')

@section('title', 'Ju-Matrimony')
@section('page-css')
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row justify-content-center">
                    <h2 class="text-muted mb-5">Advance Search</h2>
                </div>
                <div class="card card-default">
                    {{--<div class="card-header card-header-border-bottom">
                        <h2 class="text-muted">Advance Search</h2>
                    </div>--}}
                    <div class="card-body">
                        <form method="post" id="search_form" name="search_form" action="{{'/search/results'}}">

                            <div class="row justify-content-center mt-4 mb-5">
                                <h4>Basic Information:</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_gen">Search For:</label><br>
                                        @if($authUser)
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="srch_gen-1" name="gen" class="custom-control-input"
                                                       {{ ($authUser->gender==2)?'checked':null }}
                                                       value="1" {{$authUser->gender==1?'disabled':''}}>
                                                <label class="custom-control-label" for="srch_gen-1">Groom</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="srch_gen-2" name="gen" class="custom-control-input"
                                                       {{ ($authUser->gender==1)?'checked':null }}
                                                       value="2" {{$authUser->gender==2?'disabled':''}}>
                                                <label class="custom-control-label" for="srch_gen-2">Bride</label>
                                            </div>
                                        @else
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="srch_gen-1" name="gen" class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="srch_gen-1">Groom</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="srch_gen-2" name="gen" class="custom-control-input" checked value="2">
                                                <label class="custom-control-label" for="srch_gen-2">Bride</label>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="srch_age_min">Age From:</label>
                                                <select id="srch_age_min" name="minAge" class="form-control">
                                                    <option selected value=''>Select age</option>
                                                    @foreach($age_rows as $row)
                                                        <option value="{{$row}}" {{--{{($row==$minAge)?'selected':null}}--}}>{{$row}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="srch_age_max">Age To:</label>
                                                <select id="srch_age_max" name="maxAge" class="form-control">
                                                    <option selected value=''>Select age</option>
                                                    @foreach($age_rows as $row)
                                                        <option value="{{$row}}" {{--{{($row==$maxAge)?'selected':null}}--}}>{{$row}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="srch_rel">Religion:</label>
                                        <select multiple id="srch_rel" name="rel[]" class="js-example-basic-multiple form-control" multiple="multiple">
                                            <option selected value=''>Select religion</option>
                                            @foreach($religions as $religion)
                                                <option value="{{$religion->id}}"
                                                        {{--{{ (in_array($religion->id,$rel)) ?'selected':null }}--}}>
                                                    {{$religion->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="srch_language">Language:</label>
                                        <select multiple id="srch_language" name="lan[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select language</option>
                                            @foreach($languages as $language)
                                                <option value="{{$language->value}}" {{--{{ (in_array($language->value,$lan)) ?'selected':null }}--}}>
                                                    {{$language->text}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_photo">Photo:</label><br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_photo-1" name="pho" class="custom-control-input"
                                                   {{--{{ (0==$pho)?'checked':null }}--}}
                                                   value=0>
                                            <label class="custom-control-label" for="srch_photo-1">All Profiles</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_photo-2" name="pho" class="custom-control-input"
                                                   {{--{{ (1==$pho)?'checked':null }}--}}
                                                   value=1>
                                            <label class="custom-control-label" for="srch_photo-2">Profile with Photo only</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="srch_height_min">Heights:</label>
                                                <select id="srch_height_min" name="minHt" class="form-control">
                                                    <option selected value=''>Select height</option>
                                                    @foreach($heights as $height)
                                                        <option value="{{$height->id}}" {{--{{($height->id==$minHt)?'selected':null}}--}}>{{$height->feet}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="srch_height_max">Heights:</label>
                                                <select id="srch_height_max" name="maxHt" class="form-control">
                                                    <option selected value=''>Select height</option>
                                                    @foreach($heights as $height)
                                                        <option value="{{$height->id}}">{{$height->feet}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{--Country--}}
                                    <div class="form-group">
                                        <label for="srch_country">Country:</label>
                                        <select multiple id="srch_country" name="con[]" class="js-example-basic-multiple form-control">
                                            <option value=''>Select country</option>
                                            {{--@foreach($countries as $country)
                                                <option value="{{$country->id}}">
                                                    {{$country->name}}
                                                </option>
                                            @endforeach--}}
                                            @foreach($countries as $country)
                                                <optgroup label="{{$country['alpha']}}">
                                                    @foreach($country['coni'] as $con)
                                                        <option value="{{$con["id"]}}" {{$con['id']==77?'Selected':''}}>{{$con["name"]}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{--Marital Status--}}
                                    <div class="form-group">
                                        <label for="srch_marital">Marital Status:</label>
                                        <select multiple id="srch_marital" name="mar[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select marital</option>
                                            @foreach($maritals as $marital)
                                                <option value="{{$marital->id}}">
                                                    {{$marital->status}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4 mb-5">
                                <h4>Astrology:</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_religion">Manglik Status:</label>
                                        <select multiple id="srch_religion" name="man[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select status</option>
                                            @foreach($mangliks as $manglik)
                                                <option value="{{$manglik->id}}">
                                                    {{$manglik->status}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_horoscope">Having Horoscope:</label><br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_horoscope-1" name="hor" class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="srch_horoscope-1">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_horoscope-2" name="hor" class="custom-control-input" value="0">
                                            <label class="custom-control-label" for="srch_horoscope-2">Doesn't Matter</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4 mb-5">
                                <h4>Education & Career:</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_education">Education:</label>
                                        <select multiple id="srch_education" name="edu[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select education</option>
                                            @foreach($educations as $education)
                                                <optgroup label="{{$education['stream']}}">
                                                    @foreach($education['edu'] as $edu)
                                                        <option value="{{$edu['id']}}">{{$edu['name']}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                            {{--@foreach($educations as $education)
                                                <option value="{{$education->id}}">
                                                    {{$education->name}}
                                                </option>
                                            @endforeach--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_occupation">Occupation:</label>
                                        <select multiple id="srch_occupation" name="ocu[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select occupation</option>
                                            @foreach($occupations as $occupation)
                                                <optgroup label="{{$occupation['category']}}">
                                                    @foreach($occupation['occ'] as $occ)
                                                        <option value="{{$occ['id']}}">{{$occ['name']}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                            {{--@foreach($occupations as $occupation)
                                                <option value="{{$occupation->id}}">
                                                    {{$occupation->name}}
                                                </option>
                                            @endforeach--}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4 mb-5">
                                <h4>Lifestyle:</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="srch_diet">Diet:</label>
                                        <select multiple id="srch_diet" name="die[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select diet</option>
                                            @foreach($diets as $diet)
                                                <option value="{{$diet->id}}">
                                                    {{$diet->type}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="srch_drink">Drink:</label>
                                        <select multiple id="srch_drink" name="dri[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select drink</option>
                                            @foreach($drinks as $drink)
                                                <option value="{{$drink->id}}">
                                                    {{$drink->status}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="srch_smoke">Smoke:</label>
                                        <select multiple id="srch_smoke" name="smo[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select smoke</option>
                                            @foreach($smokes as $smoke)
                                                <option value="{{$smoke->id}}">
                                                    {{$smoke->status}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4 mb-5">
                                <h4>More Options:</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_rsa">Ready to settle abroad?</label><br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_rsa-1" name="rsa" class="custom-control-input" value=1>
                                            <label class="custom-control-label" for="srch_rsa-1">Yes</label>
                                        </div>
                                        {{--Generally not used so commented out--}}
                                        {{--<div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_rsa-2" name="rsa" class="custom-control-input"
                                                   {{(2==$rsa)?'checked':null}}
                                                   value=2>
                                            <label class="custom-control-label" for="srch_rsa-2">No</label>
                                        </div>--}}
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_rsa-3" name="rsa" class="custom-control-input" value=0>
                                            <label class="custom-control-label" for="srch_rsa-3">Doesn't Matter</label>{{--Undecided--}}
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="srch_ch">Challenged:</label>
                                        <select multiple id="srch_ch" name="cha[]" class="js-example-basic-multiple form-control">
                                            <option selected value=''>Select challenged</option>
                                            @foreach($challenges as $ch)
                                                <option value="{{$ch->id}}">
                                                    {{$ch->status}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="srch_hiv">HIV +ive ?</label><br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_hiv-1" name="hiv" class="custom-control-input" value=1>
                                            <label class="custom-control-label" for="srch_hiv-1">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="srch_hiv-2" name="hiv" class="custom-control-input" value=2>
                                            <label class="custom-control-label" for="srch_hiv-2">No</label>
                                        </div>
                                        {{--Generally not used so commented out--}}
                                        {{-- <div class="custom-control custom-radio custom-control-inline">
                                             <input type="radio" id="srch_hiv-0" name="hiv" class="custom-control-input"
                                                    {{(0==$hiv)?'checked':null}}
                                                    value=0>
                                             <label class="custom-control-label" for="srch_hiv-0">Doesn't Matter</label>
                                         </div>--}}
                                    </div>

                                    <div class="form-group">
                                        <label for="srch_for">Keyword Search:</label>
                                        <input type="text" class="form-control" name="srch_for" id="srch_for" placeholder="Enter text">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-5 mb-5">
                                <input class="btn btn-primary mr-2 " name="srch-submit" type="submit" value="Search Profiles">
                                <input class="btn btn-dark mr-2" type="reset" value="Reset">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="/assets/plugins/select2/js/select2.min.js"></script>
    <script src="/assets/plugins/jquery-mask-input/jquery.mask.min.js"></script>
@endsection

@section('app-script')

    @if(isset($_SESSION['logged-in']))
        @include('scripts.load_notification')
        @include('scripts.load_connected_profiles')
    @endif
    {{--<script>
        function resetAdvanceSearchForm() {
            console.log('hello');
            document.getElementById("search_form").reset();
        }
    </script>--}}


    <script>
        $(document).ready(function(){
            $('#srch_age_min').on('change', function(){
                var min_age = $(this).val();
                console.log(min_age);
                if(min_age){
                    $.ajax({
                        type:'POST',
                        url:'ajax/age-select.php',
                        data:{
                            min_age:min_age
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#srch_age_max').html(data);
                        }
                    });
                }/*else{
                    $('#mbros').html('<option value="">Select brothers first</option>');
                }*/
            });
        });

        $(document).ready(function(){
            $('#srch_height_min').on('change', function(){
                var min_ht = $(this).val();
                console.log(min_ht);
                if(min_ht){
                    $.ajax({
                        type:'POST',
                        url:'ajax/height-select.php',
                        data:{
                            min_ht:min_ht
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#srch_height_max').html(data);
                        }
                    });
                }/*else{
                    $('#mbros').html('<option value="">Select brothers first</option>');
                }*/
            });
        });


        /*$(document).ready(function(){
            $('#srch_age_max').on('change', function(){
                var max_age = $(this).val();
                console.log(max_age);
                if(max_age){
                    $.ajax({
                        type:'POST',
                        url:'ajax/age-select.php',
                        data:{
                            max_age:max_age
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#srch_age_min').html(data);
                        }
                    });
                }/!*else{
                    $('#mbros').html('<option value="">Select brothers first</option>');
                }*!/
            });
        });*/
    </script>
@endsection