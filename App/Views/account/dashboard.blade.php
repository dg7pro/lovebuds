@extends('layouts.app')


@section('page_css')
    <link rel="stylesheet" href="/css/select2.min.css">
    <style>
        .select2-container, .select2-selection--multiple{
            width: 100%!important;
            min-height: 70px!important;
        }

        .select2-container--default, .select2-selection--multiple{
            border-radius: 0!important;
        }

    </style>
@endsection

@section('content')

    <!-- userprofile (up) section starts -->
    <section class="main">
        <h1 class="large text-heading">Dashboard</h1>
        <p class="lead">
            <i class="fas fa-user"></i>
            Welcome <a href="{{'/profile/'.$authUser->pid}}">{{ucfirst($authUser->first_name).' '.ucfirst($authUser->last_name)}}</a>
        </p>
        <div class="dash-buttons">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="btn btn-pink nav-item" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                       role="tab" aria-controls="pills-home" aria-selected="true">
                        <i class="fas fa-user-circle text-white"></i>
                        My Profile
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-yellow  nav-item" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                       role="tab" aria-controls="pills-profile" aria-selected="false">
                        <i class="fas fa-camera-retro text-white"></i>
                        Manage Album
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-blue nav-item my_notification" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                       role="tab" aria-controls="pills-contact" aria-selected="false">
                       {{-- <i class="fas fa-graduation-cap text-white"></i>--}}
                        <i class="fas fa-bell text-white"></i>
                        Notification
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="btn btn-blue  nav-item" id="pills-contact-tab" data-toggle="pill" href="#pills-share"
                       role="tab" aria-controls="pills-contact" aria-selected="false">
                        <i class="fab fa-facebook text-white"></i>
                        Share
                    </a>
                    {{--<a href="create-profile.html" class="btn btn-orange" data-toggle="modal" data-target="#settingsModal">
                        <i class="fas fa-cog text-white"></i>
                        Setting
                    </a>--}}
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-blue  nav-item" id="pills-contact-tab" data-toggle="pill" href="#pills-partner-preference"
                       role="tab" aria-controls="pills-contact" aria-selected="false">
                        <i class="fas fa-heart text-white"></i>
                        Partner Preference
                    </a>
                    {{--<a href="" class="btn btn-green" data-toggle="modal" data-target="#partnerPreferenceModal">
                        <i class="fas fa-graduation-cap text-white"></i>
                        Partner Preference
                    </a>--}}
                </li>
            </ul>
            {{-- <a href="{{'/account/my-album'}}" class="btn btn-yellow">
                <i class="fab fa-black-tie text-white"></i>
                Manage Album
            </a>--}}
            {{--<a href="create-profile.html" class="btn btn-coco">
                <i class="fas fa-graduation-cap text-white"></i>
                Family
            </a>--}}
           {{-- <a href="create-profile.html" class="btn btn-green">
                <i class="fas fa-graduation-cap text-white"></i>
                Kundli
            </a>--}}



        </div>

        <div class="tab-content" id="pills-tabContent">

            <!-- My Profile tab -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

