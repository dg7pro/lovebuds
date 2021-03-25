@extends('layouts.app')

@section('title', 'Just Unite Free Matrimonial Services')
@section('app-css')
    <script src="https://use.fontawesome.com/fd697be719.js"></script>
    <!-- Core CSS file -->
    <link rel="stylesheet" href="/pswipe/photoswipe.css">

    <!-- Skin CSS file (styling of UI - buttons, caption, etc.)
         In the folder of skin CSS file there are also:
         - .png and .svg icons sprite,
         - preloader.gif (for browsers that do not support CSS animations) -->
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
    <style>
        .xyz{
            margin: 0;
        }
        .blur-contact{
            filter:blur(2px);
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        @if(isset($_SESSION['chain']))
            <div class="row justify-content-center">
                <nav aria-label="Page navigation example" class="mb-2">
                    <ul class="pagination pagination-seperated pagination-seperated-rounded">
                        @if($pn>=1)
                            <li class="page-item">
                                <a class="page-link" href="{{'/profile/'.$_SESSION['chain'][$pn-1]}}" aria-label="Previous">
                                    <span aria-hidden="true" class="mdi mdi-chevron-left mr-1"></span> Prev
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @endif
                        @if($pn<$max-1)
                            <li class="page-item">
                                <a class="page-link" href="{{'/profile/'.$_SESSION['chain'][$pn+1]}}" aria-label="Next">
                                    Next
                                    <span aria-hidden="true" class="mdi mdi-chevron-right ml-1"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
        <div class="bg-white border rounded">
            <div class="row no-gutters">
                <div class="col-lg-4 col-xl-3">
                    <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                        <div class="card text-center widget-profile px-0 border-0">

                            @if(empty($images))
                                <img src="{{'/images/'.($profile->gender==1?'avatar_groom.jpg':'avatar_bride.jpg')}}" width="200px" class="mx-auto img-responsive img-thumbnail rounded" alt="user image" />
                            @else
                            <!-- Galley wrapper that contains all items -->
                                <div id="gallery" class="gallery mx-auto img-responsive img-thumbnail rounded" itemscope itemtype="http://schema.org/ImageGallery">
                                    <!-- Use figure for a more semantic html -->
                                    @foreach($images as $image)
                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="xyz">
                                            <!-- Link to the big image, not mandatory, but usefull when there is no JS -->
                                            <a href="{{'/uploaded/pics/'.$image->filename}}" data-id="{{$profile->id}}" class="ju-album"  data-caption="Sea side, south shore<br><em class='text-muted'>© Dominik Schröder</em>" data-width="600" data-height="800" itemprop="contentUrl">
                                                <!-- Thumbnail -->
                                                <img src="{{'/uploaded/tmb/tn_'.$image->filename}}" alt="user image" width="200px" {{$image->pp!=1?'hidden':''}}>
                                            </a>
                                        </figure>
                                    @endforeach
                                </div>
                            @endif

                            <div class="card-body">
                                <h4 class="py-2 text-dark">{{$profile->first_name.' '.$profile->last_name}}</h4>
                                <p>@if(\Carbon\Carbon::create($profile->last_activity)->diffInMinutes()<1)
                                        <span class="text-success">Online Now</span>
                                    @else
                                        {{'Online: '. \Carbon\Carbon::create($profile->last_activity)->diffForHumans()}}
                                    @endif
                                </p>
                                @if($flag==9)
                                    <input type="button" class="btn btn-success btn-pill btn-lg my-4" id="sendInterest" data-id="{{$profile->id}}" data-flag="{{$flag}}" value="Connected" disabled>
                                @elseif($flag==8)
                                    <input type="button" class="btn btn-primary btn-pill btn-lg my-4" id="sendInterest" data-id="{{$profile->id}}" data-flag="{{$flag}}" value="Accept">
                                @elseif($flag==7)
                                    <input type="button" class="btn btn-info btn-pill btn-lg my-4" id="sendInterest" data-id="{{$profile->id}}" data-flag="{{$flag}}" value="Sent" disabled>
                                @else
                                    <input type="button" class="btn btn-info btn-pill btn-lg my-4" id="sendInterest" data-id="{{$profile->id}}" data-flag="{{$flag}}" value="Initiate">
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-between pl-2 pr-2">
                            <div class="text-center pb-4">
                                {{--<h6 class="text-dark pb-2">1503</h6>--}}
                                <p class="social-button">
{{--                                    <a href="javascript:0" id="like-profile" onclick="likeProfile({{$profile->id}})" class="mb-1 btn btn-outline btn-linkedin rounded-circle {{$like==null?'':'disabled'}}">--}}
                                    <a href="javascript:0" id="like-profile" onclick="likeProfile({{$profile->id}})" class="mb-1 btn btn-outline btn-linkedin rounded-circle {{in_array($profile->id,$user_likes_array)?'disabled':''}}">
                                        <i class="mdi mdi-thumb-up"></i>
                                    </a>
                                </p>
                                <p>Like</p>
                            </div>
                            <div class="text-center pb-4">
                                {{--<h6 class="text-dark pb-2">2905</h6>--}}
                                <p class="social-button">
{{--                                    <a href="javascript:0" id="fav-profile" onclick="favProfile({{$profile->id}})" class="mb-1 btn btn-outline btn-google-plus rounded-circle {{$fav==null?'':'disabled'}}">--}}
                                    <a href="javascript:0" id="fav-profile" onclick="favProfile({{$profile->id}})" class="mb-1 btn btn-outline btn-google-plus rounded-circle {{in_array($profile->id,$user_shorts_array)?'disabled':''}}">
                                        <i class="mdi mdi-heart"></i>
                                    </a>
                                </p>
                                <p>Shortlist</p>
                            </div>
                            {{--<div class="text-center pb-4">
                                --}}{{--<h6 class="text-dark pb-2">1200</h6>--}}{{--
                                <p class="social-button">
                                    <a href="javascript:0" id="hide-profile" onclick="hideProfile({{$profile->id}})" class="mb-1 btn btn-outline btn-linkedin rounded-circle {{$hide==null?'':'disabled'}}">
                                        <i class="mdi mdi-eye-off"></i>
                                    </a>
                                </p>
                                <p>Hide</p>
                            </div>--}}
                            <div class="text-center pb-4">
                                {{--<h6 class="text-dark pb-2">1200</h6>--}}
                                <p class="social-button">
                                    <a class="mb-1 btn btn-outline btn-linkedin rounded-circle"
                                       target="_blank" title="share on whatsapp"
                                       href="https://web.whatsapp.com:/send?text=The Interesting profile I found on JU Matrimony, click the link to see: matrimony.com/profile/{{$profile->pid}}"
                                       data-text="You can see this profile it matches our taste"
                                       data-href="{{'https://www.matrimony.com/profile/'.$profile->pid}}">
                                        <i class="mdi mdi-whatsapp"></i>
                                    </a>
                                </p>
                                <p>Share</p>
                            </div>
                        </div>
                        <hr class="w-100">

                        {{--Comment--}}
                        {{--Hiding contact information into 2 conditions whn user is not verified or user is not
                        connected with that profile in case --}}

                        <div class="contact-info pt-4">
                            {{-- <h5 class="text-dark mb-0">Contact Information</h5>--}}
                            {{--                            @if(( (!isset($_SESSION['logged-in'])) || !in_array($profile->user_id,$_SESSION['conn']) || ($_SESSION['approved']==0) )&& ($profile->user_id != $_SESSION['id']) )--}}
                            @if($addressFlag!=9)
                                <div class="contact-info pt-2">
                                    <h5 class="text-dark mb-1">Contact Information</h5>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Email address
                                        @include('layouts.partials.hidden-contact-info')
                                    </p>
                                    <p class="blur-contact">{{'dummy@gmail.com'}}</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number
                                        @include('layouts.partials.hidden-contact-info')
                                    </p>
                                    <p class="blur-contact">+91 {{'9453351473'}}</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Birthday
                                        @include('layouts.partials.hidden-contact-info')
                                    </p>
                                    {{--<p>Nov 15, 1990</p>--}}
                                    <p class="blur-contact">{{'Nov 15, 1990'}}</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Social Profile</p>
                                    <p class="pb-3 social-button">
                                        <a href="#" class="mb-1 btn btn-outline btn-twitter rounded-circle disabled">
                                            <i class="mdi mdi-twitter"></i>
                                        </a>
                                        <a href="#" class="mb-1 btn btn-outline btn-linkedin rounded-circle disabled">
                                            <i class="mdi mdi-linkedin"></i>
                                        </a>
                                        <a href="#" class="mb-1 btn btn-outline btn-facebook rounded-circle disabled">
                                            <i class="mdi mdi-facebook"></i>
                                        </a>
                                        <a href="#" class="mb-1 btn btn-outline btn-skype rounded-circle disabled">
                                            <i class="mdi mdi-skype"></i>
                                        </a>
                                    </p>
                                </div>
                                {{--<p class="text-muted font-weight-medium pt-4 mb-2">Please verify your profile to see
                                    contact details of others. This is to ensure that we are totally spam free without
                                    any fake profiles
                                </p>--}}
                            @else
                                <div class="contact-info pt-2">
                                    <h5 class="text-dark mb-1">Contact Information</h5>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                                    <p>{{$profile->email}}</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number</p>
                                    <p>+91 {{$profile->mobile}}</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Birthday</p>
                                    {{--                            <p>Nov 15, 1990</p>--}}
                                    <p>{{$profile->dob}}</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Social Profile</p>
                                    <p class="pb-3 social-button">
                                        <a href="#" class="mb-1 btn btn-outline btn-twitter rounded-circle">
                                            <i class="mdi mdi-twitter"></i>
                                        </a>
                                        <a href="#" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                                            <i class="mdi mdi-linkedin"></i>
                                        </a>
                                        <a href="#" class="mb-1 btn btn-outline btn-facebook rounded-circle">
                                            <i class="mdi mdi-facebook"></i>
                                        </a>
                                        <a href="#" class="mb-1 btn btn-outline btn-skype rounded-circle">
                                            <i class="mdi mdi-skype"></i>
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="profile-content-right py-5">
                        <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab"
                                   aria-controls="timeline" aria-selected="true">About {{($profile->gender==1)?'Him':'Her'}}</a>
                            </li>
                            {{--<li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                   aria-controls="profile" aria-selected="false">Education</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                                   aria-controls="settings" aria-selected="false">Family</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                                   aria-controls="settings" aria-selected="false">Desired Partner</a>
                            </li>--}}
                        </ul>

                        <!-- Tabs -->
                        <div class="tab-content px-3 px-xl-5" id="myTabContent">
                            <div class="tab-pane fade show active" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                                <div class="contact-info pt-5">
                                    <h5 class="text-primary mb-1">
                                        <i class="fa fa-user mr-2" aria-hidden="true"></i>
                                        Basic Information</h5>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Name:</p>
                                            <p>{{$profile->first_name.' '.$profile->last_name}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Gender:</p>
                                            <p>{{$profile->gender==1?'Male':'Female'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Birthday</p>
                                            <p>{{$profile->dob}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Marital Status:</p>
                                            <p>{{($profile->mstatus)?$profile->mstatus:'Not Provided'}}</p>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Height:</p>
                                            <p>{{($profile->ht)?$profile->ht:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Religion:</p>
                                            <p>{{($profile->religion)?$profile->religion:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Mother Tongue:</p>
                                            <p>{{($profile->lang)?$profile->lang:'Not Provided'}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-info pt-5" id="education">
                                    <h5 class="text-success mb-1">
                                        <i class="fa fa-graduation-cap mr-2" aria-hidden="true"></i>
                                        Education & Career</h5>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Highest Education:</p>
                                            <p>{{($profile->edu)?$profile->edu:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Degree:</p>
                                            <p>{{($profile->deg)?$profile->deg:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">University:</p>
                                            <p>{{($profile->university)?$profile->university:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Other Degrees:</p>
                                            <p>{{($profile->other_deg)?$profile->other_deg:'Not Provided'}}</p>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Occupation:</p>
                                            <p>{{($profile->occ)?$profile->occ:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Working In:</p>
                                            <p>{{($profile->working_in)?$profile->working_in:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Annual Income:</p>
                                            <p>{{($profile->income)?$profile->income:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Sector:</p>
                                            <p>{{($profile->sector)?$profile->sector:'Not Provided'}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-info pt-5">
                                    <h5 class="text-danger mb-1">
                                        <i class="fa fa-users mr-2" aria-hidden="true"></i>
                                        {{--<i class="mdi mdi-account-group" style="font-size: 1.5rem"></i>--}}
                                        Family Details</h5>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Father:</p>
                                            <p>{{($profile->faa)?$profile->faa:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Mother:</p>
                                            <p>{{($profile->maa)?$profile->maa:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Brother:</p>
                                            {{--                                            <p>{{$profile->bros.' of which married '.$profile->mbros}}</p>--}}
                                            <p>{{($profile->bros)?($profile->bros.' of which married '.$profile->mbros):'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Sister:</p>
                                            {{--<p>{{$profile->sis.' of which married '.$profile->msis}}</p>--}}
                                            <p>{{($profile->sis)?($profile->sis.' of which married '.$profile->msis):'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Origin:</p>
                                            <p>{{'Not Provided'}}</p>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Family Status:</p>
                                            <p>{{$profile->fama?$profile->fama:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Family Income:</p>
                                            <p>{{$profile->fami?$profile->fami:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Family Type:</p>
                                            <p>{{$profile->famt?$profile->famt:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Family Values:</p>
                                            <p>{{$profile->famv?$profile->famv:'Not Provided'}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-info pt-5">
                                    <h5 class="text-info mb-1"><i class="fa fa-star-half-o mr-2" aria-hidden="true"></i>Horoscope</h5>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Manglik:</p>
                                            <p>{{$profile->manglik?$profile->manglik:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Rashi(Moon Sign):</p>
                                            <p>{{$profile->rashi?$profile->rashi:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Sun Sign:</p>
                                            <p>{{$profile->sun?$profile->sun:'Not Provided'}}</p>

                                        </div>
                                        <div class="col-md-5">
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Nakshatra:</p>
                                            <p>{{$profile->nak?$profile->nak:'Not Provided'}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Horoscope Match:</p>
                                            <p>{{($profile->hm)?(($profile->hm==1)?'Necessary':'May be'):'Not Necessary'}}</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="contact-info pt-5">
                                    <h5 class="text-warning mb-1">
                                        <i class="fa fa-heart mr-2" aria-hidden="true"></i>
                                        {{--<i class="mdi mdi-account-group" style="font-size: 1.5rem"></i>--}}
                                        Lifestyle</h5>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Diet:</span>{{$profile->diet?$profile->diet:'Not Provided'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Smoke:</span>{{$profile->smoke?$profile->smoke:'Not Provided'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Drink:</span>{{$profile->drink?$profile->drink:'Not Provided'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Body Type:</span>{{$profile->body?$profile->body:'Not Provided'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Complexion:</span>{{$profile->complexion?$profile->complexion:'Not Provided'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Weight:</span>{{$profile->weight_id?$profile->weight_id.' kgs':'Not Provided'}}</p>
                                            {{--<p class="text-dark font-weight-medium pt-4 mb-2">Smoke:</p>
                                            <p>{{$profile->smoke}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Drink:</p>
                                            <p>{{$profile->drink}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Body Type:</p>
                                            <p>{{$profile->body}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Complexion:</p>
                                            <p>{{$profile->complexion}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Weight:</p>
                                            <p>{{$profile->weight_id.' kgs'}}</p>--}}
                                        </div>
                                        <div class="col-md-5">
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Blood:</span>{{$profile->bg?$profile->bg:'Not Provided'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Hiv+:</span>{{($profile->hiv==1)?'Yes':'No'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Thalassemia:</span>{{$profile->thal?$profile->thal :'Not Provided'}}</p>
                                            <p class="pt-4 mb-2"><span class="text-dark font-weight-medium mr-2">Challenged:</span>{{$profile->chal?$profile->chal :'Not Provided'}}</p>
                                            {{--<p class="text-dark font-weight-medium pt-4 mb-2">Blood Group:</p>
                                            <p>{{$profile->bg}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Hiv+:</p>
                                            <p>{{$profile->hiv}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Thalassemia:</p>
                                            <p>{{$profile->thal}}</p>
                                            <p class="text-dark font-weight-medium pt-4 mb-2">Challenged:</p>
                                            <p>{{$profile->chal}}</p>--}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <!-- Background of PhotoSwipe.
                 It's a separate element as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>
        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">
            <!-- Container that holds slides.
                      PhotoSwipe keeps only 3 of them in the DOM to save memory.
                      Don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <!--  Controls are self-explanatory. Order can be changed. -->
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('app-script')

    <!-- Core JS file -->
    <script src="/pswipe/photoswipe.min.js"></script>

    <!-- UI JS file -->
    <script src="/pswipe/photoswipe-ui-default.min.js"></script>

    <script>
        'use strict';

        /* global jQuery, PhotoSwipe, PhotoSwipeUI_Default, console */

        (function($) {

            // Define click event on gallery item
            $('.ju-album').click(function(event) {

                // Init empty gallery array
                var container = [];
                var eid = $(this).data('id');

                // Prevent location change
                event.preventDefault();

                // Loop over gallery items and push it to the array
                $('#gallery').find('figure').each(function() {
                    var $link = $(this).find('a'),
                        item = {
                            src: $link.attr('href'),
                            w: $link.data('width'),
                            h: $link.data('height'),
                            title: $link.data('caption')
                        };

                    container.push(item);
                });

                // Prevent location change
                event.preventDefault();

                // Define object and gallery options
                var $pswp = $('.pswp')[0],
                    options = {
                        index: $(this).parent('figure').index(),
                        bgOpacity: 0.85,
                        showHideOpacity: true
                    };

                // Initialize PhotoSwipe
                var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                gallery.init();
            });

        }(jQuery));
    </script>

    <script>
        /*======== 5. TOASTER ========*/
        var toaster = $('#toaster');
        function callToaster(positionClass, message) {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: positionClass,
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
            toastr.success(message);
        }

    </script>



    @if(isset($_SESSION['logged-in']))
       {{-- @include('scripts.load_notification')
        @include('scripts.load_connected_profiles')--}}
    @endif
   {{-- @include('scripts.function_record_visitor')--}}

    @include('request.connect_profile')
    @include('request.like_profile')
    @include('request.short_profile')
    @include('request.hide_profile')

    @if(isset($_SESSION['user_id']))
        @include('request.record_visitor')
    @endif




    @include('request.load_notification')



@endsection

