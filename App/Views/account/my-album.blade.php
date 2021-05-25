@extends('layouts.app')


@section('page_css')
    <link rel="stylesheet" href="/css/slim.min.css">
@endsection

@section('content')

    <!-- userprofile (up) section starts -->
    <section class="profile">

        <div class="album-card">
            <h3 class="album-heading text-blue">Upload your images here:</h3>
            <p>You can upload maximum of 3 photos. Your images should be single (no group images are allowed), clear, sharp and front facing.</p>

            @if($num<3)
                <div class="image-area">

                        <div class="slim my-images" id="my-cropper"
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

        <div class="album-card">
            <div class="image-area" id="my-album">
                @foreach($images as $image)
                    <div id="{{'my-pic-'.$image->img_id}}">
                        <img src="{{'/uploaded/pics/'.$image->filename}}" class="my-images">
                    </div>
                @endforeach
            </div>

           {{-- <div class="image-area">
                <div class="my-images"><span class="photo-status"><i class="fa fa-window-close text-red" aria-hidden="true"> </i> Rejected</span></div>
                <div class="my-images"><span class="photo-status"><i class="fa fa-clock text-orange" aria-hidden="true"> </i> Pending Approval</span></div>
                <div class="my-images"><span class="photo-status"><i class="fa fa-check text-green" aria-hidden="true"> </i> Approved</span></div>

            </div>--}}

            <div>
                <div><span class=""><i class="fa fa-camera text-blue" aria-hidden="true"> </i> You can upload maximum of 3 photos</span></div>
                <div><span class=""><i class="fa fa-check text-green" aria-hidden="true"> </i> The photo has been approved and visible to others</span></div>
                <div><span class=""><i class="fa fa-clock text-orange" aria-hidden="true"> </i> The photo has been submitted for screening, It is pending approval</span></div>
                <div><span class=""><i class="fa fa-window-close text-red" aria-hidden="true"> </i> The photo has been rejected by our moderation team</span></div>


            </div>

        </div>


    </section>
    <!-- profiles section ends -->


@endsection


@section('js')

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
            watermark.src = '/img/jum-logo4.svg';
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

