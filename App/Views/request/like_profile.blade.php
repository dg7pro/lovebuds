<script>
    /*======= 1. Like Profile ========*/
    function likeProfile(other_id){
        console.log(other_id);
        $.ajax({
            url: "/ajax/like-profile",
            method: 'post',
            data: {
                other_id: other_id
            },
            dataType: "text",
            success: function (data, status) {
                var message = data;
                if(toaster.length != 0){
                    if (document.dir != "rtl") {
                        callToaster("toast-top-right",message);
                    } else {
                        callToaster("toast-top-left",message);
                    }
                }
                console.log(data);
                console.log(status);
                $('#like-profile').addClass('disabled');
            }
        });
    }

</script>