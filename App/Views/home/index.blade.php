@extends('layouts.app')

@section('content')

    <!-- landing section starts -->
    <section class="landing">
        <div class="dark-overlay">
            <div class="landing-inner">
                <!-- <h1 class="x-large">ju-matrimony</h1> -->
                <h1 class="x-large">Just Unite</h1>
                <!-- <p class="lead">The absolutly free Indian matrimony service created for charitable purpose
                </p> -->
                <p class="lead">Register search and find your soulmate, without paying a single rupee
                </p>
                @if($authUser)
                    <div class="buttons">
                        <a href="{{'/account/dashboard'}}" class="btn btn-pink">Dashboard</a>
                        <a href="{{'/account/logout'}}" class="btn btn-orange">Logout</a>
                    </div>
                @else
                    <div class="buttons">
                        <a href="{{'/register/index'}}" class="btn btn-pink">Register</a>
                        <a href="{{'/login/index'}}" class="btn btn-orange">Login</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- landing section ends -->


    <section class="searching">
        <form method="get" id="quick_search" name="quick_search" action="{{'/quick/search'}}">
            <div class="search-partner">
                <!-- <input type="text" name="gender" id="gender" class="form-control search-input"> -->
                <select name="gender" id="gender" class="form-control search-input">
                    @if($authUser)
                        @if($authUser->gender==1)
                            <option value="2" selected>Bride</option>
                        @else
                            <option value="1" selected>Groom</option>
                        @endif
                    @else
                        <option value="2" selected>Bride</option>
                        <option value="1">Groom</option>
                    @endif
                </select>
                <div class="search-input search-age">
                    <select name="minAge" id="min_age" class="form-control">
                        <option value="">age from</option>
                        @foreach($age_rows as $row)
                            <option value="{{$row}}">{{$row}}</option>
                        @endforeach

                    </select>
                    <span class="search-between">-</span>
                    <select name="maxAge" id="max_age" class="form-control">
                        <option value="">age to</option>
                        @foreach($age_rows as $row)
                            <option value="{{$row}}">{{$row}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <input type="text" name="gender" id="gender" class="form-control search-input"> -->
                <select name="rel" id="religion" class="form-control search-input">
                    <option value="">Religion</option>
                    @foreach($religions as $religion)
                        <option value="{{$religion->id}}">
                            {{$religion->name}}
                        </option>
                    @endforeach
                    {{--<option value="hindu">Hindu</option>
                    <option value="muslim">Muslim</option>
                    <option value="sikh">Sikh</option>--}}
                </select>
                <select name="lan" id="community" class="form-control search-input">
                    <option value="">Language speaking</option>
                    @foreach($languages as $language)
                        <option value="{{$language->value}}">
                            {{$language->text}}
                        </option>
                    @endforeach
                </select>
                <input type="submit" name="quick-search-submit"  value="Search Partner" class="btn btn-coco search-input">
            </div>
        </form>
    </section>

    <!-- 3 Step Process  -->
    <section class="services">
        <div class="container">
            <h2 class="title">Just 3 steps to follow</h2>
            <p class="subtitle">This matrimony service is 100% free, we don't charge single penny</p>

            <div class="row">

                <div class="col-md-4">
                    <div class="service-box">
                        <img src="img/signup.png" alt="">
                        <h6>Free Sign Up</h6>
                        <p>Register and create your marriage profile. It just take 2 min's</p>
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="service-box active-service">
                        <img src="img/share2.png" alt="">
                        <h6>Sharing is Caring</h6>
                        <p>Share once on fb to see contact no's of 101 parties, otherwise site is free</p>
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box">
                        <img src="img/couple.png" alt="" style="width: 75px !important;">
                        <h6>Be a Couple</h6>
                        <p>Complete yourself, just find someone very special to you & family</p>
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End 3 Step Process -->


    <!-- Start -->
    <section class="review">
        <div class="container">

            <div class="bd-example">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/img/t1.jpg">
                            <div class="carousel-caption">
                                <h6>Jennifer Lopez</h6>
                                <small> CEO and Founder @ Microsoft</small>
                                <p>Nulla vitae elit libero, a pharetra augue mollis interdum. <br>
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab in porro
                                    <br>laboriosam quibusdam illum. Aut expedita ad magnam ullam suscipit,
                                    <br>eum sed deleniti vel adipisci earum, asperiores cum aliquam quos.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/img/t2.jpg">
                            <div class="carousel-caption">
                                <h6>Ashwarya Rai</h6>
                                <small> Project Manager @ Amazon</small>
                                <p>Nulla vitae elit libero, a pharetra augue mollis interdum. <br>
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab in porro
                                    <br>laboriosam quibusdam illum. Aut expedita ad magnam ullam suscipit,
                                    <br>eum sed deleniti vel adipisci earum, asperiores cum aliquam quos.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/img/t3.jpg">
                            <div class="carousel-caption">
                                <h6>Madhuri Dixit</h6>
                                <small> Senior Developer @ Google</small>
                                <p>Nulla vitae elit libero, a pharetra augue mollis interdum. <br>
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab in porro
                                    <br>laboriosam quibusdam illum. Aut expedita ad magnam ullam suscipit,
                                    <br>eum sed deleniti vel adipisci earum, asperiores cum aliquam quos.</p>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- End -->


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
    </script>
@endsection