{{--                <h3 class="may-2">Basic Information--}}
{{--                    <button class="btn btn-blue btn-sm">Edit</button>--}}
{{--                </h3>--}}
                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Basic Info
                            {{--<span class="badge badge-info"><a href="#" style="text-decoration: none; color: white">Edit</a></span>--}}
                            <a href="{{'/account/edit-profile#basic-info-card'}}" class="btn btn-blue btn-sm" role="button">Edit</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Profile Id:</td>
                        <td class="hide-sm text-primary"><b>{{$authUser->pid}}</b></td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>
                    <tr>
                        <td>Full name:</td>
                        <td class="hide-sm">{{ucfirst($authUser->first_name).' '.ucfirst($authUser->last_name)}}{{$authUser->gender==1? ' (Male)': ' (Female)' }}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td class="hide-sm">
                            {{ucfirst($authUser->dob)}}
                            {{' ('.Carbon\Carbon::createFromDate($authUser->dob)->age.'yrs)'}}
                        </td>
                       {{-- <td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>

                    </tbody>
                </table>

                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Education & Career
                            {{--<span class="badge badge-info"><a href="#" style="text-decoration: none; color: white">Edit</a></span>--}}
                            <button class="btn btn-yellow btn-sm">Edit</button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Education:</td>
                        <td class="hide-sm">{{$authUser->edu}}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>
                    <tr>
                        <td>Profession:</td>
                        <td class="hide-sm">{{$authUser->occ.' ('.$authUser->sector.') '}}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>
                    <tr>
                        <td>Income:</td>
                        <td class="hide-sm">
                            {{$authUser->income.' / year'}}
                        </td>
                        {{-- <td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>

                    </tbody>
                </table>

                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Family Details
                            {{--<span class="badge badge-info"><a href="#" style="text-decoration: none; color: white">Edit</a></span>--}}
                            <button class="btn btn-yellow btn-sm">Edit</button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Father:</td>
                        <td class="hide-sm">{{$authUser->fname.' ('.$authUser->faa. ')'}}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>
                    <tr>
                        <td>Mother:</td>
                        <td class="hide-sm">{{$authUser->mname.' ('.$authUser->maa. ')'}}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>

                    </tbody>
                </table>

                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Contact Details
                            {{--<span class="badge badge-info"><a href="#" style="text-decoration: none; color: white">Edit</a></span>--}}
                            <button class="btn btn-pink btn-sm">Edit</button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Mobile:</td>
                        <td class="hide-sm">{{$authUser->mobile}}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>
                    <tr>
                        <td>Whatsaap:</td>
                        <td class="hide-sm">{{$authUser->whatsaap}}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td class="hide-sm">{{$authUser->email}}</td>
                        {{--<td><button class="btn btn-blue">Edit</button></td>--}}
                    </tr>

                    </tbody>
                </table>

                {{--<h3 class="may-2">Education & Career</h3>
                <table class="ju-table">
                    <thead>
                    <tr>
                        <th>Parameter</th>
                        <th class="hide-sm">Value</th>
                        <th>Change</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Qualification</td>
                        <td class="hide-sm">B.Tech(CS)</td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td>Income</td>
                        <td class="hide-sm">30k/month</td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>

                    </tbody>
                </table>--}}
            </div>
            <!-- My Profile end -->

            <!-- My Album tab -->
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                <div>
                    @if($image!=null)
{{--                        <img src="{{'/uploaded/tmb/tn_'.$image->filename}}" class="img-thumbnail" alt="User Image" width="225px" height="auto"/><br>--}}
                        <img src="{{'/uploaded/pics/'.$image->filename}}" class="img-thumbnail" alt="User Image" width="225px" height="auto"/><br>
                    @else
                        <img src="{{'/img/'.($authUser->gender==1?'groom-grayscale.jpg':'bride-grayscale.jpg')}}" class="img-thumbnail" alt="User Image" width="225px" height="auto"/>
                    @endif
                </div>


                <div class="my-3">You can upload maximum of 3 photos. Your images should be single (no group images are allowed),
                    clear, sharp and front facing.</div>


                <div>
                    <div><span class=""><i class="fa fa-camera text-blue" aria-hidden="true"> </i> You can upload maximum of 3 photos</span></div>
                    <div><span class=""><i class="fa fa-check text-green" aria-hidden="true"> </i> The photo has been approved and visible to others</span></div>
                    <div><span class=""><i class="fa fa-clock text-orange" aria-hidden="true"> </i> The photo has been submitted for screening, It is pending approval</span></div>
                    <div><span class=""><i class="fa fa-window-close text-red" aria-hidden="true"> </i> The photo has been rejected by our moderation team</span></div>
                </div>

                <div class="buttons mt-3">
                    <a href="{{'/account/my-album'}}" class="btn btn-blue">Upload Image</a>
                    <a href="{{'/account/manage-photo'}}" class="btn btn-yellow">Manage Album</a>
                </div>


            </div>


            <!-- Notifications tab -->
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h4 class="text-center text-secondary">-- Notifications -- </h4>

                <div id="records_content">

                </div>
                {{--@foreach($notifications as $notify)
                    <div data-id="{{$notify->id}}" class="alert alert-info alert-dismissible fade show" role="alert">
                        {!! $notify->message !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach--}}

            </div>

            <!-- Share tab -->
            <div class="tab-pane fade" id="pills-share" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h4 class="text-center text-secondary">-- Sharing is Caring -- </h4>


            </div>

            <!-- Partner Preference tab -->
            <div class="tab-pane fade" id="pills-partner-preference" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h4 class="text-center text-secondary">-- Set Partner Preference -- </h4>

                <div style="max-width: 75%">
                    <div class="mb-5 form">

                        <h4 class="text-blue mt-4">Select your caste preferences</h4>
                        <div class="form-group">
                            <select multiple id="my-preferred-caste" class="js-example-basic-multiple select-multiple">
                                @foreach($allCastes as $caste)
                                    <option value="{{$caste->value}}" {{in_array($caste->value,json_decode($authUser->mycastes))?'Selected':''}}>{{$caste->text}}</option>
                                @endforeach
{{--                                <option value="AL">Alabama</option>--}}
{{--                                <option value="AL">UP</option>--}}
{{--                                <option value="AL">Bihar</option>--}}
{{--                                <option value="AL">WB</option>--}}
{{--                                <option value="AL">MP</option>--}}
{{--                                <option value="WY">Wyoming</option>--}}
                            </select>
                        </div>


                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="cnb" {{($authUser->cnb)?'checked':''}} value=0>
                            <label class="form-check-label" for="cnb">Caste no bar (willing to marry in any caste)</label>
                        </div>

                        <h4 class="text-blue mt-4">Partner Physical Traits</h4>

                        <div class="flex-row form-group">
                            <div class="flex-field-2">
                                <label for="min_age">Age min:</label>
                                <select id="min_age" name="min_age">
                                    <option value="" selected>Select</option>
                                    {{--<option value=1>Hindu</option>
                                    <option value=1>Muslim</option>--}}
                                    @foreach($age_rows as $row)
                                        <option value="{{$row}}" {{($authUser->min_age==$row)?'Selected':''}}>{{$row}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="flex-field-2">
                                <label for="max_age">Age max:</label>
                                <select id="max_age" name="max_age">
                                    <option value="" selected>Select</option>
                                    {{--<option value=1>Hindi</option>
                                    <option value=1>English</option>--}}
                                    @foreach($age_rows as $row)
                                        <option value="{{$row}}" {{($authUser->max_age==$row)?'Selected':''}}>{{$row}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex-row form-group">
                            <div class="flex-field-2">
                                <label for="min_ht">Min height:</label>
                                <select id="min_ht" name="min_ht">
                                    <option value="" selected>Select</option>
                                    @foreach($heights as $ht)
                                        <option value="{{$ht->id}}" {{($authUser->min_ht==$ht->id)?'Selected':''}}>{{$ht->feet}}</option>
                                    @endforeach
{{--                                    <option value=1>Hindu</option>--}}
{{--                                    <option value=1>Muslim</option>--}}
                                </select>
                            </div>
                            <div class="flex-field-2">
                                <label for="max_ht">Max height:</label>
                                <select id="max_ht" name="max_ht">
                                    <option value="" selected>Select</option>
                                    @foreach($heights as $ht)
                                        <option value="{{$ht->id}}" {{($authUser->max_ht==$ht->id)?'Selected':''}}>{{$ht->feet}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="pm" {{($authUser->pm)?'checked':''}}>
                            <label class="form-check-label" for="pm">Preferably Manglik <br>(leave unchecked if you are non-manglik)</label>
                        </div>

                        <button type="submit" class="btn btn-green" id="save-partner-preference" value="update_pp">Save Partner Preferences</button>
                    </div>
                </div>


            </div>


        </div>



    </section>
    <!-- profiles section ends -->

    <!-- modals included -->
{{--    @include('modal.settings')--}}
{{--    @include('modal.partner-preference')--}}

@endsection


@section('js')

    <script>
        $(document).ready(function(){
            $('#min_age').on('change', function(){
                var minAgeVal = $(this).val();
                console.log(minAgeVal);
                if(minAgeVal){
                    $.ajax({
                        type:'POST',
                        url:'/ajax/minmaxAge',
                        data:{
                            min_age_val:minAgeVal
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#max_age').html(data);
                        }
                    });
                }else{
                    $('#max_age').html('<option value="">min-age first</option>');
                }
            });
        });
        $(document).ready(function(){
            $('#min_ht').on('change', function(){
                var minHtVal = $(this).val();
                console.log(minHtVal);
                if(minHtVal){
                    $.ajax({
                        type:'POST',
                        url:'/ajax/minmaxHt',
                        data:{
                            min_ht_val:minHtVal
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#max_ht').html(data);
                        }
                    });
                }else{
                    $('#max_ht').html('<option value="">min-ht first</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function (){
            $('#save-partner-preference').on('click', function () {

                var pp = $('#save-partner-preference').val();
                var myCastes = $('#my-preferred-caste').val();
                var cnb = ($('#cnb').is(':checked'))?1:0;
                var minHt = $('#min_ht').val();
                var maxHt = $('#max_ht').val();
                var minAge = $('#min_age').val();
                var maxAge = $('#max_age').val();
                var pm = ($('#pm').is(':checked'))?1:0;

                console.log(myCastes);
                console.log(cnb);

                $.ajax({
                    url: "/ajax/updatePartnerPreference",
                    method: 'post',
                    data: {
                        pp:pp,
                        mycastes:myCastes,
                        cnb:cnb,
                        min_ht:minHt,
                        max_ht:maxHt,
                        min_age:minAge,
                        max_age:maxAge,
                        pm:pm
                    },
                    dataType: "json",
                    success: function (data, status) {
                        //var message = data.msg;
                        setTimeout(function(){
                            toastr.success(data.msg);
                        }, 500);
                        console.log(data);
                        console.log(status);
                    }
                });
            });

        });
    </script>


    <script>
        // $('.alert').on('closed.bs.alert', function () {
        //     // do something...
        //     // alert id
        //     var aid = $(this).attr("data-id");
        //     console.log(aid);
        //
        //     $.ajax({
        //         url: "/ajax/mar-notification",
        //         method: 'post',
        //         data: {
        //             aid: aid
        //         },
        //         dataType: "text",
        //         success: function (data, status) {
        //             console.log(data);
        //             console.log(status);
        //             // setTimeout(function(){
        //             //     toastr.success(data);
        //             // }, 1000);
        //             //$('#hide-profile').addClass('disabled');
        //         }
        //     });
        // });

        function marNotification(id){
            console.log(id);
            $.ajax({
                url: "/ajax/mar-notification",
                method: 'post',
                data: {
                    aid: id
                },
                dataType: "text",
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                    // setTimeout(function(){
                    //     toastr.success(data);
                    // }, 1000);
                    //$('#hide-profile').addClass('disabled');
                }
            });
        }

        // $(document).ready(function(){
        //     $(document).on('closed.bs.alert','.alert',function() {
        //
        //         var aid = $(this).attr("data-id");
        //         console.log(aid);
        //
        //         $.ajax({
        //             url: "/ajax/mar-notification",
        //             method: 'post',
        //             data: {
        //                 aid: aid
        //             },
        //             dataType: "text",
        //             success: function (data, status) {
        //                 console.log(data);
        //                 console.log(status);
        //
        //             }
        //         });
        //
        //     });
        // });
    </script>
    <script>
        //=================
        // Read Record
        //=================
        function readNotifications() {
            var readrecord = "readrecord";
            $.ajax({
                url: "/ajax/unreadNotifications",
                type: "POST",
                data: {
                    readrecord:readrecord
                },
                success: function(data,status){
                    //console.log(data);
                    $('#records_content').html(data);
                }
            })
        }

        $('.my_notification').on('click', function(){

            readNotifications();
            console.log('my current notifications');

            // $.ajax({
            //     url: "/Ajax/load-recent-visitors",
            //     method: "POST",
            //     data:{},
            //
            //     success:function(data){
            //         $('#recent-profile-visitor').html(data);
            //         // setTimeout(function(){
            //         //     $('#loader-icon').addClass('display-off');
            //         // }, 500);
            //
            //     }
            // })

        });
    </script>
    <script src="/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection