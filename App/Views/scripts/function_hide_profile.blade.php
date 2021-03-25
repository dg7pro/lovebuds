<script>
    function hideProfile(uid){
        console.log(uid);
        $.ajax({
            url: "hide_profile.php",
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
                $('#hide-profile').addClass('disabled');
            }
        });
    }
</script>