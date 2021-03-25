<script>
    function likeProfile(uid){
        console.log(uid);
        $.ajax({
            url: "like_profile.php",
            method: 'post',
            data: {
                uid: uid
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