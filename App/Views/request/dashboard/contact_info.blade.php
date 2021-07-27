
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
                }
            });
        });
    });
</script>
