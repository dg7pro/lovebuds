<script>
    $(document).ready(function(){
        // ==================================
        // Mobile validation
        // Validating user input mobile
        // ==================================
        $('#mobile').blur(function () {
            var mobile = $(this).val();
            $.ajax({
                url:"/AjaxRegistration/checkMobile",
                method:'POST',
                data:{mb:mobile},
                dataType:"json",
                success:function (data) {
                    console.log(data);
                    if(data.n == 1){
                        $('#mb_ok').attr('hidden',false);
                        $('#mb_not_ok').attr('hidden',true);
                    }else{
                        $('#mb_ok').attr('hidden',true);
                        $('#mb_not_ok').attr('hidden',false);
                        toastr.error(data.ht);
                    }
                    setTimeout(function(){
                        $('#mb_msg-3').text(data.ht).attr('hidden',false).show();
                    }, 500);
                }
            });
        });
    });
</script>