<script>
    /*======= 1. Like Profile ========*/
    function viewAddress(receiver){
        console.log(receiver);
        $.ajax({
            url: "/ajax/view-address",
            method: 'post',
            data: {
                receiver: receiver
            },
            dataType: "text",
            success: function (data, status) {
                var message = data;
                /*if(toaster.length != 0){
                    if (document.dir != "rtl") {
                        callToaster("toast-top-right",message);
                    } else {
                        callToaster("toast-top-left",message);
                    }
                }*/
                console.log(data);
                console.log(status);
                $('#contact-btn-'+receiver).attr('disabled','disabled');
            }
        });
    }
</script>