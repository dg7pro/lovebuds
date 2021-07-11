<script>
    $(document).ready(function(){

        // ==================================
        // Mobile validation
        // Validating user input mobile
        // ==================================
        $('#mobile').blur(function () {
            var mobile = $(this).val();
            $.ajax({
                headers:{
                    'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                },
                url:"/AjaxRegistration/checkMobile",
                method:'POST',
                data:{mb:mobile},
                dataType:"json",
                success:function (data) {
                    console.log(data);
                    if(data.n == 1){
                        $('#mb_ok').attr('hidden',false);
                        $('#mb_not_ok').attr('hidden',true);
                        //$('#mb_msg').text(data.ht).attr('hidden',true).hide();
                    }else{
                        $('#mb_ok').attr('hidden',true);
                        $('#mb_not_ok').attr('hidden',false);
                        toastr.error(data.ht);
                        // $('#mb_msg').removeClass('form-text').addClass('text-red');
                        // $('#mb_msg').text(data.ht).attr('hidden',false).show();
                    }
                    setTimeout(function(){
                        $('#mb_msg-3').text(data.ht).attr('hidden',false).show();
                    }, 500);
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( jqXhr.responseJSON.message );
                    console.log( errorThrown );
                    //console.log( jqXhr.responseText );
                    $.alert({
                        title: 'Security Alert!',
                        content: jqXhr.responseJSON.message + ' Please logout and login after sometime to continue.',
                        icon: 'fa fa-skull',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        buttons: {
                            okay: {
                                text: 'Okay',
                                btnClass: 'btn-blue'
                            }
                        }
                    });
                }
            });
        });




    });
</script>