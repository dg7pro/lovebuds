@extends('layouts.app')

@section('page_css')
    <style>
        .others {color:black}
    </style>
@endsection

@section('content')

    <!-- registration section -->
    <section class="main">
        @include('layouts.partials.alert')

        <h1 class="large text-heading">
            Create Profile
        </h1>
        <p class="lead"><i class="fas fa-user"> </i> Every field is Important</p>

        <form class="form" action="{{'/account/save-profile'}}" method="POST" autocomplete="off" >
            <div>
                <input type="hidden" name="token" value="{{$_SESSION['csrf_token']}}" />
            </div>
            <div class="flex-row form-group">
                <div class="flex-field-2">
                    <input type="text" id="fname" name="first_name" placeholder="First name" value="{{isset($arr['first_name'])?$arr['first_name']:''}}" required>
                </div>
                <div class="flex-field-2">
                    <input type="text" id="lname" name="last_name" placeholder="Last name" value="{{isset($arr['last_name'])?$arr['last_name']:''}}" required>
                </div>
            </div>

            <div class="flex-row form-group mb-4">
                <div class="flex-field-3">
                    <select id="day" name="day" required>
                        <option value="" selected>Day</option>
                        @foreach($dates as $date)
                            <option value="{{$date}}" {{isset($arr['day']) && $arr['day']==$date ?'selected':''}} class="others">{{$date}}</option>
                        @endforeach
                    </select>
                    <small class="form-text">For date of birth</small>
                </div>
                <div class="flex-field-3">
                    <select id="month" name="month" required>
                        <option value="" selected>Month</option>
                        @foreach($months as $mo)
                            <option value="{{$mo['value']}}" {{isset($arr['month']) && $mo['value']==$arr['month'] ? 'selected':''}}>{{$mo['text']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-3">
                    <select id="year" name="year" required>
                        <option value="" selected>Year</option>
                        @foreach($years as $year)
                            <option value="{{$year}}" {{isset($arr['year']) && $arr['year']==$year?'selected':''}} class="others">{{$year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-2">
                    <select id="religion" name="religion_id" required>
                        <option value="" selected>Religion</option>
                        @foreach($religions as $religion)
                            <option value="{{$religion->id}}" {{isset($arr['religion_id']) && $arr['religion_id']==$religion->id ?'selected':''}} class="others">{{$religion->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-2">
                    <select id="community" name="community_id" required>
                        <option value="" selected>Community</option>
                        @foreach($communities as $community)
                            <option value="{{$community->id}}" {{ isset( $arr['community_id']) && $arr['community_id']==$community->id ?'selected':''}} class="others">{{$community->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-2">
                    <select id="caste" name="caste_id" required>
                        <option value="" selected>Caste</option>
                        @foreach($castes as $caste)
                            <option value="{{$caste->value}}"  class="others">{{$caste->text}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="flex-field-2">
                    <select id="astro" name="manglik_id" required>
                        <option value="" selected>Astro</option>
                        @foreach($mangliks as $manglik)
                            <option value="{{$manglik->id}}" {{isset($arr['manglik_id']) && $arr['manglik_id']==$manglik->id ?'selected':''}} class="others">{{$manglik->status}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-2">
                    <select id="mStatus" name="marital_id" required>
                        <option value="" selected>Marital</option>
                        @foreach($maritals as $marital)
                            <option value="{{$marital->id}}" {{isset($arr['marital_id']) && $arr['marital_id']==$marital->id ?'selected':''}} class="others">{{$marital->status}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-field-2">
                    <select id="height" name="height_id" required>
                        <option value="" selected>Height</option>
                        @foreach($heights as $ht)
                            <option value="{{$ht->id}}" {{isset($arr['height_id']) && $arr['height_id']==$ht->id ?'selected':''}} class="others">{{$ht->feet}}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="flex-row-stretch form-group mb-4">
                <div class="flex-field-1">
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="Whatsapp" value="{{isset($arr['whatsapp'])?$arr['whatsapp']:''}}" required>
                    <small class="form-text">For sending & receiving whatsapp interest </small>
                </div>

            </div>

            <div class="flex-row form-group">
                <div class="flex-field-2">
                    <select id="education" name="education_id" required>
                        <option value="" selected>Education</option>
                        @foreach($educations as $education)
                            <optgroup label="{{$education['stream']}}">
                                @foreach($education['edu'] as $edu)
                                    <option value="{{$edu['id']}}" {{isset($arr['education_id']) && $arr['education_id']==$edu['id'] ?'selected':''}} class="others">{{$edu['name']}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="flex-field-2">
                    <select id="income" name="income_id" required>
                        <option value="" selected>Income</option>
                        @foreach($incomes as $income)
                            <option value="{{$income->id}}" {{isset($arr['income_id']) && $arr['income_id']==$income->id ?'selected':''}} class="others">{{$income->level}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row-stretch form-group">
                <div class="flex-field-1">
                    <select id="occupation" name="occupation_id" required>
                        <option value="" selected>Occupation</option>
                        @foreach($occupations as $occupation)
                            <optgroup label="{{$occupation['category']}}">
                                @foreach($occupation['occ'] as $occ)
                                    <option value="{{$occ['id']}}" {{isset($arr['occupation_id']) && $arr['occupation_id']==$occ['id'] ?'selected':''}} class="others">{{$occ['name']}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-row form-group">
                <div class="flex-field-1">
                    <select id="cn_update" name="country_id" required>
                        <option value=77 selected>India</option>
                        @foreach($countries as $country)
                            <optgroup label="{{$country['alpha']}}">
                                @foreach($country['coni'] as $con)
                                    <option value="{{$con["id"]}}" {{isset($arr['country_id']) && $arr['country_id']==$con['id'] ?'selected':''}}>{{$con["name"]}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            @if(isset($arr['country_id']) && $arr['country_id']!=77)
                <!-- For Other countries states and districts--checked -->
                <div class="flex-row form-group">
                    <div class="flex-field-2">
                        <select id="st_update" name="st_india" class="form-control" hidden>
                            <option value="">State</option>
                            @foreach($states as $state)
                                <option value="{{$state->text}}" data-id="{{$state->id}}">{{$state->text}}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control" id="st_entry" name="st_other" value="{{(isset($arr['st_other']) && $arr['st_other']!='')?$arr['st_other']:''}}" placeholder="State/Province" required>
                    </div>
                    <div class="flex-field-2">
                        <select id="ds_update" name="ds_india" class="form-control" hidden>
                            <option value="">Select state first</option>
                        </select>
                        <input type="text" class="form-control" id="ds_entry" name="ds_other"  value="{{(isset($arr['ds_other']) && $arr['ds_other']!='')?$arr['ds_other']:''}}" placeholder="City/Town" required>
                    </div>
                </div>
            @else
                <!-- For India states and districts -- checked -->
                <div class="flex-row form-group">
                    <div class="flex-field-2">
                        <select id="st_update" name="st_india" class="form-control" required>
                            <option value="">State</option>
                            @foreach($states as $state)
                                <option value="{{$state->text}}" data-id="{{$state->id}}" {{isset($arr['st_india']) && $arr['st_india']==$state->text ?'selected':''}}>{{$state->text}}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control" id="st_entry" name="st_other" placeholder="State/Province" hidden>
                    </div>
                    <div class="flex-field-2">
                        <select id="ds_update" name="ds_india" class="form-control" required>
                            @if(isset($arr['ds_india']))
                                <option value="{{$arr['ds_india']}}">{{$arr['ds_india']}}</option>
                                <option value="" disabled>Change State to reload</option>
                            @else
                                <option value="">Select state first</option>
                            @endif
                        </select>
                        <input type="text" class="form-control" id="ds_entry" name="ds_other" placeholder="City/Town" hidden>
                    </div>
                </div>
            @endif

            <input type="submit" value="Save Profile" name="create-profile-submit" class="btn btn-green may-2">

        </form>
    </section>
    <!-- registration ends -->

@endsection

@section('js')
    <script>
        $(document).ready(function(){

            $('#religion').change(function(){
                var rel = $(this).children("option:selected").val();
                console.log(rel);

                $.ajax({

                    url:"/AjaxRegistration/selectAstro",
                    method:'POST',
                    data:{rel:rel},
                    dataType:"json",
                    success:function (data) {
                        console.log(data);
                        if(data.ash==='other'){
                            $('#astro').attr('disabled',true);
                            // $('input[name=manglik_id] option[val=""]').html('Not applicable');
                            //$('#astro option:selected').text("Not applicable");
                            $("#astro option[value='']").text("Not applicable");

                        }
                        else{
                            //$('#astro option:selected').text("Select");
                            $("#astro option[value='']").text("Astro");
                            $('#astro').removeAttr('disabled');
                        }
                    },

                });

            });

        });

        $(document).ready(function(){

            $('#cn_update').change(function(){
                var cntry = $(this).find(':selected').val();
                console.log(cntry);
                if(cntry!=77){
                    $('#st_update').hide().attr('hidden', true);
                    $('#ds_update').hide().attr('hidden', true);
                    $('#st_entry').attr('hidden', false);
                    $('#ds_entry').attr('hidden', false);
                    // $('#st_update').attr('hidden', true);
                    // $('#ds_update').attr('hidden', true);
                }
                else{
                    $('#st_entry').attr('hidden', true);
                    $('#ds_entry').attr('hidden', true);
                    $('#st_update').attr('hidden', false).show();
                    $('#ds_update').attr('hidden', false).show();
                    /*$('#st_update').show();
                    $('#ds_update').show();*/
                }
            });
        });

        $(document).ready(function(){
            $('#st_update').on('change', function(){
                //var stateID = $(this).val();
                var stateID = $(this).find(':selected').attr("data-id");
                console.log(stateID);
                if(stateID){
                    $.ajax({
                        headers:{
                            'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                            // 'CsrfToken': '65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1',
                        },
                        type:'POST',
                        url:'/ajaxLoad/select-district',
                        data:{
                            state_id:stateID
                        },
                        dataType: "json",
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#ds_update').html(data.opt);
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            console.log( jqXhr.responseJSON.message );
                            console.log( errorThrown );
                            //console.log( jqXhr.responseText );
                            $.alert({
                                title: 'Security Alert!',
                                content: jqXhr.responseJSON.message + ' Please logout and login after sometime to continue.',
                                icon: 'fa fa-skull',
                                animation: 'scale',
                                closeAnimation: 'scale',
                                buttons: {
                                    okay: {
                                        text: 'Okay',
                                        btnClass: 'btn-blue'
                                    }
                                }
                            });
                        }
                    });
                }else{
                    $('#ds_update').html('<option value="">Select state first</option>');
                }
            });
        });
    </script>
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

            $('#astro').css('color','gray');
            $('#astro').change(function() {
                var current = $('#astro').val();
                if (current != 'null') {
                    $('#astro').css('color','black');
                } else {
                    $('#astro').css('color','gray');
                }
            });

            $('#caste').css('color','gray');
            $('#caste').change(function() {
                var current = $('#caste').val();
                if (current != 'null') {
                    $('#caste').css('color','black');
                } else {
                    $('#caste').css('color','gray');
                }
            });

            $('#cn_update').css('color','gray');
            $('#cn_update').change(function() {
                var current = $('#cn_update').val();
                if (current != 'null') {
                    $('#cn_update').css('color','black');
                } else {
                    $('#cn_update').css('color','gray');
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

            $('#income').css('color','gray');
            $('#income').change(function() {
                var current = $('#income').val();
                if (current != 'null') {
                    $('#income').css('color','black');
                } else {
                    $('#income').css('color','gray');
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