@extends('layouts.app')

@section('title', 'Page Title')

@section('app-css')
    <link rel="stylesheet" href="/css/slim.min.css">
@endsection

@section('content')

    {{--@php
        $picId = random_token(5);
    @endphp--}}

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Photo Album</h2><a href="{{'/account/manage-photo'}}" class="btn btn-sm btn-info ml-2">Manage Photo</a>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12">
                                <p class="mb-5">You can upload maximum of 3 photos. Your images should be single (no group images are allowed), clear, sharp and front facing.
                                    <a href="#" class=""> Upload Image </a>
                                </p>
                            </div>
                            @if($num<3)
                                <div class="col-md-4 col-xl-4" id="slim-container">
                                    <div class="slim" id="my-cropper"
                                         data-ratio="3:4"
                                         data-size="600,800"
                                         data-min-size="300,400"
                                         {{--data-force-size="300,400"--}}  {{--For output image--}}
                                         {{--data-force-min-size="true"--}} {{--For output image--}}
                                         data-filter-sharpen="15"
                                         data-service="/Album/async"
                                         {{--data-meta-pic-id="{{$picId+1}}"--}}
                                         data-did-init="slimInitialised"
                                         data-did-load="isHotEnough"
                                         data-did-transform="imageTransformed"
                                         {{--                     data-will-crop-initial="determineInitialCropRect"--}}
                                         {{--                     data-will-transform="addTextWatermark"--}}
                                         {{--                     data-will-transform="addMask"--}}
                                         data-will-transform="addImageWatermark"
                                         {{--                     data-will-save="showData"--}}
                                         data-did-upload="imageUpload"
                                         data-did-receive-server-error="handleServerError"
                                         data-will-remove="imageWillBeRemoved"
                                         data-did-remove="handleImageRemovalCurrent"
                                    >
                                        <input type="file" name="slim[]"/>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row" id="my-album">
                            @foreach($images as $image)
                                <div class="col-md-4 col-xl-4" id="{{'my-pic-'.$image->img_id}}">
                                    <div class="card mb-4">
                                        <img class="card-img-top" src="{{'/uploaded/pics/'.$image->filename}}">
                                        <div class="card-body">
                                            @if($image->approved==1)
                                                <h5 class="card-title text-success">{{'Approved'}}</h5>
                                                <p class="card-text pb-3">Only approved images are visible to others, this is to done for moderation </p>
                                            @elseif($image->approved==2)
                                                <h5 class="card-title text-danger">{{'Rejected'}}</h5>
                                                <p class="card-text pb-3">This photo has not been approved by moderation, delete & upload new one </p>
                                            @else
                                                <h5 class="card-title text-info">{{'Under Processing'}}</h5>
                                                <p class="card-text pb-3">This photo is under process of approval by our team </p>
                                            @endif


                                            {{--<button class="btn btn-sm btn-outline-primary chgAvt" id="{{'chgAvt-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}" {{$image->pp==1?'disabled':''}}>Change Avatar2</button>--}}

                                            {{--<a href="#" class="btn btn-sm btn-outline-danger">Delete</a>--}}
                                            {{--<button class="btn btn-outline-danger btn-sm delImage" id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Delete</button>--}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-white py-4">
                        <!-- <a href="#" class="btn-link py-3 text-uppercase">View All</a>-->
                        <a href="{{'/account/manage-photo'}}" class="btn btn-sm btn-info ml-2">Manage Photo</a>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('app-script')

    <script src="/js/slim.kickstart.min.js"></script>
    <script>
        function slimInitialised(data) {
            console.log('slim initialised 20');
            console.log(data);
        }
        function isHotEnough(file, image, meta) {

            // average image color
            var averageColor = averagePixelColor(image);

            // color to HSL
            var color = rgbToHsl(averageColor);

            // does the hue part fall in the warm range
            // and is the image not too dark or bright
            if ((color.h > 300 || color.h < 60) &&
                (color.l > 10 && color.l < 90)) {
                return true;
            }

            return 'This image is just not hot enough.';
        }
        function averagePixelColor(image) {

            var context = image.getContext('2d');
            var data = context.getImageData(0, 0, image.width, image.height).data;
            var length = data.length;
            var block = 5;
            var i = -4;
            var count = 0;
            var rgb = {r:0, g:0, b:0};

            while ((i += block * 4) < length) {
                ++count;
                rgb.r += data[i];
                rgb.g += data[i+1];
                rgb.b += data[i+2];
            }

            rgb.r /= count;
            rgb.g /= count;
            rgb.b /= count;

            return rgb;
        }
        function rgbToHsl(color){
            var r = color.r;
            var g = color.g;
            var b = color.b;
            r /= 255, g /= 255, b /= 255;
            var max = Math.max(r, g, b);
            var min = Math.min(r, g, b);
            var h, s, l = (max + min) / 2;

            if(max == min){
                h = s = 0;
            } else {
                var d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch(max){
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                h /= 6;
            }

            return {
                h: h * 360,
                s: s * 100,
                l: l * 100
            }
        }
        function imageTransformed(data) {
            console.log('data transformed');
            console.log(data);
        }
        function determineInitialCropRect(file, done) {

            // determine the initial crop rectangle based on the input file
            var rect = {
                x: 0,
                y: 0,
                width: 300,
                height: 400
            };

            // return the rectangle back to Slim
            done(rect);

            console.log('initial crop');
        }
        function addTextWatermark(data, ready) {

            // get the drawing context for the output image
            var ctx = data.output.image.getContext('2d');

            // draw our watermark on the center of the image
            var size = data.output.width / 20
            ctx.font = size + 'px sans-serif';

            var x = data.output.width * .5;
            var y = data.output.height * .5;
            var text = ctx.measureText('Slim is Awesome');
            var w = text.width * 1.15;
            var h = size * 1.75;

            ctx.fillStyle = 'rgba(0,0,0,.75)';
            ctx.fillRect(
                x - (w * .5),
                y - (h * .5),
                w, h
            );
            ctx.fillStyle = 'rgba(255,255,255,.9)';
            ctx.fillText(
                'Slim is Awesome',
                x - (text.width * .5),
                y + (size * .35)
            );

            // continue saving the data
            ready(data);

        }
        function addMask(data, ready) {

            // get the drawing context for the output image
            var ctx = data.output.image.getContext('2d');

            // only draw image where mask is
            ctx.globalCompositeOperation = 'destination-in';

            ctx.fillStyle = 'black';
            ctx.beginPath();
            ctx.arc(
                data.output.width * .5,
                data.output.height * .5,
                data.output.width * .5,
                0, 2 * Math.PI);
            ctx.fill();

            // restore to default composite operation (is draw over current image)
            ctx.globalCompositeOperation = 'source-over';

            // continue saving the data
            ready(data);

        }
        function addImageWatermark(data, ready) {

            // load the image, in this case the PQINA logo
            var watermark = new Image();
            watermark.onload = function() {

                // set watermark x and y offset to 5% of output image width
                var offset = data.output.width * .05;

                // set watermark width to 25% of the output image width
                var width = data.output.width * .25;
                var height = width * (this.naturalHeight / this.naturalWidth);

                // get the drawing context for the output image
                var ctx = data.output.image.getContext('2d');

                // make watermark transparant
                // https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/globalAlpha
                ctx.globalAlpha = .75;

                // have watermark blend with background image
                // https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/globalCompositeOperation
                ctx.globalCompositeOperation = 'multiply';

                // draw the image
                ctx.drawImage(watermark, offset, offset, width, height);

                // continue saving the data
                ready(data);

            };
            //watermark.src = 'public/images/pqina-logo.svg';
            watermark.src = '/images/jum-logo4.svg';
        }
        function showData(data) {
            console.log('just before saving crop');
            console.log(data);
        }

        // JU=======================================
        // The main function for processing upload
        // =========================================
        function imageUpload(error, data, response) {
            console.log(error, data, response);
            $(document).ready(function () {
                if (response.status=='success') {

                    var element = document.querySelector('#my-cropper');        // get the element with id my-cropper
                    var cropper = Slim.find(element);                           // find the cropper attached to the element
                    cropper.destroy();                                          // call the remove method on the cropper
                    new Slim.create(element);                                   // creating new slim instance
                    $('#my-album').html(response.album)                         // Fetch all the images to display

                }
                if (response.num >= 3 && response.status=='success') {          // Hide the image cropper div if the
                    $('#my-cropper').hide('slow');                              // image no. is greater than 3
                }

            });

        }

        function handleServerError(error, defaultError) {
            console.log('error handling');
            // the error parameter is equal to string set
            // to message property of server response object
            // in this case 'The server is having a bad day'
            console.log(error);

            // the defaultError parameter contains the
            // message set to data-status-unknown-response
            console.log(defaultError);

            return error;
        }

        function imageWillBeRemoved(data, remove) {
            if (window.confirm("Are you sure?")) {
                remove();
            }
        }

    </script>


@endsection
