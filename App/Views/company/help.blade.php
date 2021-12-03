@extends('layouts.app')

@section('page_css')
    <style>

        .contain {
            background-color: #eee;
            max-width: 1170px;
            margin-left: auto;
            margin-right: auto;
            padding: 1em;
        }

        div.form {
            background-color: #eee;
        }
        .contact-wrapper {
            margin: auto 0;
        }

        .submit-btn {
            float: left;
        }
        .reset-btn {
            float: right;
        }

        .form-headline:after {
            content: "";
            display: block;
            width: 10%;
            padding-top: 10px;
            border-bottom: 3px solid #175ca2;
        }

        .highlight-text {
            color: #175ca2;
        }

        .hightlight-contact-info {
            font-weight: 600;
            font-size: 18px;
            line-height: 1.5;
        }

        .highlight-text-grey {
            font-weight: 500;
        }

        .email-info {
            margin-top: 20px;
        }

        ::-webkit-input-placeholder { /* Chrome */
            font-family: 'Roboto', sans-serif;
        }

        .required-input {
            color: black;
        }
        @media (min-width: 600px) {
            .contain {
                padding: 0;
            }
        }

        h3,
        ul {
            margin: 0;
        }

        h3 {
            margin-bottom: 1rem;
        }

        .form-input:focus,
        textarea:focus{
            outline: 1.5px solid #175ca2;
        }

        .form-input,
        textarea {
            width: 100%;
            border: 1px solid #bdbdbd;
            border-radius: 5px;
        }

        .wrapper > * {
            padding: 1em;
        }
        @media (min-width: 700px) {
            .wrapper {
                display: grid;
                grid-template-columns: 2fr 1fr;
            }
            .wrapper > * {
                padding: 2em 2em;
            }
        }

        ul {
            list-style: none;
            padding: 0;
        }

        .contacts {
            color: #212d31;
        }

        .form {
            background: #fff;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }
        form label {
            display: block;
        }
        form p {
            margin: 0;
        }

        .full-width {
            grid-column: 1 / 3;
        }

        button,
        .submit-btn,
        .form-input,
        textarea {
            padding: 1em;
        }

        button, .submit-btn {
            background: transparent;
            border: 1px solid #175ca2;
            color: #175ca2;
            border-radius: 15px;
            padding: 5px 20px;
            text-transform: uppercase;
        }
        button:hover, .submit-btn:hover,
        button:focus , .submit-btn:focus{
            background: #175ca2;
            outline: 0;
            color: #eee;
        }
        .error {
            color: #175ca2;
        }

    </style>
@endsection

@section('content')

    <!-- userprofile (up) section starts -->
    <section class="main">
        <h1 class="large text-info">Need Help?</h1>
        {{--<p class="lead">
            <i class="fas fa-user"></i>
            Content Prepared by Santanu Singh
        </p>--}}
        <div class="dash-buttons">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="btn btn-pink nav-item" id="pills-home-tab" data-toggle="pill" href="#hindi-read"
                       role="tab" aria-controls="pills-home" aria-selected="true">
                        {{--<i class="fas fa-user-circle text-white"></i>--}}
                        Hindi
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-yellow  nav-item" id="pills-profile-tab" data-toggle="pill" href="#english-read"
                       role="tab" aria-controls="pills-profile" aria-selected="false">
                        {{--<i class="fas fa-camera-retro text-white"></i>--}}
                        English
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-blue  nav-item" id="pills-profile-tab" data-toggle="pill" href="#contact-us"
                       role="tab" aria-controls="pills-profile" aria-selected="false">
                        Contact
                    </a>
                </li>


            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">

            {{--Hindi Content--}}
            <div class="tab-pane fade show active" id="hindi-read" role="tabpanel" aria-labelledby="pills-profile-tab">

                <p class="lead">
                    <i class="fas fa-user"></i>
                    इस फ्री मैट्रिमोनियल सर्विस का कैसे उपयोग करें ?
                </p>
                <p class="mb-5">यह लेख श्रद्धा सिंह द्वारा लिखा गया है और गोपाल श्रीवास्तव द्वारा संपादित किया गया है। पढ़ने का समय: <span class="text-blue">पांच मिनट</span></p>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-info">1 डैशबोर्ड </h4>
                        <p class="">आप के अकाउंट मैनेज करने के लिए, सभी अनिवार्य और जरूरी बटन्स यहाँ दिए गये है| यहाँ से आप अपने बायोडाटा में अधिक
                            जानकारी डाल अथवा परिवर्तन कर सकते है; फोटो अपलोड, नए नोटिफिकेशन और कैसा जीवन साथी चाहिए वो भी सेट कर सकते है |
                            <a href="{{'/account/dashboard'}}" class="btn btn-sm btn-yellow"> डैशबोर्ड पर जाएं</a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-info">2 फोटो अपलोड</h4>
                    </div>
                    <div class="col-md-12">
                        <p>फोटो अपलोड करने के लिए मोबाइल फ़ोन्स पर - ग्रे कैनवास पर तप (tap) करे अथवा कंप्यूटर पर इमेज ड्रैग एंड ड्राप
                            (Drag n Drop) भी कर सकते है |</p>
                        <img src="{{'/img/toolbox.jpg'}}" alt="free" height="auto" class="img-thumbnail my-2"/>
                        <p>फोटो अपलोड करने के दौरान आप इन ३ बटनो का उपयोग करना न भूले जोकि, क्रम में इस प्रकार है: बाये से पहला बटन:
                            फोटो परिवर्तन के लिए, मध्य वाला इमेज क्रॉप (Crop) अथवा फिट करने के लिए, और तीसरा बटन सबसे महत्वपूर्ण: आप का
                            फोटो सर्वर पर अपलोड करने के लिए |</p>

                        <p>नोट: आप कुल 3 आछे और बढ़िया फोटो अपने बायोडाटा के साथ जोड़ सकते है |
                           {{-- <a href="{{'/account/my-album'}}" class="text-info">ट्राई करके देखे</a>--}}
                            <a href="{{'/account/my-album'}}" class="btn btn-sm btn-pink"> फोटो अपलोड पेज पर जाएं</a>
                        </p>
                    </div>
                   {{-- <div class="col-md-3">
                        <img src="{{'/img/canvas3.jpg'}}" class="img-thumbnail mb-3" alt="User Image" width="auto" height="100px"/>
                    </div>--}}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-info">3 प्रोफाइल शॉर्टलिस्ट करना </h4>
                        <i class="fas fa-heart fa-3x text-secondary"></i>
                        <p>ये एक महत्वपूर्ण फीचर है - अपने मनपसंदीदा और उपयुक्त, जो भी प्रोफाइल आप को अच्छा लगे  सबसे पहले उसे शॉर्टलिस्ट
                            करेले | फिर अपने शॉर्टलिस्टेड प्रोफाइल में से एक-एक कर संपर्क करे - शादी तुरंत हो जाये गी|
                            आप का किया हुवा सभी शॉर्टलिस्ट प्रोफाइल: सर्च पेज के शॉर्टलिस्ट टैब में दिखेगा |
                            <a href="{{'/search/index'}}" class="btn btn-sm btn-coco"> सर्च पेज पर जाएं</a>

                        </p>
                    </div>

                </div>

                <div class="row mb-2">

                    <div class="col-md-12">
                        <h4 class="text-info">4 फ्री सर्विस </h4>
                        <i class="fa fa-rupee-sign fa-3x text-secondary" aria-hidden="true"></i>
                        <p>या सर्विस फ्री क्यों है ? आप की शादी तुरंत हो, आप को मनचाहा वर वधु मिले, इसके लिए सभी का एक जगह होना अनिवार्य है -
                            और सभी इच्छुक वर वधु एक जगह हो इसके लिए सर्विस का फ्री होना ज़रूरी है |
                        </p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-info">5 व्हाट्सप्प शेयरिंग </h4>
                        <i class="fa fa-share fa-3x text-secondary" aria-hidden="true"></i>
                        <p>आप अपनी और दूसरो की प्रोफाइल व्हाट्सप्प पर सरलता से शेयर कर सकते है|  बस यह शेयर का आइकॉन बटन पहचाने |
                            अपने मित्रो और परिवार जनो से उपयुक्त प्रोफाइल शेयर कर, उनसे सलाह ले और बताये |</p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-info">6 व्हाट्सप्प इंटरेस्ट</h4>
                        <i class="fab fa-whatsapp fa-3x text-secondary" aria-hidden="true"></i>
                        <p>व्हाट्सप्प इंटरेस्ट सेंड और रिसीव करने के लिए सभी का व्हाट्सप्प नंबर सही होना चाहिए, अन्यथा व्हाट्सअप मैसेज सेन्डर रोक देगा|
                            व्हाट्सप्प इंटरेस्ट के जरिये आप डायरेक्ट पार्टी के व्हाट्सअप पर अपना इंटरेस्ट और प्रोफाइल बेज सकते है - यह एक मजेदार फीचर है,
                            जो की बिलकुल फ्री है |</p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <h4 class="text-info">7 कांटेक्ट देखना</h4>
                    </div>
                    <div class="col-md-12">
                        <p>
                            आप किसी भी मेंबर का कांटेक्ट नंबर और ईमेल देख सकते है, और शादी के लिए उनके माता पिता या अभिभावक से संपर्क कर सकते है
                            कांटेक्ट देखने के लिए कांटेक्ट बटन दबाये </p>
                    </div>

                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-info">8 सिक्योरिटी</h4>
                        <img src="{{'/img/padlock.jpg'}}" alt="free" height="auto" class="img-thumbnail my-2"/>
                        <p>इस वेबसाइट के सभी डाटा एन्क्रिप्टेड फॉर्म (256 bit encryption) में बजे और रिसीव किये जाते है -
                            इसका प्रमाड है ताले (padlock) का आइकॉन, जो की इस वेबसाइट को प्राप्त है|
                        </p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-info">9 प्राइवेसी</h4>
                        <p>कोई भी मेंबर चाहे तो अपना कांटेक्ट डिटेल्स (Contact number और email) हाईड कर सकता है | कांटेक्ट डिटेल्स हाईड
                            करने के लिए आप को एक तरफ़ा संपर्क (one-way communication)  ऑन करना होगा, इससे आप का नंबर कोई नहीं देख
                            सकता पर आप सभी का देख सकते है - यह फीचर विशेष कर महिलाओ के लिए है | परन्तु अगर कोई आप से संपर्क करता है
                            तो आप को नोटिफिकेशन मिलेगा और आप इच्छा अनुसार उससे संपर्क कर सकते है </p>
                        <p>कांटेक्ट डिटेल्स हाईड करने के लिए डैशबोर्ड (Dashboard) के माय प्रोफाइल (My Profile) टैब में जाये | अंतिम सेक्शन
                            कॉन्टेक्ट्स का है एडिट (Edit) कर  (one-way communication)  ऑन करे |
                        </p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <h4 class="text-info">10 नोटिफिकेशन</h4>
                        <p>आप से संभंधित सभी जरूरी सूचनाएं आप को नोटिफिकेशन के जरिये दी जाती है - जो की डैशबोर्ड के नोटिफिकेशन टैब में उप्लब्द है |</p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <h4 class="text-info">11 फेसबुक शेयर </h4>
                        <p>अगर आप चाहते है की आप को ज्यादा प्रोफाइल्स में से अपना जीवन साथी चुनें को मिले तो आसानी से इस वेबसाइट को अपने
                            दोस्तों के साथ शेयर करें | शेयर करने के लिए डैशबोर्ड के शेयर टैब में जायें|  शेयर करने पर हम १०० क्रेडिट्स + फ्री कस्टमर
                            सर्विस, उप्लब्द करवाते है |
                        </p>
                        <p>
                            <a class="btn btn-blue" id="shareBtn">
                                <i class="fab fa-facebook text-white"></i>
                                Share on Facebook
                            </a>
                        </p>


                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <p>किसी भी अन्य सहायता एवं जानकारी के लिए सबसे नीचे दाईं ओर चैट बटन: क्लिक करें|</p>
                        <p>
                            ~ टीम<br>
                            जे. यू. मॅट्रिमोनी सर्विस<br>
                            www.jumatrimony.com
                        </p>
                    </div>
                </div>

            </div>
            {{--End the Hindi--}}



            {{--English--}}
            <div class="tab-pane fade" id="english-read" role="tabpanel" aria-labelledby="pills-profile-tab">

                {{--<div>
                    <img src="{{'/img/'.($authUser->gender==1?'groom-grayscale.jpg':'bride-grayscale.jpg')}}" class="img-thumbnail" alt="User Image" width="225px" height="auto"/>
                </div>--}}
                <div class="my-3">Coming soon...</div>
                {{--<div>

                    <div><span class=""><i class="fa fa-upload text-blue" aria-hidden="true"></i> Upload and save your photo on server</span></div>
                    <div><span class=""><i class="fa fa-crop text-info" aria-hidden="true"></i> Crop and adjust your photo with photo edit tool before final uploading</span></div>
                    <div><span class=""><i class="fa fa-trash text-red" aria-hidden="true"></i> Replace photo with better one  </span></div>

                </div>--}}

            </div>

            {{--English--}}
            <div class="tab-pane fade" id="contact-us" role="tabpanel" aria-labelledby="pills-profile-tab">

                {{--<div class="my-3">

                    <h4 class="mt-5 text-blue">Just Unite Foundation </h4>

                    <div class="text-secondary">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        <b>Visit us: www.JuMatrimony.com</b>
                    </div>
                    <div class="text-secondary">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <b>Email: JuMatrimony@gmail.com</b>
                    </div>
                    <div class="text-secondary">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <b>Contact: +91 9335683398</b>
                    </div>
                    <div class="text-secondary">
                        <i class="fab fa-whatsapp fa-bold" aria-hidden="true"></i>
                        <b>Whatsapp: +91 9335683398</b>
                    </div>




                </div>
--}}

                <div class="contain">

                    <div class="wrapper">

                        <div class="form">
                            {{--<h4>GET IN TOUCH</h4>--}}
                            <h3 class="form-headline">Send us a message</h3>
                            <form id="submit-form" action="">
                                <p>
                                    <input id="name" class="form-input" type="text" placeholder="Your Name*">
                                    <small class="name-error"></small>
                                </p>
                                <p>
                                    <input id="email" class="form-input" type="email" placeholder="Your Email*">
                                    <small class="name-error"></small>
                                </p>
                                <p class="full-width">
                                    <input id="subject" class="form-input" type="text" placeholder="Company Name*" required>
                                    <small></small>
                                </p>
                                <p class="full-width">
                                    <textarea  minlength="20" id="message" cols="30" rows="7" placeholder="Your Message*" required></textarea>
                                    <small></small>
                                </p>
                                <p class="full-width">
                                    <input type="checkbox" id="checkbox" name="checkbox" checked> Yes, I would like to receive communications by call / email about Company's services.
                                </p>
                                <p class="full-width">
                                    <input type="submit" class="submit-btn" value="Submit" onclick="checkValidations()">
                                    {{--<button class="reset-btn" onclick="reset()">Reset</button>--}}
                                </p>
                            </form>
                        </div>

                        <div class="contacts contact-wrapper">

                            <ul>
                                <li>Please feel free to contact us for any type query or support. </li>
                                <span class="hightlight-contact-info">
                                  <li class="email-info"><i class="fa fa-envelope" aria-hidden="true"></i> contact@jumatrimony.com</li>
                                  <li><i class="fa fa-phone" aria-hidden="true"></i> <span class="highlight-text">+91 93356 83398</span></li>
                                  <li><i class="fab fa-whatsapp" aria-hidden="true"></i> <span class="highlight-text">+91 93356 83398</span></li>
                                </span>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- profiles section ends -->


@endsection

@section('js')


    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '489039115878297',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v10.0'
            });
        };
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script>
        document.getElementById('shareBtn').onclick = function() {
            FB.ui({
                display: 'popup',
                method: 'share',
                href: 'https://www.jumatrimony.com/home/index',
            }, function(response){
                console.log(response);
                if(response){
                    console.log('response came back');
                    var fb = true;

                }else{
                    console.log('response did not came back');
                }
            });
        }
    </script>



    <!--Start of Tawk.to Script-->
    {{--<script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/610665ce649e0a0a5cceec12/1fc0frd2m';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>--}}
    <!--End of Tawk.to Script-->

    <script>
        const nameEl = document.querySelector("#name");
        const emailEl = document.querySelector("#email");
        const subjectEl = document.querySelector("#subject");
        const messageEl = document.querySelector("#message");

        const form = document.querySelector("#submit-form");

        function checkValidations() {
            let letters = /^[a-zA-Z\s]*$/;
            const name = nameEl.value.trim();
            const email = emailEl.value.trim();
            const subject = subjectEl.value.trim();
            const message = messageEl.value.trim();
            if (name === "") {
                document.querySelector(".name-error").classList.add("error");
                document.querySelector(".name-error").innerText =
                    "Please fill out this field!";
            } else {
                if (!letters.test(name)) {
                    document.querySelector(".name-error").classList.add("error");
                    document.querySelector(".name-error").innerText =
                        "Please enter only characters!";
                } else {

                }
            }
            if (email === "") {
                document.querySelector(".name-error").classList.add("error");
                document.querySelector(".name-error").innerText =
                    "Please fill out this field!";
            } else {
                if (!letters.test(name)) {
                    document.querySelector(".name-error").classList.add("error");
                    document.querySelector(".name-error").innerText =
                        "Please enter only characters!";
                } else {

                }
            }
        }

       /* function reset() {
            nameEl = "";
            emailEl = "";
            subjectEl = "";
            messageEl = "";
            document.querySelector(".name-error").innerText = "";
        }*/

    </script>

@endsection