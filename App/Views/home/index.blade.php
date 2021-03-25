@extends('layouts.app')

@section('title', 'Ju-Matrimony')

@section('content')

    <div class="content">

        @include('layouts.partials.flash')

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h3>Just Unite Matrimony</h3>
                    </div>
                    <div class="card-body">
                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item bg-gradient-dark active">
                                    <img class="d-block w-100" src="/assets/img/elements/ju_slide2.jpg" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Life partner</h5>
                                        <p>The happiness you get forever </p>
                                    </div>
                                </div>
                                <div class="carousel-item bg-gradient-dark">
                                    <img class="d-block w-100" src="/assets/img/elements/ju_slide3.jpg" alt="Second slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Someone Special</h5>
                                        <p>Find your true soulmate here</p>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                <span class="mdi mdi-chevron-left mdi-36px" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                <span class="mdi mdi-chevron-right mdi-36px" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h3>Create Account</h3>
                        <span class="mb-3 ml-2 badge badge-success">Free</span>
                    </div>
                    <div class="card-body">
                        <form action="{{isset($rflag)?'/Referral/create':'/register/create'}}" method="POST">
                            <div class="form-row">
                                <div>
                                    <input type="hidden" id="referred_by" name="referred_by" value="{{ $referred_by }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="cFor">Creating profile for:</label>
                                    <select class="form-control" id="cFor" name="cFor" required>
                                        <option selected>Select</option>
                                        @foreach($fors as $for)
                                            <option value="{{$for->id}}">{{$for->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mt-1 mb-5" id="genderDiv">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="male" name="gender" value="1" class="custom-control-input" required>
                                        <label class="custom-control-label" for="male">Male</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="female" name="gender" value="2" class="custom-control-input" required>
                                        <label class="custom-control-label" for="female">Female</label>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="email" data-toggle="popover" data-trigger="hover" data-placement="top"
                                           data-content="Contact Email Address. Email Verification will be send on this email.">Email:
                                        <span id="msg-2" class="valid-feedback mt-1 ml-2" hidden> </span>
                                    </label>
                                    <div class="spinner-border spinner-border-sm text-info ml-2" id="spinner-2" hidden role="status"></div>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                           value="{{ isset($_GET['email']) ? $_GET['email'] : '' }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="mobile"  data-toggle="popover" data-trigger="hover" data-placement="top"
                                           data-content="Enter your 10 digits mobile number. The OTP will be send on this number">Mobile:
                                        <span id="msg-3" class="valid-feedback mt-1 ml-2" hidden> </span>
                                    </label>
                                    <div class="spinner-border spinner-border-sm text-info ml-2" id="spinner-3" hidden role="status"></div>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile(10 digits)"
                                           value="{{ isset($_GET['mobile']) ? $_GET['mobile'] : '' }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="password" data-toggle="popover" data-trigger="hover" data-placement="top"
                                           data-content="Password must be alphanumeric with atleast one number">Password:
                                        <span id="msg-4" class="valid-feedback mt-1 ml-2" hidden> </span>
                                    </label>
                                    <div class="spinner-border spinner-border-sm text-info ml-2" id="spinner-4" hidden role="status"></div>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password" autocomplete="new-password" required>
                                </div>

                            </div>

                            <button class="btn btn-danger btn-block mt-3" name="create-account-submit" type="submit">{{'Join'}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Testimonial Carousel</h2>
                    </div>
                    <div class="card-body">

                        <div id="carouselTestimonial" class="carousel carousel-testimonial slide" data-ride="carousel">
                            <ol class="carousel-indicators indicator-success">
                                <li data-target="#carouselTestimonial" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselTestimonial" data-slide-to="1"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="card border-0 text-center">
                                        <div class="card-img-wrapper ">
                                            <img src="/assets/img/user/u28.jpg" alt="" class="img-fluid rounded-circle">
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                Very nice website, just register and start searching your love. Other more
                                                important thing about this website is: it is free. Compared to other online
                                                portals which charges thousand of rupees for just 3 or 6 months, jumatrimony
                                                is free. Their customer service is also very fast, efficient and good just
                                                drop your message in the chat box given on lower right corner of your mobile.
                                                I highly recommend, others to register and use this website
                                            </p>
                                            <a class="text-dark pt-4 d-block text-center font-weight-medium font-size-15" href="#">Gopal Srivastava</a>
                                            <span >Master of Computer Application(MCA)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="card border-0 text-center">
                                        <div class="card-img-wrapper">
                                            <img src="/assets/img/user/u27.jpg" alt="" class="img-fluid rounded-circle">
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                Worth trying it, to search your life partner. The website is simple, fast & good
                                                to go for the first timers, it also has tons of new features. And the most important
                                                thing is: it is absolutely free. One time fees of just Rs. 200 is charged for doing
                                                KYC and other charges such as sms notification. Other wise the service is free.
                                                The design is also elegant and great. I highly recommend to all single Indians
                                                to register free and start searching their soul mate
                                            </p>
                                            <a class="text-dark pt-4 d-block text-center font-weight-medium font-size-15" href="#">Sudha Gupta</a>
                                            <span >Bachelor of Medicine & Surgery (MBBS) </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselTestimonial" role="button" data-slide="prev">
                                <span class="mdi mdi-chevron-left mdi-36px" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselTestimonial" role="button" data-slide="next">
                                <span class="mdi mdi-chevron-right mdi-36px" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('app-script')

    @include('request.check_gender')
    @include('request.check_email')
    @include('request.check_mobile')
    @include('request.check_password')

@endsection

