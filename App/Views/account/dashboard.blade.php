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
                        <i class="fas fa-camera text-white"></i>
                        My Album
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-orange nav-item my_notification" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                       role="tab" aria-controls="pills-contact" aria-selected="false">
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
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-green  nav-item" id="pills-contact-tab" data-toggle="pill" href="#pills-partner-preference"
                       role="tab" aria-controls="pills-contact" aria-selected="false">
                        <i class="fas fa-heart text-white"></i>
                        Partner Preference
                    </a>

                </li>
            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">

            <!-- My Profile tab -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Basic Info
                            <a href="{{'/account/edit-profile#basic-info-card'}}" class="btn btn-blue btn-sm" role="button">Edit</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Profile Id:</td>
                        <td class="hide-sm text-primary"><b>{{$authUser->pid}}</b></td>
                    </tr>
                    <tr>
                        <td>Full name:</td>
                        <td class="hide-sm">{{ucfirst($authUser->first_name).' '.ucfirst($authUser->last_name)}}{{$authUser->gender==1? ' (Male)': ' (Female)' }}</td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td class="hide-sm">
                            {{ucfirst($authUser->dob)}}
                            {{' ('.Carbon\Carbon::createFromDate($authUser->dob)->age.'yrs)'}}
                        </td>
                    </tr>
                    <tr>
                        <td>Caste</td>
                        <td class="hide-sm">{!! ($authUser->caste)?$authUser->caste:$pf !!}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td class="hide-sm">{!! ($authUser->manglik)?$authUser->manglik:$pf !!}</td>
                    </tr>

                    </tbody>
                </table>

                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Education & Career
                            {{--<button class="btn btn-yellow btn-sm">Edit</button>--}}
                            <a href="{{'/account/edit-profile#edu-career-card'}}" class="btn btn-light btn-sm" role="button">Edit</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Education:</td>
                        <td class="hide-sm">{!! ($authUser->edu)?$authUser->edu:$pf !!}</td>
                    </tr>
                    <tr>
                        <td>Profession:</td>
                        <td class="hide-sm">{!! ($authUser->occ)?$authUser->occ:$pf !!}</td>
                    </tr>
                    <tr>
                        <td>Income:</td>
                        <td class="hide-sm">
                            {!! ($authUser->income)?$authUser->income.' / year':$pf !!}
                        </td>
                    </tr>

                    </tbody>
                </table>

                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Family Details
                            {{--<button class="btn btn-yellow btn-sm">Edit</button>--}}
                            <a href="{{'/account/edit-profile#family_details'}}" class="btn btn-yellow btn-sm" role="button">Edit</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Father:</td>
                        <td class="hide-sm">{!! ($authUser->father_name) ? $authUser->father_name : $pf  !!}</td>
                    </tr>
                    <tr>
                        <td>Mother:</td>
                        <td class="hide-sm">{!! ($authUser-> mother_name) ? $authUser->mother_name : $pf  !!}</td>
                    </tr>

                    </tbody>
                </table>

                <table class="ju-table">
                    <thead>
                    <tr>
                        <th colspan="2">Contact Details
                            <a class="btn btn-pink btn-sm" role="button" data-toggle="modal" data-target="#contactsModal">Edit</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Mobile:</td>
                        <td class="hide-sm" id="mb-field">{{$authUser->mobile}}</td>
                    </tr>
                    <tr>
                        <td>Whatsapp:</td>
                        <td class="hide-sm" id="wa-field">{{$authUser->whatsapp}}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td class="hide-sm">{{$authUser->email}}</td>
                    </tr>
                    <tr>
                        <td>Privacy:</td>
                        <td class="hide-sm" id="ow-field">
                            @if($authUser->one_way)
                            <em class="text-muted">Oneway Communication</em>
                            <span class="text-blue text-sm-left"><i>
                                <a id="one-way" data-toggle="tooltip" data-placement="top"
                                   title=" Oneway Communication: Others will not be able to see your contact, but you will receive notification
                                  that other member is Interested. Specially designed for female members who are self
                                  managing their profile"><i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </i></span>
                            @else
                                <em class="text-muted">Contact details are visible</em>
                            @endif

                        </td>

                    </tr>


                    </tbody>
                </table>
            </div>
            <!-- My Profile end -->

            <!-- My Album tab -->
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                <div>
                    @if($image!=null)
                        <img src="{{'/uploaded/pics/'.$image->filename}}" class="img-thumbnail" alt="User Image" width="225px" height="auto"/><br>
                    @else
                        <div class="imgWithIcon2">
                        <a href="{{'/account/my-album'}}"><img src="{{'/img/'.($authUser->gender==1?'groom-grayscale.jpg':'bride-grayscale.jpg')}}" class="img-thumbnail" alt="User Image" width="225px" height="auto"/></a>
                            <i class="fa fa-upload fa-2x {{$authUser->gender==1?'text-light':'text-secondary'}}" aria-hidden="true"><span class="baloo"> Click Me</span></i>
                        </div>

                    @endif
                </div>
                <div class="my-3">You can upload maximum of 3 photos. Your images should be single (no group images are allowed),
                    clear, sharp and front facing.</div>
                <div>
                    {{--<div><span class=""><i class="fa fa-camera text-blue" aria-hidden="true"> </i> You can upload maximum of 3 photos</span></div>--}}
                    <div><span class=""><i class="fa fa-upload text-blue" aria-hidden="true"></i> Upload and save your photo on server</span></div>
                    {{--<div><span class=""><i class="fa fa-crop text-orange" aria-hidden="true"></i> Crop and adjust your photo with photo edit tool before final uploading</span></div>--}}
                    <div><span class=""><i class="fa text-heading">&#xf044;</i> Crop and adjust your photo with photo edit tool before final uploading</span></div>
                    <div><span class=""><i class="fa fa-trash text-red" aria-hidden="true"></i> Replace photo with better one  </span></div>
                    {{--<div><span class=""><i class="fa fa-check text-green" aria-hidden="true"> </i> The photo has been approved and visible to others</span></div>
                    <div><span class=""><i class="fa fa-clock text-orange" aria-hidden="true"> </i> The photo has been submitted for screening, It is pending approval</span></div>
                    <div><span class=""><i class="fa fa-window-close text-red" aria-hidden="true"> </i> The photo has been rejected by our moderation team</span></div>--}}
                </div>

                @if($image!=null)
                    <div class="buttons mt-3">
                        <a href="{{'/account/my-album'}}" class="btn btn-blue">Upload Image</a>
                        <a href="{{'/account/manage-photo'}}" class="btn btn-yellow">Manage Album</a>
                    </div>
                @else
                    <div class="buttons mt-3">
                        <a href="{{'/account/my-album'}}" class="btn btn-blue">Upload Page</a>
                    </div>
                @endif

            </div>


            <!-- Notifications tab -->
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h4 class="text-center text-secondary">-- Notifications -- </h4>
                <div id="records_content">

                </div>
            </div>

            <!-- Share tab -->
            <div class="tab-pane fade" id="pills-share" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h4 class="text-center text-secondary">-- Sharing is Caring -- </h4>

                <div>
                    <p>This is your website (build for the community) and it's services are also free
                    ( & will remain so forever), so what you can do for this - free matrimonial service ?
                        <br><b class="text-blue"><i>The answer is: Just a single share on facebook, is what we expect from you.</i></b></p>

                    <p>Click the button below to share it on facebook and also help your friends in finding their perfect match too.
                    In return of this simple word of mouth we will credit your JU-Matrimony account with <b class="text-blue"><i>100 contacts</i></b>
                        (view contact numbers of 100 profiles). And it does not stops here:
                        <br><b class="text-blue"><i>Share more no. of times to earn more credits</i></b></p>
                </div>
                <a class="btn btn-blue" id="shareBtn">
                    <i class="fab fa-facebook text-white"></i>
                    Share on Facebook
                </a>


            </div>

            <!-- Partner Preference tab -->
            <div class="tab-pane fade" id="pills-partner-preference" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h4 class="text-center text-secondary">-- Set Partner Preference -- </h4>

                <div style="max-width: 75%">
                    <div class="mb-5 form">

                        <h4 class="text-blue mt-4">Select your caste preferences</h4>
                        <div class="form-group">
                            <select multiple id="my-preferred-caste" class="js-example-basic-multiple select-multiple" required>
                                @foreach($allCastes as $caste)
                                    <option value="{{$caste->value}}" {{in_array($caste->value,json_decode($authUser->mycastes))?'Selected':''}}>{{$caste->text}}</option>
                                @endforeach
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
                                    @foreach($age_rows as $row)
                                        <option value="{{$row}}" {{($authUser->min_age==$row)?'Selected':''}}>{{$row}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-field-2">
                                <label for="max_age">Age max:</label>
                                <select id="max_age" name="max_age">
                                    <option value="" selected>Select</option>
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
    @include('modal.contacts')

@endsection

@section('js')

<script>
    $('#one-way').tooltip();

    $(document).ready(function(){
        $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#pills-tab a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>

@include('request.dashboard.facebook')
@include('request.dashboard.contact_info')
@include('request.dashboard.partner_preference')
@include('request.dashboard.notification')

<script src="/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>

@endsection