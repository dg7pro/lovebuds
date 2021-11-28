@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
    <style>
        .loading{
            padding-bottom: 60vh;
        }
        .display-off{
            display: none;
        }
    </style>
@endsection

@section('content')

     <section class="button_bar">
        <div class="button_row">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="shape-button" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                       role="tab" aria-controls="pills-home" aria-selected="true">
                        <ion-icon name="person-add-sharp" size="large"></ion-icon>
                        <!-- <i class="material-icons bnav__icon">dashboard</i> -->
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="shape-button shortlisted-profiles" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                       role="tab" aria-controls="pills-profile" aria-selected="false">
                        <ion-icon name="list-sharp" size="large"></ion-icon>
                        {{--<ion-icon name="star-sharp" size="large"></ion-icon>--}}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="shape-button recent_visitor" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                       role="tab" aria-controls="pills-contact" aria-selected="false">
                        <ion-icon name="eye-sharp" size="large"></ion-icon>
                    </a>
                </li>
            </ul>
        </div>

    </section>

    <div class="tab-content" id="pills-tabContent">

        <!-- My Profile -->
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

            <h4 class="text-center text-secondary"> New Profiles </h4>

            <section class="profiles" id="new-profiles">
                <span id="ring-loader-1" class="text-center loading"><img src="/img/ring.gif" alt=""></span>

            </section>

        </div>
        <!-- My Profile end -->

        <!-- My Album -->
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

            <h4 class="text-center text-secondary"> Shortlisted Profiles </h4>

            <section class="profiles" id="shortlisted-profiles">
                <span id="ring-loader-2" class="text-center loading"><img src="/img/ring.gif" alt=""></span>

            </section>
            @if($s_num>10)
                <div class="profiles-buttons">
                    <a href="{{'/search/shortlisted'}}" class="btn btn-blue mb-5"><i class="fas fa-heart san"></i>All Shortlisted Profiles</a>
                </div>
            @endif
        </div>
        <!-- My Album end -->

        <!-- Notifications -->
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <h4 class="text-center text-secondary"> Profile Visitors </h4>

            <section class="profiles" id="recent-profile-visitor">
                <span id="ring-loader-3" class="text-center loading"><img src="/img/ring.gif" alt=""></span>

            </section>
            @if($r_num>1)
                <div class="profiles-buttons">
                    <a href="{{'/search/recent-visitors'}}" class="btn btn-blue mb-5"><i class="fas fa-heart san"></i>All Recent Visitors</a>
                </div>
            @endif
        </div>
    </div>

    @include('modal.photoswipe')




@endsection

@section('js')

    @include('searchJS.pswipeFunctions')
    @include('searchJS.moveFunctions')

    <script>

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
                                    if(data.cc){
                                        $('#addr-'+id).html(data.addr);
                                    }

                                    //$('#hide-profile').addClass('disabled');
                                }
                            });

                            var cbtn = document.getElementById("contact-btn-"+id);
                            console.log(cbtn);
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

    @include('searchJS.loadFunctions')

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

@endsection