@extends('layouts.app')

@section('page_og')
    <meta property="og:url" content="https://www.jumatrimony.com/home/index"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="JU Matrimony Service"/>
    <meta property="og:description" content="Free Indian Matrimony Service, so find lifepartner - join & unite.
                            God creates couple and we just unite them together"/>
    <meta property="og:image" content="{{'/img/showcase.jpg'}}"/>
@endsection

@section('content')

    <!-- landing section starts -->
    <section class="landing">
        <div class="dark-overlay">
            <div class="landing-inner">
                <!-- <h1 class="x-large">ju-matrimony</h1> -->
                <h1 class="x-large baloo">Join & Unite</h1>
                <!-- <p class="lead">The absolutly free Indian matrimony service created for charitable purpose
                </p> -->
                <p class="lead text-center baloo">Register search and find your soulmate, without paying a single rupee
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
                            <option value="{{$row}}" {{$row==18?'Selected':''}}>{{$row}}</option>
                        @endforeach

                    </select>
                    <span class="search-between">-</span>
                    <select name="maxAge" id="max_age" class="form-control">
                        <option value="">age to</option>
                        @foreach($age_rows as $row)
                            <option value="{{$row}}"  {{$row==38?'Selected':''}}>{{$row}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <input type="text" name="gender" id="gender" class="form-control search-input"> -->
                <select name="rel" id="religion" class="form-control search-input">
                    <option value="">Religion</option>
                    @foreach($religions as $religion)
                        <option value="{{$religion->id}}" {{$religion->id==1?'Selected':''}}>
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
                        <option value="{{$language->value}}" {{$language->value==6?'Selected':''}}>
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
            <h2 class="title baloo">Just 3 steps to follow</h2>
            <p class="subtitle baloo">This matrimony service is 100% free, we don't charge single penny</p>

            <div class="row">

                <div class="col-md-4">
                    <div class="service-box box-1">
                        <img src="/img/signup.png" alt="">
                        <h6>Free Sign Up</h6>
                        <p>Register and create your marriage profile. It just take 2 min's</p>
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="service-box active-service">
                        <img src="/img/share2.png" alt="">
                        <h6>Sharing is Caring</h6>
                        <p>Share once on fb to see contact no's of 101 parties, otherwise site is free</p>
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box box-3">
                        {{--<img src="/img/couple.png" alt="" style="width: 75px !important;">--}}
                        <img src="/img/couple.png" alt="">
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
                            <img src="/img/u26.jpg">
                            <div class="carousel-caption">
                                <h6>Ankita Jaiswal</h6>
{{--                                <small> CEO and Founder @ Microsoft</small>--}}
                                <small> 24 yrs 5'3" M.Com Katni MP</small>
                                {{--<p>Nulla vitae elit libero, a pharetra augue mollis interdum. <br>
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab in porro
                                    <br>laboriosam quibusdam illum. Aut expedita ad magnam ullam suscipit,
                                    <br>eum sed deleniti vel adipisci earum, asperiores cum aliquam quos.</p>--}}
                                <p>Worth trying it, the site is really helpful in searching partner <br>
                                    their service is free in comparison to other portals which charges heavily. <br>
                                    directly see the mobile no. of profiles in which you feel interest.
                                    <br>The only drawback is that you can’t upload more than 3 photos</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/img/u28.jpg">
                            <div class="carousel-caption">
                                <h6>Gopal Srivastav</h6>
                                <small> 32 yrs 5'9" MCA Varanasi UP</small>
                                {{--<p>Nulla vitae elit libero, a pharetra augue mollis interdum. <br>
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab in porro
                                    <br>laboriosam quibusdam illum. Aut expedita ad magnam ullam suscipit,
                                    <br>eum sed deleniti vel adipisci earum, asperiores cum aliquam quos.</p>--}}
                                <p>Website is simple, fast & good to go to find your soul mate <br>
                                    it also has tons of new features, & most important thing it is free. <br>
                                    the design is also elegant I highly recommend this site to all single Indians
                                    <br> so register join & start searching: to unite with your soul mate</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/img/u27.jpg">
                            <div class="carousel-caption">
                                <h6>Sudha Gupta</h6>
                                {{--<small> Senior Developer @ Google</small>--}}
                                <small> 29 yrs 5'2" Doctor Noida UP</small>
                                <p>Very nice website, just register and start searching your partner. <br>
                                    Shortlist whenever you find nice profile then deal one by one
                                    <br> It's much secure than sharing your profile on fb or whatsapp <br>
                                    This website is free & so every single individual must signup here.</p>
                                {{--<p>Nulla vitae elit libero, a pharetra augue mollis interdum. <br>
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab in porro
                                    <br>laboriosam quibusdam illum. Aut expedita ad magnam ullam suscipit,
                                    <br>eum sed deleniti vel adipisci earum, asperiores cum aliquam quos.</p>--}}
                                {{--<p>Very nice website, just register and start searching your love <br>
                                    Their customer service is also very great, fast and efficient. <br>
                                    It is much better than sharing your photo & biodata on facebook or whatsapp
                                    <br> This matchmaking service is free & I love their features</p>--}}
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
                        url:'/ajaxLoad/minmaxAge',
                        data:{
                            min_age_val:minAgeVal
                        },
                        dataType: "json",
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#max_age').html(data.opt);
                        }
                    });
                }else{
                    $('#max_age').html('<option value="">min-age first</option>');
                }
            });
        });
    </script>
@endsection