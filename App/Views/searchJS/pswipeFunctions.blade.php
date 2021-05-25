<!-- Core JS file -->
<script src="/pswipe/photoswipe.min.js"></script>

<!-- UI JS file -->
<script src="/pswipe/photoswipe-ui-default.min.js"></script>

<!-- http request -->
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
            $('#gallery'+eid).find('figure').each(function() {
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

<!-- ajax request -->
<script>
    $(document).ready(function(){
        $(document).on('click','.ju-album2',function(event) {
            //console.log('ajax request');

            // Init empty gallery array
            var container = [];
            var eid = $(this).data('id');

            // Prevent location change
            event.preventDefault();

            // Loop over gallery items and push it to the array
            $('#gallery'+eid).find('figure').each(function() {
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
    });
</script>
