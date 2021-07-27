@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
    {{--    <style>--}}
    {{--        #loader-icon {top: 60%;width:100%;height:100%;text-align:center;}--}}
    {{--        .display-off{--}}
    {{--            display: none;--}}
    {{--        }--}}
    {{--    </style>--}}
    <style>
        .loading{
            padding-bottom: 60vh;
            /*display: none;*/
        }
        .display-off{
            display: none;
        }
    </style>
@endsection

@section('content')

    <section class="profiles-buttons">
        <div>
            <ul class="nav nav-pills mb-3">
                <li class="nav-item" role="presentation">
                    <a class="btn btn-pink nav-item" href="{{'/search/index'}}">
                        <i class="fas fa-angle-double-left text-white"></i>
                        Back to Main Search
                    </a>
                </li>
            </ul>
        </div>
    </section>

   {{-- <h4 class="text-center text-secondary" style="padding-top: 3.5em">-- Shortlisted profiles --</h4>--}}
    <h4 class="text-center text-secondary">-- Shortlisted profiles --</h4>

    <section class="profiles" id="new-profiles">

        {{-- @foreach($shortlistedProfiles as $profile)
             <div class="profiles-card">

                 <!-- Main Section -->
                 <div class="main-card">
                     <div class="profile-sidebar">

                         @if(!isset($profile['pics']))

                             <img src="{{'/img/'.($profile['gender']==1?'avatar_groom.jpg':'avatar_bride.jpg')}}" class="profile-image" width="135px" alt="User Image1" />

                         @else

                         <!-- Galley wrapper that contains all items -->
                             <div id="{{'gallery'.$profile['id']}}" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
                             @foreach($profile['pics'] as $pic)

                                 <!-- Use figure for a more semantic html -->
                                     <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                         <!-- Link to the big image, not mandatory, but usefull when there is no JS -->
                                         <a href="{{'/uploaded/pics/'.$pic['fn']}}" data-id="{{$profile['id']}}" class="ju-album"  data-caption="Sea side, south shore<br><em class='text-muted'>© Dominik Schröder</em>" data-width="600" data-height="800" itemprop="contentUrl">
                                             <!-- Thumbnail -->
                                             <img src="{{'/uploaded/tmb/tn_'.$pic['fn']}}" alt="jgjt" width="135px" class="profile-image" {{($pic['pp']!=1)?'hidden':''}}>
                                         </a>
                                     </figure>
                                 @endforeach
                             </div>


                         @endif
                         <p class="profile-bio">{{\Carbon\Carbon::parse($profile['dob'])->age}} yrs, {{$profile['ht']}}<br>{{$profile['town']}}</p>

                     </div>
                     <div class="profile-main">
                         <h2 class="profile-name">{{$profile['first_name']}}</h2>
                         <p class="profile-position">{{$profile['edu']}}, {{$profile['occ']}}</p>
                         <p class="profile-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                             Perspiciatis inventore eos ipsam debitis.
                         </p>
                         <div>
                             <button class="btn btn-pink">Profile</button>
                             @if($authUser)
                                 --}}{{--<button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange contact">Contact</button>--}}{{--
                                 <button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange" onclick="viewContactAdd({{$profile['id']}})" >Contact</button>
                             @else
                                 <button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Contactc</button>
                             @endif
                         </div>

                     </div>
                     <div class="profile-handler">
                         <a title="Share on whatsapp" class="share" href="javascript:void(0)"><i class="fas fa-share san"></i></a>
                         <a title="Shortlist and Like" data-id="{{$profile['id']}}" class="shortlist" href="javascript:void(0)"><i class="fas fa-heart san"></i></a>
                         <a title="Downlist and Hide" data-id="{{$profile['id']}}" class="downlist" href="javascript:void(0)"><i class="fas fa-arrow-circle-down san"></i></a>
                     </div>
                 </div>
                 <div class="ups-ab">
                     <span><i class="fab fa-whatsapp"></i>  7565097233</span>
                     <span><i class="fas fa-phone-alt"></i>  7565097233</span>
                     <span><i class="far fa-envelope"></i> dg7proj@gmail.com</span>

                     <div id="{{'ups-ab-overlay-'.$profile['id']}}" class="ups-ab-overlay">
                         <!--user profiles address bar-->
                         <div class="text">Contact Address</div>
                     </div>
                 </div>
             </div>
         @endforeach--}}
    </section>





    @include('modal.photoswipe')

@endsection

@section('js')

    {{--@include('request.view_address')
    @include('request.view_photo')--}}

    @include('searchJS.pswipeFunctions')
    @include('searchJS.moveFunctions')

    <!-- custom js code -->

    <script>
        $(document).ready(function (){

            load_data(1);

            function load_data(page, query=''){
                $.ajax({
                    url: "/AjaxSearch/shortlisted-profiles",
                    method: "POST",
                    data:{
                        page:page,
                        query:query
                    },
                    success:function(data){
                        $('#new-profiles').html(data);
                    }
                });
            }

            $(document).on('click', '.page-link', function(){
                var page = $(this).data('page_number');
                load_data(page);
            });


        });

    </script>


    <script>
       /* $(document).ready(function(){
            $(".contact").on("click", function(){
                console.log('fucked');
                var dataId = $(this).attr("data-id");
                //alert("The data-id of clicked item is: " + dataId);

                var cbtn = document.getElementById("contact-btn-"+dataId);
                var addr = document.getElementById("ups-ab-overlay-"+dataId);
                addr.style.width= 0;
                addr.style.left= 100;
                setTimeout(function(){
                    toastr.success('Contact number is visible now');
                }, 1000);

                cbtn.setAttribute('disabled','disabled');
            });
        });*/

        function viewContactAdd(id){
            console.log('contact clicked');
            console.log(id);
            //alert("The data-id of clicked item is: " + id);
            $.confirm({
                title: 'View Contact details ',
                content: 'The number of contacts viewed by you is counted and recorded to fight <strong>spam</strong>',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            $.ajax({

                                url: "/AjaxActivity/show-contact",
                                method: 'post',
                                data: {
                                    other_id:id
                                },
                                dataType:"json",
                                success: function (data, status) {
                                    console.log(data);
                                    console.log(status);
                                    setTimeout(function(){
                                        toastr.success(data.msg);
                                    }, 1000);
                                    //$('#hide-profile').addClass('disabled');
                                }
                            });

                            var cbtn = document.getElementById("contact-btn-"+id);
                            var addr = document.getElementById("ups-ab-overlay-"+id);
                            addr.style.width= 0;
                            addr.style.left= 100;
                            cbtn.setAttribute('disabled','disabled');
                        }
                    },
                    cancel: function(){
                        $.alert('You clicked <strong>cancel</strong>. Thanx we can\'t continue.');
                    },

                }
            });

        }

        function sendWhatsappInterest(id){
            console.log('send whatsapp clicked');
            console.log(id);
            //alert("The data-id of clicked item is: " + id);

            $.ajax({

                url: "/AjaxActivity/show-contact",
                method: 'post',
                data: {
                    other_id:id
                },
                dataType:"json",
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                }
            });

        }
    </script>

@endsection