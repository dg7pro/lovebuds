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
    function moveProfile(receiver,i,el){
        console.log(receiver);
        console.log(i);
        el
        $.ajax({
            url: "/ajaxActivity/move-profile-to",
            method: 'post',
            data: {
                receiver: receiver,
                i:i
            },
            dataType: "json",
            success: function (data, status) {
                console.log(data);
                console.log(status);
                setTimeout(function(){
                    toastr.success(data.msg);
                }, 1000);
                if(data.flag===true){
                    cuteHide(el);
                }
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
            var el = $(this).closest('.profiles-card');

            // element id elid
            //var elid = el.attr('id');
            //console.log(elid);
            console.log(dataId);

            //Confirm before hiding
            $.confirm({
                title: 'It will hide this profile',
                content: 'If this profile don\'t match your criteria, you can hide it permanently',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Hide',
                        btnClass: 'btn-blue',
                        action: function(){
                            moveProfile(dataId,1,el);
                            //cuteHide(el);
                        }
                    },
                    cancel: function(){},
                }
            });

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
            var el = $(this).closest('.profiles-card');

            // element id elid
            //var elid = el.attr('id');
            console.log(dataId);
            //console.log(elid);

            //Confirm before shortlisting
            $.confirm({
                title: 'It will shortlist this profile',
                content: 'Shortlist favourites profile and then deal one by one',
                icon: 'fa fa-heart',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Shortlist',
                        btnClass: 'btn-blue',
                        action: function(){
                            moveProfile(dataId,2,el);
                            //cuteHide(el);
                        }
                    },
                    cancel: function(){},
                }
            });



        });
    });

</script>