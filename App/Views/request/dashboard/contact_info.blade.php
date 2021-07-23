
<script>
    $(document).ready(function () {
        $('#contact-info-update').on('click', function () {

            var ciu = $('#contact-info-update').val();
            var mobile = $('#contactMobile').val();
            var whatsapp = $('#contactWhatsapp').val();

            if($('#one_way_cb').prop("checked") == true){
                var one_way = 1;
                console.log("Checkbox is checked.");
            }
            else if($('#one_way_cb').prop("checked") == false){
                var one_way = 0;
                console.log("Checkbox is unchecked.");
            }
            console.log(one_way);



            $.ajax({
                headers:{
                    'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                    // For Testing
                    //'CsrfToken': '65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1',
                },
                url: "/AjaxUpdate/contactInfo",
                method: 'post',
                data: {
                    ciu:ciu,
                    mobile:mobile,
                    whatsapp:whatsapp,
                    one_way:one_way
                },
                dataType: "json",
                success: function (data, status) {
                    $('#contactsModal').modal('hide');

                    if(data.uok){
                        $('#mb-field').html(data.mb);
                        $('#wa-field').html(data.wa);
                        $('#ow-field').html(data.ow);
                        var message = data.msg;
                        setTimeout(function(){
                            toastr.success(data.msg);
                        }, 500);
                    }else{
                        $.alert({
                            title: 'Alert!',
                            content: 'Please enter only 10 digit mobile no.!',
                        });
                    }
                    console.log(data);
                    console.log(status);
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
