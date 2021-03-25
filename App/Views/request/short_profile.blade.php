<script>
    /*======= 2. Short Profile ========*/
    function favProfile(other_id){
        console.log(other_id);
        $.ajax({
            url: "/ajax/fav-profile",
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
                $('#fav-profile').addClass('disabled');
            }
        });
    }
</script>