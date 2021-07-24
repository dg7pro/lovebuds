<script>
    $(document).ready(function(){

        // ==================================
        // Email validation
        // Validating user input email
        // ==================================
        $('#email').blur(function () {
            var email = $(this).val();
            $.ajax({
                headers:{
                    'CsrfToken': $('meta[name="photon"]').attr('content'),
                },
                url:"/AjaxRegistration/checkEmail",
                method:'POST',
                data:{em:email},
                dataType:"json",
                success:function (data) {
                    console.log(data);
                    if(data.n == 1){
                        $('#email_ok').attr('hidden',false);
                        $('#email_not_ok').attr('hidden',true);
                        $('#email_msg').text(data.ht).attr('hidden',true).hide();
                    }else{
                        $('#email_ok').attr('hidden',true);
                        $('#email_not_ok').attr('hidden',false);
                        //$('#email_msg').text(data.ht).attr('hidden',false).show();
                        toastr.error(data.ht);
                    }
                    setTimeout(function(){
                        //$('#spinner-2').attr('hidden',true);

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