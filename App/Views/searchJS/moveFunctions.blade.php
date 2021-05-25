<script>
    // Animated element removal
    function cuteHide(el) {
        el.animate({opacity: '0'}, 750, function(){
            el.animate({height: '0px'}, 750, function(){
                el.remove();
            });
        });
    }

    // Move profile either to shortlist or hide list
    function moveProfile(receiver,i){
        console.log(receiver);
        console.log(i);
        $.ajax({
            url: "/ajax/move-profile",
            method: 'post',
            data: {
                receiver: receiver,
                i:i
            },
            dataType: "text",
            success: function (data, status) {
                console.log(data);
                console.log(status);
                setTimeout(function(){
                    toastr.success(data);
                }, 1000);
                //$('#hide-profile').addClass('disabled');
            }
        });
    }

    /* for http request */
    /*$('.downlist').on('click', function(){
        var dataId = $(this).attr("data-id");
        console.log(dataId);
        moveProfile(dataId,1);
        var el = $(this).closest('.profiles-card');
        cuteHide(el);
    });*/

    /* for ajax request */
    $(document).ready(function(){
        $(document).on('click','.downlist',function() {
            var dataId = $(this).attr("data-id");
            console.log(dataId);
            moveProfile(dataId,1);
            var el = $(this).closest('.profiles-card');
            cuteHide(el);
        });
    });

    /* for http request */
    /*$('.shortlist').on('click', function(){

        var dataId = $(this).attr("data-id");
        console.log(dataId);
        moveProfile(dataId,2);
        var el = $(this).closest('.profiles-card');
        cuteHide(el);
    });*/

    /* for ajax request */
    $(document).ready(function(){
        $(document).on('click','.shortlist',function() {
            var dataId = $(this).attr("data-id");
            console.log(dataId);
            moveProfile(dataId,2);
            var el = $(this).closest('.profiles-card');
            cuteHide(el);
        });
    });

</script>